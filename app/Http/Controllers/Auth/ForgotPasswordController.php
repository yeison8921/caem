<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function forgotPassword()
    {
        return view('auth/passwords/email');
    }

    public function sendNewPassword(Request $request)
    {
        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Message here!'], 500);
        } else {
            $request->only('email');
            $new_password = \Str::random(8);
            $name = $user->first_name;
            $user->password = Hash::make($new_password);
            $user->save();

            $user->notify(new ForgotPasswordNotification($name, $new_password));
        }
    }
}
