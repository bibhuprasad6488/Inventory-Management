<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ride;
use App\Models\RideBooking;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check() || Auth::user()->role_id !== "1") {
            return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
        }

        $retailers = User::where('role_id', 2)->get();
        $categories = Category::all();
        $products = Product::all();
        $orders = Order::whereIn('status', ['processing', 'delivered'])->get();
        $totalOrderAmount = $orders->sum('amount');
        return view('admin.dashboard', compact(
            'retailers',
            'categories',
            'products',
            'totalOrderAmount'
        ));
    }
}
