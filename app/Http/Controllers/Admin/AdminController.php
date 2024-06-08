<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Models\Admin;
use App\Models\User;
use App\Models\Payment;
use App\Models\UserLoginHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Artisan;

class AdminController extends Controller
{

    use FileUploadTrait;

    public function dashboard()
    {   
        $data['months']                 = collect([]);
        $data['deposit_month_amount']   = collect([]);

        $data['totalUser'] = User::get();

        $data['depositsMonth'] = Payment::where('created_at', '>=', Carbon::now()->subYear())
            ->where('status',1)
            ->selectRaw("SUM(amount) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->groupBy('months')->get();

        $data['depositsMonth']->map(function ($depositData) use ($data) {
            $data['months']->push($depositData->months);
            $data['deposit_month_amount']->push($depositData->depositAmount);
        });

        // user Browsing, Country, Operating Log
        $userLoginData = UserLoginHistory::where('created_at', '>=', \Carbon\Carbon::now()->subDay(30))->get(['browser', 'os', 'country']);

        $data['chart']['user_browser_counter'] = $userLoginData->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $data['chart']['user_country_counter'] = $userLoginData->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);

        $data['weeklyUser'] = $data['totalUser']->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $data['weeklyInActiveUser'] = $data['totalUser']->where('email_verified', 0)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $data['weeklyVerifiedUser'] = $data['totalUser']->where('email_verified', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $data['weeklyActiveUser'] = $data['totalUser']->where('status', 1)->where('created_at', '>', Carbon::now()->startOfWeek())->where('created_at', '<', Carbon::now()->endOfWeek())->count();
        $data['inActiveUser'] = $data['totalUser']->where('email_verified', 0)->count();
        $data['VerifiedUser'] = $data['totalUser']->where('email_verified', 1)->count();
        $data['activeUser'] = $data['totalUser']->where('status', 1)->count();
        return view('admin.dashboard',$data); 
    }


    public function profile()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email',
        ]);

        $admin = auth()->guard('admin')->user();
        $image = $admin->image;
        if ($request->hasFile('image')) {
            try{
                $imageData = [
                    'file'=>$request->image,
                    'path'=>'assets/admin/images/',
                    'size'=>'300x300',
                    'prevFile'=>$admin->image,
                ];
                $image = $this->uploadFile('image',$imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }

        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->position = $request->position;
        $admin->country = $request->country;
        $admin->city = $request->city;
        $admin->address = $request->address;
        $admin->about_me = $request->about_me;
        $admin->image = $image;
        $admin->save();

        $alert = ['success','Admin profile update successfully'];
        return back()->withAlert($alert);
    }

    public function password()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.password', compact('admin'));
    }

    public function passwordUpdate(Request $request){
        $request->validate([
            'old_password'=>'required',
            'password'=>'required|confirmed',
        ]);

        $admin = auth()->guard('admin')->user();
        if (!Hash::check($request->old_password, $admin->password)) {
            $alert = ['danger','Old password doesn\'t match'];
            return back()->withAlert($alert);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        $alert = ['success','Password updated successfully'];
        return back()->withAlert($alert);
    }
}
