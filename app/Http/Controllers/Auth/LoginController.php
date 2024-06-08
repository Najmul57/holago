<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserLoginHistory;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'user/dashboard';
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }



    public function login(Request $request)
    {
        // dd($request->all());
        $validation_rule = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];
        $credentials = $request->only('phone', 'password'); // Change 'email' to 'username'

        if (Auth::attempt($credentials)) {
            if (Auth()->guard()->user()->sms_verified == 1) {
                 $alert = ['success', 'You have Successfully login!.'];
              return redirect()->route('user.dashboard')->withAlert($alert);
                // $route = route('user.dashboard');
                // return response()->json([
                //     'message' => "login sucessfully!",
                //     'data' => Auth()->guard()->user(),
                //     'route' => $route
                // ]);
            } else {
                $alert = ['danger', 'Please Verify First!'];
                return redirect()->route('user.verification')->withAlert($alert);
                // $route = route('user.verification');
                // return response()->json([
                //     'message' => "Please Verify First!",
                //     'data' => Auth()->guard()->user(),
                //     'route' => $route
                // ]);

            }
        }
        // $route = route('user.login');
        $alert = ['danger', 'Credential do not Match!'];
        return redirect()->route('user.login')->withAlert($alert);
        // return response()->json([
        //     'message' => "Credential do not Match!",
        //     'data' => null,
        //     'route' => $route
        // ]);
    }

    public function findUsername()
    {
        $login = request()->input('username');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : (filter_var($login, FILTER_VALIDATE_INT)
                ? 'phone'
                : 'username');

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }


    public function username()
    {
        return $this->username;
    }

    public function logout()
    {
        $this->guard()->logout();
        request()->session()->invalidate();
        $alert = ['success', 'You have been logged out.'];
        return redirect()->route('user.login')->withAlert($alert);
    }


    public function authenticated(Request $request, $user)
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = UserLoginHistory::where('user_ip', $ip)->first();
        $userLogin = new UserLoginHistory();
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',', $info['long']);
            $userLogin->latitude =  @implode(',', $info['lat']);
            $userLogin->city =  @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();

        if (session('intended')) {
            $route = session('intended');
            session()->forget('intended');
            return redirect($route);
        }
        return redirect()->route('user.dashboard');
    }
}