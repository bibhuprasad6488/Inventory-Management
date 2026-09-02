<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Models\Role;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function getUser(Request $request)
    {
        $user = Auth::user();
        // Log::info('Authenticated user: ' . json_encode($user)); // Log the authenticated user for debugging
        return response()->json($user);
    }

    public function getRoles()
    {
        $roles = Role::where('id', '!=', 1)->get();
        return response()->json($roles);
    }

    public function getSiteData()
    {
        $setting = SiteSetting::find(1);

        if ($setting) {
            $setting->site_logo = $setting->site_logo
                ? asset('storage/images/settings/' . $setting->site_logo)
                : '';

            $setting->footer_logo = $setting->footer_logo
                ? asset('storage/images/settings/' . $setting->footer_logo)
                : '';

            $setting->footer_logo_one = $setting->footer_logo_one
                ? asset('storage/images/settings/' . $setting->footer_logo_one)
                : '';

            $setting->footer_logo_two = $setting->footer_logo_two
                ? asset('storage/images/settings/' . $setting->footer_logo_two)
                : '';

            $setting->favicon = $setting->favicon
                ? asset('storage/images/settings/' . $setting->favicon)
                : '';
        }

        return response()->json($setting);
    }

    public function registerPushToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'push_token' => 'required|string',
            'platform' => 'required|in:android,ios,web',
            'device_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
        }

        try {

            $checkExistingToken = PushNotification::where('user_id', $user->id)->first();

            if ($checkExistingToken) {
                $checkExistingToken->push_token = $request->input('push_token');
                $checkExistingToken->platform = $request->input('platform');
                $checkExistingToken->device_name = $request->input('device_name');
                $checkExistingToken->is_active = true;
                $checkExistingToken->save();
            }

            $pushNotification = new PushNotification();
            $pushNotification->user_id = $user->id;
            $pushNotification->push_token = $request->input('push_token');
            $pushNotification->platform = $request->input('platform');
            $pushNotification->device_name = $request->input('device_name');
            $pushNotification->is_active = true;
            $pushNotification->save();
        } catch (\Exception $e) {
            Log::error('Error registering push token: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
