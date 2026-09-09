<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentCollection;
use App\Models\PushNotification;
use App\Models\User;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payment_collections.index');
    }


    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with this phone number.'
            ], 404);
        }

        // /*
        // |--------------------------------------------------------------------------
        // | Get Latest Delivered Order
        // |--------------------------------------------------------------------------
        // */

        $order = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->with('orderDetails')
            ->latest('created_at')
            ->first();


        // /*
        // |--------------------------------------------------------------------------
        // | Last Order
        // |--------------------------------------------------------------------------
        // */

        $lastOrder = null;

        if ($order) {

            $lastOrder = [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'amount' => $order->amount,
                'due_amount' => $order->due_amount,
                'status' => $order->status,
                'created_at' => $order->created_at
                    ? $order->created_at->format('d M Y, h:i A')
                    : '',
            ];
        }


        // /*
        // |--------------------------------------------------------------------------
        // | Payment Collections
        // |--------------------------------------------------------------------------
        // */

        $collections = [];

        if ($order) {

            $collections = PaymentCollection::where('user_id', $user->id)
                ->where('order_id', $order->id)
                ->orderByDesc('id')
                ->get()
                ->map(function ($collection) {

                    return [
                        'id' => $collection->id,
                        'received_amount' => $collection->received_amount,
                        'mode_of_payment' => $collection->mode_of_payment,
                        'received_date' => $collection->received_date
                            ? Carbon::parse($collection->received_date)
                            ->format('d-M-Y')
                            : '',
                    ];
                })
                ->values();
        }

        return response()->json([

            'success' => true,

            'user' => [
                'id' => $user->id,
                'name' => $user->billing_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'billing_address' => $user->billing_address,
                'gst_number' => $user->gst_number,
                'due_amount' => $user->due_amount,
            ],

            'last_order' => $lastOrder,

            'collections' => $collections,

        ]);
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
    public function store(Request $request, FcmService $fcm)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'due_amount' => 'required',
            'order_number' => 'required',
            'received_amount' => 'required',
            'mode_of_payment' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            $collection = new PaymentCollection();
            $collection->user_id = $request->user_id;
            $collection->order_id = $request->order_id;
            $collection->received_amount = $request->received_amount;
            $collection->order_number = $request->order_number;
            $collection->received_amount = $request->received_amount;
            $collection->mode_of_payment = $request->mode_of_payment;
            $collection->received_date = Carbon::now()->format('Y-m-d');

            $collection->save();
            DB::commit();

            // Send FCM Notification
            $user = User::findOrFail($request->user_id);
            $user->decrement('due_amount', $request->received_amount);
            $pushNotification = PushNotification::where('user_id', $user->id)
                ->where('is_active', true)
                ->first();

            if ($pushNotification && $pushNotification->push_token) {

                $pushNot = $fcm->sendToToken(
                    $pushNotification->push_token,
                    'Payment Collection',
                    "Hello {$user->billing_name}, your order has been delivered.",
                    [
                        'type' => 'payment',
                        'order_id' => (string) $request->order_id,
                        'order_number' => (string) $request->order_number,
                        // 'status' => (string) $order->status,
                    ]
                );

                Log::info('Push notification sent for payment collection', [
                    'order_id' => $request->order_id,
                    'user_id' => $request->user_id,
                    'push_response' => $pushNot,
                ]);
            }

            return back()->with('success', 'Payment Collected successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
