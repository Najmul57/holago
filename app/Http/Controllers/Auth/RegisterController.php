<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserLoginHistory;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Xenon\LaravelBDSms\Sender;
use Carbon\Carbon;
use Xenon\LaravelBDSms\Facades\SMS;
use Xenon\LaravelBDSms\Provider\Ssl;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //            'name' => ['required', 'string', 'max:255'],
            //            'username' => ['required', 'string', 'min:5', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:11', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }


    public function showRegistrationForm()
    {
        $data['filePath'] = storage_path('app/country/countries.json');

        if (File::exists($data['filePath'])) {
            $data['countries'] = File::get($data['filePath']);
            $data['countries'] = json_decode($data['countries'], true);
        } else {
            $data['countries'] = [];
        }
        return view('auth.register', $data);
    }

    public function register(Request $request)
    {
        
       


        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }
       

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            :
            redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       
        $user = User::create([
            //            'name' => $data['name'],
            //            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'points' => 1000,
            'password' => Hash::make($data['password']),
        
        ]);
        
       

        //Login Log Create
        $ip = $_SERVER["REMOTE_ADDR"];
        $exist = UserLoginHistory::where('user_ip', $ip)->first();
        $userLogin = new UserLoginHistory();

        // Check if the user login history exists
        if ($exist) {
            $userLogin->longitude = $exist->longitude;
            $userLogin->latitude = $exist->latitude;
            $userLogin->city = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country = $exist->country;
        } else {
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude = isset($info['long']) ? implode(',', $info['long']) : '';
            $userLogin->latitude = isset($info['lat']) ? implode(',', $info['lat']) : '';
            $userLogin->city = isset($info['city']) ? implode(',', $info['city']) : '';
            $userLogin->country_code = isset($info['code']) ? implode(',', $info['code']) : '';
            $userLogin->country = isset($info['country']) ? implode(',', $info['country']) : '';
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();

        return $user;
    }
}