<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\User;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

class UserManageController extends Controller
{
    public function verifyUser($verification_code)
    {
        if (is_null($verification_code))
        {
            return response()->json(['success' => false, 'error' => 'Verification code is required'], 400);
        }

        $check = DB::table('user_verifications')->where('token', $verification_code)->first();
        if (!is_null($check))
        {
            $user = User::find($check->user_id);
            if ($user->is_verified == 1)
            {
                return response()->json(['success' => true, 'message' => 'User account already verified']);
            }
            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token', $verification_code)->delete();
            return response()->json(['success' => true, 'message' => 'User account verified successfully']);
        }

        return response()->json(['success' => false, 'error' => 'Invalid verification code'], 400);
    }

    public function resetPassword(Request $request)
    {
        
    }
}
