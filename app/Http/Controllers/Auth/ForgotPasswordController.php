<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use App\Models\EmailTemplate;
use App\Models\Setting;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use Xenon\LaravelBDSms\Facades\SMS;
use Xenon\LaravelBDSms\Provider\Ssl;

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showCodeRequestForm()
    {
        $content = "Accelerating innovation and transforming industries through cutting-edge solutions.";
        return view('auth.passwords.email',compact('content'));
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


    public function sendResetCodeEmail(Request $request)
    {

        $this->validate($request, [
            'phone' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            $alert = ['danger','Number Not Available'];
            return back()->withAlert($alert);
        }
        
        $code = verification_code(6);
        $shortCodes = $code;
        $userPasswordReset = new PasswordReset();
        $userPasswordReset->email = $user->phone;
        $userPasswordReset->token = $shortCodes;
        $userPasswordReset->created_at = \Carbon\Carbon::now();
        $userPasswordReset->save();

        $userIpInfo = getIpInfo();
        $userBrowser = osBrowser();
        
        $setting = Setting::first();

        $user->ver_code = $shortCodes;
        $user->ver_code_send_at = Carbon::now();
        $user->save();
         SMS::shoot($user->phone, "Your OTP is: {$shortCodes}");
        // dd($shortCodes);
        // Initialize the Firebase Auth instance
       if(substr($user->phone,0,3)=="+88"){
            $phone = $user->phone;
        }elseif(substr($user->phone,0,2)=="88"){
            $phone = '+'.$user->phone;
        }else{
            $phone = '+88'.$user->phone;
        }
        // dd($phone);

        $sms_templates = EmailTemplate::where('act','SVER_CODE')->first();
        $template = $sms_templates->sms_body;
        // dd($template);
        // $shortCodes = [];

        $template = shortCodeReplacer("{{code}}", $shortCodes, $template);
        // dd($template);
        $message = shortCodeReplacer("{{message}}", $template, $setting->sms_template);
        $message = shortCodeReplacer("{{name}}", $user->username, $message);
        // dd($message);
        $all = sendSMS($phone, $message);

        $alert = ['success', 'Password reset OTP sent successfully'];
        return redirect()->route('user.password.verify')->withAlert($alert);
    }

    public function verify(){
        $content = "Accelerating innovation and transforming industries through cutting-edge solutions.";
        return view('auth.passwords.code',compact('content'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['code' => 'required']);
        return redirect()->route('user.password.reset.change', $request->code);
    }
}