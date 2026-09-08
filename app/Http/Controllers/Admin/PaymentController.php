<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

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
        $request->validate([
            'phone' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with this phone number.'
            ], 404);
        }

        $lastOrder = Order::where('user_id', $user->id)->where('status', 'delivered')->with('orderDetails')
            ->latest('created_at')
            ->first();

        return response()->json([

            'success' => true,

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'billing_address' => $user->billing_address,
                'gst_number' => $user->gst_number,
                'due_amount' => $user->due_amount,
            ],

            'last_order' => $lastOrder ? [
                'id' => $lastOrder->id,
                'order_number' => $lastOrder->order_number,
                'amount' => $lastOrder->amount,
                'due_amount' => $lastOrder->due_amount,
                'status' => $lastOrder->status,
                'created_at' => optional($lastOrder->created_at)
                    ->format('d M Y, h:i A'),

            ] : null,

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
    public function store(Request $request)
    {
        //
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
