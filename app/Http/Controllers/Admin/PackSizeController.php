<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packSizes = PackSize::all();
        return view('admin.packsizes.list', compact('packSizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packsizes.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qty' => 'required|unique:pack_sizes,qty',
            'status' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        try {
            $packSize = new PackSize();
            $packSize->qty = $request->qty;
            $packSize->status = $request->status;
            $packSize->save();

            return redirect()->route('admin.pack-sizes.index')->with('success', 'Pack Size created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
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
