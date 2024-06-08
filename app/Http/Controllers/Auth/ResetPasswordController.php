<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    public $redirectTo = '/user/login';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token)
    {

        $content ="Unlocking success through secure and seamless digital empowerment.";
        $resetToken = PasswordReset::where('token', $token)->first();

        if (!$resetToken) {
            $alert = ['danger', 'Token not found!'];
            return redirect()->route('user.password.reset')->withAlert($alert);
        }
        $phone = $resetToken->email;
        return view('auth.passwords.reset', compact('phone', 'token','content'));
    }


    public function reset(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'token' => 'required',
            'password' => 'required|confirmed|min:4',
        ]);

        $reset = PasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        $user = User::where('phone', $reset->email)->first();
        if ($reset->status == 1) {
            $alert = ['danger', 'Invalid code'];
            return redirect()->route('user.login')->withAlert($alert);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $userIpInfo = getIpInfo();
        $userBrowser = osBrowser();
        // sendEmail($user, 'PASS_RESET_DONE', [
        //     'operating_system' => $userBrowser['os_platform'],
        //     'browser' => $userBrowser['browser'],
        //     'ip' => $userIpInfo['ip'],
        //     'time' => $userIpInfo['time']
        // ]);

        $alert = ['success', 'Password changed'];
        return redirect()->route('user.login')->withAlert($alert);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('users');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('guest');
    }


}
