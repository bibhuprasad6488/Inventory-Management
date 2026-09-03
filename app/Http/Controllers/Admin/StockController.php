<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('packSize')->where('status', 1)->get();
        return view('admin.stocks.add', compact('products'));
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
        $validator = Validator::make($request->all(), [
            'p_id' => 'required|array|min:1',
            'p_id.*' => 'required|exists:products,id|distinct',
            'stocks' => 'required|array|min:1',
            'stocks.*' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('error', $validator->errors()->first());
        }

        // Make sure both arrays contain the same number of records
        if (count($request->p_id) !== count($request->stocks)) {
            return back()->withInput()->with('error', 'Invalid product and stock data.');
        }
        
        DB::beginTransaction();
        try {

            foreach ($request->p_id as $key => $productId) {
                $stock = $request->stocks[$key];
                Product::where('id', $productId)->increment('stock', $stock);
            }

            DB::commit();
            return redirect()->route('admin.stocks.index')->with('success', 'Stock updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            // Log::error('Stock update failed', ['error' => $th->getMessage()]);
            return back()->withInput()->with('error', $th->getMessage());
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
