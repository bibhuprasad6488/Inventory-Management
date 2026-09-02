<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function categories(Request $request)
    {
        $categories = Category::where('status', 1)->get()->map(function ($category) {
            $products = Product::where('category_id', $category->id)->get();
            $category->products_count = $products->count();
            $category->img_path = $category->img_path ? asset('uploads/category/' . $category->img_path) : asset('admin/img/no-img.png');
            // $category->products = $category->products->map(function ($product) {
            //     $product->img_path = $product->img_path ? asset('uploads/product/' . $product->img_path) : asset('admin/img/no-img.png');
            //     return $product;
            // });
            return $category;
        });

        return response()->json($categories);
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
