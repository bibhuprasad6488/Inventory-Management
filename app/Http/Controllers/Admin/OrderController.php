<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\PushNotification;
use App\Models\User;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('retailer')->get();
        return view('admin.orders.list', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('retailer', 'orderDetails')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, FcmService $fcm)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,cancelled,delivered',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {

            $order = Order::with(['orderDetails', 'retailer'])->findOrFail($id);

            $newStatus = $request->status;
            $oldStatus = $order->status;
            $dueAmount = 0;

            if ($oldStatus === 'pending' && $newStatus === 'cancelled') {

                $order->status = 'cancelled';

                $notificationTitle = 'Order Update';
                $notificationBody = "Hello {$order->retailer->billing_name}, your order has been cancelled.";
            } elseif ($oldStatus === 'pending' && $newStatus === 'processing') {

                foreach ($order->orderDetails as $od) {

                    $product = Product::findOrFail($od->product_id);

                    if ($product->stock < $od->qty) {
                        throw new \Exception(
                            "Insufficient stock for product: {$product->product_name}"
                        );
                    }

                    $product->decrement('stock', $od->qty);
                }

                $order->status = 'processing';

                $notificationTitle = 'Order Update';
                $notificationBody = "Hello {$order->retailer->billing_name}, your order is being processed.";
                $dueAmount = $order->amount;
                User::where('id', $order->user_id)->increment('due_amount', $dueAmount);
            } elseif ($oldStatus === 'processing' && $newStatus === 'cancelled') {

                foreach ($order->orderDetails as $od) {

                    Product::where('id', $od->product_id)
                        ->increment('stock', $od->qty);
                }

                $order->status = 'cancelled';

                $notificationTitle = 'Order Update';
                $notificationBody = "Hello {$order->retailer->billing_name}, your order has been cancelled.";
                $dueAmount = $order->amount;
                User::where('id', $order->user_id)->decrement('due_amount', $dueAmount);
            } elseif ($oldStatus === 'processing' && $newStatus === 'delivered') {

                $order->status = 'delivered';

                $notificationTitle = 'Order Update';
                $notificationBody = "Hello {$order->retailer->billing_name}, your order has been delivered.";
            } else {

                throw new \Exception(
                    "Invalid order status transition: {$oldStatus} → {$newStatus}"
                );
            }

            $order->save();

            DB::commit();

            $pushNotification = PushNotification::where('user_id', $order->user_id)
                ->where('is_active', true)
                ->first();

            if ($pushNotification && $pushNotification->push_token) {

                $pushNot =   $fcm->sendToToken(
                    $pushNotification->push_token,
                    $notificationTitle,
                    $notificationBody,
                    [
                        'type' => 'order',
                        'order_id' => (string) $order->id,
                        'order_number' => (string) $order->order_number,
                        'status' => (string) $order->status,
                    ]
                );

                Log::info('Push notification sent', [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'push_response' => $pushNot,
                ]);
            }

            return redirect()
                ->route('admin.orders.show', $id)
                ->with('success', 'Order status updated successfully.');
        } catch (\Throwable $th) {

            DB::rollBack();

            Log::error('Order status update failed', [
                'order_id' => $id,
                'message' => $th->getMessage(),
            ]);

            return back()->with('error', $th->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
