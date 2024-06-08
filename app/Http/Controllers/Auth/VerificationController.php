<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use App\Http\Libs\SendMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Xenon\LaravelBDSms\Facades\SMS;
use Xenon\LaravelBDSms\Provider\Ssl;

class VerificationController extends Controller
{

	protected $setting;
	protected $template;

	public function __construct(){
		$this->setting = Setting::first();
		$this->template = 'template.'.$this->setting->template.'.';
	}


    public function checkValidCode($user, $code, $add_min = 10000)
    {
        // dd($user,$code);
        if (!$code) return false;
        if (!$user->ver_code_send_at) return false;

        $ver_code_send_at = Carbon::parse($user->ver_code_send_at); // Convert to Carbon instance

        if ($ver_code_send_at->addMinutes($add_min) < Carbon::now()) return false;
        if ($user->ver_code !== $code) return false;

        return true;
    }


    public function index(){
    	$user = auth()->user();
    	if ($user->sms_verified == 1) {
    		return redirect()->route('user.dashboard');
    	}
    	if (!session('verifyTime') || session('verifyTime') < now()) {
        	$this->sendVerifyMail($user);
        	$verifyTime = now()->addMinutes(1);
        	session()->put('verifyTime',$verifyTime);
    	}
    	return view('auth.verify');
    }

    public function verifyResend(){
    	session()->flash('resent',1);
    	$user = auth()->user();
    	$this->sendVerifyMail($user);
        $verifyTime = now()->addMinutes(1);
        session()->put('verifyTime',$verifyTime);
    	$alert = ['success','Verification mail sent successfully'];
    	return redirect()->route('user.verification')->withAlert($alert);
    }

    protected function sendVerifyMail($user){
        $setting = Setting::first();
        $code = verification_code(6);
        $shortCodes = $code;

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
//         dd($all);

        // $body = 'his is a';
        // $cck = 'প্রতিষ্ঠাতার নাম'.$body. 'প্রতিষ্ঠাতার নাম'.$body. 'প্রতিষ্ঠাতার নাম';
        // $all= sendSMS($phone, $cck);
    }

    public function verify($hash){
    	$user = auth()->user();
    	$id = decrypt($hash);
    	if ($user->sms_verified == 0) {
	    	$user->sms_verified = 1;
	    	$user->save();
	    	$alert = ['success','Email verified successfull'];
    	}else{
	    	$alert = ['success','Your email is already verified'];
    	}
    	return redirect()->route('user.dashboard')->withAlert($alert);
    }

    public function banned(){
    	if (auth()->user()->status) {
    		return redirect()->route('user.dashboard');
    	}
    	return view($this->template.'auth.banned');
    }

    public function smsVerification(Request $request)
    {
        $request->validate([
            'sms_verified_code' => 'required',
        ]);

        $user = Auth::user();
        if ($this->checkValidCode($user, $request->sms_verified_code)) {
            $user->sms_verified = 1;
            $user->ver_code = null;
            $user->ver_code_send_at = null;
            $user->save();
            return redirect()->intended(route('user.dashboard'));
        }
        throw ValidationException::withMessages(['sms_verified_code' => 'Verification code didn\'t match!']);
    }
}