<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FcmController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/get-roles', [UserController::class, 'getRoles']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'paswordReset']);
    Route::get('/get-website-data', [UserController::class, 'getSiteData']);
    // Categories
    Route::get('/categories', [ApiController::class, 'categories']);
    Route::get('/products', [ApiController::class, 'products']);
    Route::get('/category/{slug}', [ApiController::class, 'catWithProducts']);

    Route::post('/notifications/send', [FcmController::class, 'send']);
    Route::middleware('auth:sanctum')->group(function () {
        // Fetch the authenticated user along with their userDetails if they exist
        // Route::get('/user', function (Request $request) {
        //     return $request->user()->userDetails
        //         ? $request->user()->load('userDetails')
        //         : $request->user();
        // });

        Route::post('/create-order', [ApiController::class, 'createOrder']);
        Route::get('/my-orders', [ApiController::class, 'getUserOrders']);
        Route::post('/notifications/register-token', [UserController::class, 'registerPushToken']);
        Route::any('/user-update', [UserController::class, 'updateUser']);
        Route::any('/get-dashboard-data', [UserController::class, 'getDashboardData']);
        Route::get('/user', [UserController::class, 'getUser']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
