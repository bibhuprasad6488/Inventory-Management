<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PackSize;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get()->map(function ($product) {
            $product->image = $product->image ? asset('uploads/product/' . $product->image) : asset('admin/img/no-img.png');
            return $product;
        });
        return view('admin.products.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packSizes = PackSize::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('admin.products.add', compact('packSizes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|unique:products,product_name',
            'hsn' => 'required|unique:products,hsn',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'pack_size' => 'required|exists:pack_sizes,id',
            'mrp' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'status' => 'required|in:1,0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {

            $slug = Str::slug($request->product_name);

            $product = new Product();
            $product->product_name = $request->product_name;
            $product->slug = $slug;
            $product->hsn = $request->hsn;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->pack_size = $request->pack_size;
            $product->mrp = $request->mrp;
            $product->cost_price = $request->cost_price;
            $product->selling_price = $request->selling_price;
            $product->status = $request->status;

            $destinationPath = public_path('uploads/product/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $pImage = $slug . '_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $pImage);
                $product->image = $pImage;
            }

            $product->save();
            DB::commit();
            return redirect()->route('admin.products.index')->with('status', 'Product created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $product->image = $product->image ? asset('uploads/product/' . $product->image) : asset('admin/img/no-img.png');
        $packSizes = PackSize::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('admin.products.edit', compact('packSizes', 'categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|unique:products,product_name,' . $id,
            'hsn' => 'required|string|unique:products,hsn,' . $id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'pack_size' => 'required|exists:pack_sizes,id',
            'mrp' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'status' => 'required|in:1,0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $slug = Str::slug($request->product_name);
            $product->product_name = $request->product_name;
            $product->slug = $slug;
            $product->hsn = $request->hsn;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->pack_size = $request->pack_size;
            $product->mrp = $request->mrp;
            $product->cost_price = $request->cost_price;
            $product->selling_price = $request->selling_price;
            $product->status = $request->status;

            $destinationPath = public_path('uploads/product/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $pImage = $slug . '_' . time() . '_' . $file->getClientOriginalName();

                if (!empty($product->image)) {
                    $oldFilePath = $destinationPath . $product->image;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $pImage);
                $product->image = $pImage;
            }

            $product->save();
            DB::commit();
            return redirect()->route('admin.products.index')->with('status', 'Product updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::findOrFail($id);
        try {
            $destinationPath = public_path('uploads/product/');
            if (!empty($product->image)) {
                $oldFilePath = $destinationPath . $product->image;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $product->delete();
            return redirect()->route('admin.products.index')->with('status', 'Product deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
