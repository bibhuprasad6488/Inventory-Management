<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FcmController extends Controller
{
    public function send(Request $request, FcmService $fcm)
    {
        $validator = Validator::make($request->all(), ['token' => 'required|string']);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }
        try {
            $result = [];
            $notifications = PushNotification::whereNotNull('push_token')->get();
            foreach ($notifications as $notification) {
                $result[] = $fcm->sendToToken($notification->push_token, 'Test Notification', 'Hello from Laravel!', ['type' => 'test', 'id' => '123',]);
            }
            return response()->json($result);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
