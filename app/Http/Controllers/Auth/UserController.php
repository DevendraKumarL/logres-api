<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\User;
use App\Http\Controllers\Controller;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $crendentials = $request->only('name', 'email', 'password');
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required'
        ];
        $validator = Validator::make($crendentials, $rules);
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'error' => $validator->messages()], 400);
        }

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);

        $verification_code = str_random(30);
        DB::table('user_verifications')->insert(['user_id' => $user->id, 'token' => $verification_code]);

        $subject = 'logres | Account Verification';
        Mail::send('email.verify', ['name' => $name, 'verification_code' => $verification_code],
            function (Message $mail) use ($email, $name, $subject) {
                $mail->from(getenv('MAIL_USERNAME', 'logres Admin'));
                $mail->to($email, $name);
                $mail->subject($subject);
            });

        return response()->json([
            'success' => true,
            'message' => 'Registration successful. Please check your email to verify your account'
        ], 200);
    }

    public function login(Request $request)
    {
        $crendentials = $request->only('email', 'password');
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $validator = Validator::make($crendentials, $rules);
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'error' => $validator->messages()], 400);
        }

        try
        {
            $crendentials['is_verified'] = 1;
            if (! $token = JWTAuth::attempt($crendentials))
            {
                return response()->json([
                    'success' => false,
                    'error' => 'Login credentials are invalid or user account email is not verified yet'
                ], 401);
            }
        }
        catch(JWTException $e)
        {
            return response()->json(['success' => false, 'error' => 'Failed to login. Please try again later'], 500);
        }

        return response()->json(['success' => true, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        try
        {
            JWTAuth::invalidate($request->token);
            return response()->json(['success' => true, 'message' => 'User logged out successfully'], 200);
        }
        catch(TokenExpiredException $e)
        {
            return response()->json(['success' => false, 'error' => 'Log out failed. Please try again later'], 500);
        }
    }

    public function profile(Request $request)
    {
        $user = JWTAuth::toUser(JWTAuth::getToken());
        return response()->json(['success' => true, 'user' => $user], 200);
    }
}
