<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all()->map(function ($category) {
            $category->img_path = $category->img_path ? asset('uploads/category/' . $category->img_path) : asset('admin/img/no-img.png');
            return $category;
        });
        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.categories.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:categories,title',
            'parent_category' => 'nullable',
            'img_path' => 'required',
            'status' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $slug = Str::slug(trim($request->title));
            $category = new Category();
            if ($request->parent_category) {
                $category->parent_category = $request->parent_category;
            }
            $category->title = $request->title;
            $category->slug = $slug;
            $category->status = $request->status;



            $destinationPath = public_path('uploads/category/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $catImage = $slug . '_' . time() . '_' . $file->getClientOriginalName();
                $file->move($destinationPath, $catImage);
                $category->img_path = $catImage;
            }
            $category->save();
            DB::commit(); // ✅ IMPORTANT

            return redirect()->route('admin.categories.index')->with('success', 'Category Added Successfully');
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

        $pCategories = Category::where('status', 1)->get();
        $category = Category::find($id);
        if ($category) {
            $category->img_path = $category->img_path ? asset('uploads/category/' . $category->img_path) : asset('admin/img/no-img.png');
        }
        return view('admin.categories.edit', compact('pCategories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:categories,title,' . $id,
            'parent_category' => 'nullable',
            'img_path' => 'required',
            'status' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $category = Category::find($id);
            $slug = Str::slug(trim($request->title));
            if ($request->parent_category) {
                $category->parent_category = $request->parent_category;
            }
            $category->title = $request->title;
            $category->slug = $slug;
            $category->status = $request->status;



            $destinationPath = public_path('uploads/category/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $catImage = $slug . '_' . time() . '_' . $file->getClientOriginalName();


                if (!empty($category->img_path)) {
                    $oldFilePath = $destinationPath . $category->img_path;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file->move($destinationPath, $catImage);
                $category->img_path = $catImage;
            }
            $category->save();
            DB::commit(); // ✅ IMPORTANT

            return redirect()->route('admin.categories.index')->with('success', 'Category Updated Successfully');
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
        $category = Category::with('products')->find($id);

        // find any products associated with this category
        $products = $category->products;
        if ($products->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category with associated products.');
        }
        try {
            $destinationPath = public_path('uploads/category/');
            if (!empty($category->img_path)) {
                $oldFilePath = $destinationPath . $category->img_path;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category Deleted Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.categories.index')->with('error',  $th->getMessage());
        }
    }
}
