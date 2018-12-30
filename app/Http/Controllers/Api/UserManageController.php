<?php

namespace App\Http\Controllers\Api;

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
    public function verifyUser(Request $request)
    {
        $verification_code = $request->get('verification_code');
        if (is_null($verification_code))
        {
            return view('verifyAccount')->with('data', ['success' => 0, 'message' => 'Verification code is required']);

        }

        $userVerification = DB::table('user_verifications')->where('token', $verification_code)->first();
        if (! is_null($userVerification))
        {
            $user = User::find($userVerification->user_id);
            if ($user->is_verified == 1)
            {
                return view('verifyAccount')->with('data', ['success' => 2, 'message' => 'Your account is already verified']);

            }
            $user->update(['is_verified' => 1]);
            return view('verifyAccount')->with('data', ['success' => 1, 'message' => 'User account verified successfully']);

        }

        return view('verifyAccount')->with('data', ['success' => 0, 'message' => 'Invalid verification code']);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        if ($query == '' || $query == ' ') {
            return response()->json(['data' => null]);
        }
        $rows = DB::table('users')->select('name')->where('name', 'like', '%'.$query.'%')->take(5)->get();
        return response()->json(['data' => count($rows) == 0 ? null : $rows]);
    }
}
