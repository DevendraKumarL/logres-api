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

class ResetPasswordController extends Controller
{
    public function resetPasswordRequest(Request $request)
    {
        $email = $request->get('email');
        if (is_null($email))
        {
            return response()->json(['success' => false, 'error' => 'Email ID is required']);
        }

        $user = User::where('email', $email)->first();
        if (! $user)
        {
            return response()->json(['success' => false, 'error' => 'That Email ID does not exists'], 400);
        }

        $check = DB::table('reset_passwords')->where('user_id', $user->id)->first();
        if (! is_null($check))
        {
            return response()->json(['success' => false, 'error' => 'An email was already sent to reset your password']);
        }

        try
        {
            $name = $user->name;
            $email = $user->email;
            $reset_code = str_random(30);
            DB::table('reset_passwords')->insert(['user_id' => $user->id, 'reset_code' => $reset_code]);
            $subject = 'logress | Reset Account Password';
            Mail::send('email.reset', ['name' => $name, 'reset_code' => $reset_code, 'reset_app_url' => getenv('RESET_APP_URL')],
                function (Message $mail) use ($name, $email, $subject) {
                    $mail->from(getenv('MAIL_USERNAME', 'logres Admin'));
                    $mail->to($email, $name);
                    $mail->subject($subject);
                });
        }
        catch(\Exception $e)
        {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => 'An email has been sent to reset your password']);
    }

    public function resetPassword(Request $request)
    {
        $fields = $request->only('reset_code', 'password');
        $rules = [
            'reset_code' => 'required',
            'password' => 'required'
        ];
        $validator = Validator::make($fields, $rules);
        if ($validator->fails())
        {
            return response()->json(['success' => false, 'error' => $validator->messages()], 400);
        }

        $reset_code = $request->reset_code;
        $userResetPassword = DB::table('reset_passwords')->where('reset_code', $reset_code)->first();
        if (! is_null($userResetPassword))
        {
            $password = $request->password;
            $user = User::find($userResetPassword->user_id);
            $user->update(['password' => Hash::make($password)]);
            DB::table('reset_passwords')->where('reset_code', $reset_code)->delete();
            return response()->json(['success' => true, 'message' => 'Your password has been reset successfully']);
        }

        return response()->json(['success' => false, 'error' => 'Invalid password reset code'], 400);
    }
}
