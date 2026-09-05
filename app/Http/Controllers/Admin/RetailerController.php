<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RetailerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $retailers = User::where('role_id', 2)->get();
        return view('admin.retailers.list', compact('retailers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.retailers.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'billing_name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'gst_number' => 'nullable|string',
            'billing_address' => 'required',
            'password' => 'required|string|min:8',
            // 'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            User::create([
                'billing_name' => $request->input('billing_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
                'role_id' => $request->input('role_id'),
                'gst_number' => $request->input('gst_number'),
                'billing_address' => $request->input('billing_address'),
                'status' => $request->input('status') ?? 'pending',
            ]);

            DB::commit();
            return redirect()->route('admin.retailers.index')->with('success', 'Retailer added successfully');
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
        $retailer = User::findOrFail($id);
        return view('admin.retailers.show', compact('retailer'));
    }

    public function status(Request $request, string $id)
    {
        $retailer = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,suspended',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $retailer->status = $request->input('status');
        $retailer->save();

        return redirect()->route('admin.retailers.show', $retailer->id)->with('success', 'Retailer status updated successfully');
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
        try {
            $user = User::with('orders')->findOrFail($id);
            // Check for user order
            // $orderCount = $user->orders()->whereNotIn('status', ['cancelled', 'delivered'])->count();
            // if ($orderCount > 0) {
            //     return redirect()->route('admin.retailers.index')->with('error', 'Cannot delete retailer with existing orders.');
            // }
            $user->status = 'suspended';
            $user->save();
            return redirect()->route('admin.retailers.index')->with('success', 'Retailer deactivated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',  $th->getMessage());
        }
    }
}
