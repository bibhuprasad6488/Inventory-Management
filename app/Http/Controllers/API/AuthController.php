<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Symfony\Component\Clock\now;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'billing_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer|exists:roles,id'
            // 'email' => 'required|string|email|max:255',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()], 422);
        }
        $user = User::where('email', trim($request->email))->first();

        if ($user) {
            return response()->json(['status' => false, 'message' => 'Email already exists'], 422);
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'billing_name' => $request->billing_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $destinationPath = public_path('uploads/user/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            DB::commit(); // ✅ IMPORTANT

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful',
                'token' => $user->createToken('api_token')->plainTextToken,
                'user' => $user
            ], 201);
        } catch (\Throwable $th) {

            DB::rollback(); // ✅ rollback on error

            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong Error: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()], 422);
        }
        $user = User::where([
            'email' => trim($request->email),
        ])->first();

        if (!$user) {

            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user->tokens()->delete();
        // $token = $user->createToken('auth_token')->plainTextToken;
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['status' => 'success', 'message' => 'Login successful', 'user' => $user, 'token' => $token,], 200);
    }

    public function paswordReset(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|exists:users,email'
        ]);

        if ($validated->fails()) {
            return response()->json(['status' => 'error', 'message' => $validated->errors()->first()]);
        }

        // Generate OTP for to send through email or phone
    }

    public function logout()
    {
        $authUser = Auth::user();
        if (!$authUser) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }

        $user = User::find($authUser->id);


        if ($user) {
            $user->tokens()->delete();
            return response()->json(['status' => 'success', 'message' => 'Logout successful'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }
    }
}
