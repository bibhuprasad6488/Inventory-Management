<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function categories(Request $request)
    {
        $categories = Category::where('status', 1)->withCount(['products' => function ($query) {
            $query->where('status', 1);
        }])->get()->map(function ($category) {
            $category->img_path = $category->img_path ? asset('uploads/category/' . $category->img_path) : asset('admin/img/no-img.png');
            return $category;
        });
        // Hide Parent Category field from response
        $categories->makeHidden('parent_category');

        return response()->json(['status' => 'success', 'data' => $categories]);
    }

    public function catWithProducts(Request $request, $slug)
    {
        $category = Category::with(['products' => function ($query) use ($request) {
            $query->where('status', 1);
            if ($request->query('pack_size')) {
                $query->where('pack_size', $request->pack_size);
            }
            if ($request->query('min_price') && $request->query('max_price')) {
                $query->whereBetween('selling_price', [$request->min_price, $request->max_price]);
            }
            if ($request->query('sort_by')) {
                if ($request->sort_by == 'price_asc') {
                    $query->orderBy('selling_price', 'asc');
                } elseif ($request->sort_by == 'price_desc') {
                    $query->orderBy('selling_price', 'desc');
                } elseif ($request->sort_by == 'name_asc') {
                    $query->orderBy('product_name', 'asc');
                } elseif ($request->sort_by == 'name_desc') {
                    $query->orderBy('product_name', 'desc');
                }
            }
            if ($request->query('search')) {
                $query->where('product_name', 'LIKE', '%' . $request->search . '%');
            }
        }])->where('slug', $slug)->where('status', 1)->first();
        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Category not found'], 404);
        }
        $category->img_path = $category->img_path ? asset('uploads/category/' . $category->img_path) : asset('admin/img/no-img.png');
        $category->products->transform(function ($product) {
            $product->pack_size = $product->packSize->qty ?: null;
            $product->image = $product->image ? asset('uploads/product/' . $product->image) : asset('admin/img/no-img.png');
            // Remove relationship from API response
            unset($product->packSize);
            return $product;
        });
        return response()->json(['status' => 'success', 'data' => $category]);
    }


    public function products(Request $request)
    {
        $products = Product::where('status', 1);

        if ($request->query('pack_size')) {
            $products->where('pack_size', $request->pack_size);
        }
        if ($request->query('min_price') && $request->query('max_price')) {
            $products->whereBetween('selling_price', [$request->min_price, $request->max_price]);
        }
        if ($request->query('sort_by')) {
            if ($request->sort_by == 'price_asc') {
                $products->orderBy('selling_price', 'asc');
            } elseif ($request->sort_by == 'price_desc') {
                $products->orderBy('selling_price', 'desc');
            } elseif ($request->sort_by == 'name_asc') {
                $products->orderBy('product_name', 'asc');
            } elseif ($request->sort_by == 'name_desc') {
                $products->orderBy('product_name', 'desc');
            }
        }
        if ($request->query('search')) {
            $products->where('product_name', 'LIKE', '%' . $request->search . '%');
        }

        $products = $products->get()->map(function ($product) {
            $product->pack_size = $product->packSize ? $product->packSize->qty : null;
            $product->image = $product->image ? asset('uploads/product/' . $product->image) : asset('admin/img/no-img.png');
            // Remove relationship from API response
            unset($product->packSize);
            return $product;
        });

        return response()->json(['status' => 'success', 'data' => $products]);
    }

    public function createOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'product_name' => 'required|array|min:1',
            // 'product_name.*' => 'required|string|exists:products,product_name',

            'pack_size' => 'required|array|min:1',
            'pack_size.*' => 'required',

            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',

            'cost_price' => 'required|array|min:1',
            'cost_price.*' => 'required|numeric|min:0',

            'order_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }
        // return response()->json(['status' => 'success', 'message' => 'User authenticated', 'user' => $request->all()]);

        DB::beginTransaction();

        try {
            $orderNumber = 'OR' . time();

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'amount' => $request->order_amount,
                'order_date' => Carbon::now()->format('Y-m-d'),
            ]);

            foreach ($request->product_name as $k => $v) {
                $orderDetails = new OrderDetail();

                $orderDetails->order_id = $order->id;
                $orderDetails->product_name = $v;
                $orderDetails->pack_size = $request->pack_size[$k];
                $orderDetails->qty = $request->qty[$k];
                $orderDetails->cost_price = $request->cost_price[$k];

                $orderDetails->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'data' => $orderNumber
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUserOrders(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $orders = Order::where('user_id', $user->id)->with('orderDetails')->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }
}
