<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApply;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    use FileUploadTrait;
    protected $setting;
    protected $template;

    public function __construct(){
        $this->setting = Setting::first();
        $this->template = 'templates.'.$this->setting->template.'.';
    }

    public function dashboard()
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->orderBy('id', 'DESC')->get();
        // dd($users);

        $totalUser = [];
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        foreach ($users as $jobApply) {
            $month = date('n', strtotime($jobApply->created_at));
            $totalUser[$months[$month - 1]] = isset($totalUser[$months[$month - 1]]) ? $totalUser[$months[$month - 1]] + 1 : 1;
        }

        return view('templates.classicmart.user.dashboard', compact('user','users', 'totalUser','months'));
    }


    public function editProfile()
    {
        $user = auth()->user();
        return view($this->template.'user.profile', compact('user'));
    }

    public function myPoints()
    {
        $user = auth()->user();
        return view($this->template.'user.point', compact('user'));
    }

    public function userBirthday(Request $request)
    {
        $user = Auth::user();
        $user->dateofbirth = $request->dateofbirth;
        $user->save();

        $alert = ['success', 'Birthday selected successfully'];
        return back()->withAlert($alert);
    }

    public function imageUpdate(Request $request)
    {
        $user = $this->getUser($request->all());
        $image = $user->image;
        if ($request->hasFile('image')) {
            try{
                $imageData = [
                    'file'=>$request->image,
                    'path'=>'assets/images/user/image/',
                    'size'=>'360x345',
                    'prevFile'=>$user->image,
                ];
                $image = $this->uploadFile('image',$imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }
        $user->image = $image;
        $user->save();

        return response()->json(['message' => 'Image updated successfully']);
    }

    public function coverImageUpdate(Request $request)
    {
        $user = $this->getUser($request->all());
        $image = $user->cover_image;
        if ($request->hasFile('cover_image')) {
            try{
                $imageData = [
                    'file'=>$request->cover_image,
                    'path'=>'assets/images/user/cover/',
                    'prevFile'=>$user->cover_image,
                ];
                $image = $this->uploadFile('image',$imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }
        $user->cover_image = $image;
        // dd($company);
        $user->save();

        return response()->json(['message' => 'Cover image updated successfully']);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'email' => ['required'],
        ]);

        $user = $this->getUser($request->all());
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address_details,
            'division' => $request->division,
            'email' => $request->email,
        ]);


        $alert = ['success','Profile update successfully'];
        return back()->withAlert($alert);
    }

    public function addressUp()
    {
        $user = auth()->user();
        return view($this->template.'user.address', compact('user'));
    }

    public function myOrder()
    {
        $user = auth()->user();
        $empty_message = 'No order yet';
        $orders = Order::where('customer_id', auth()->user()->id)->get();
        return view($this->template.'user.orderList', compact('user','orders','empty_message'));
    }
    public function myOrderDetails($id)
    {
        $user = auth()->user();
        $orders_data = Order::with('order_details')->where('id',$id)->where('customer_id', auth()->user()->id)->first();
        return view($this->template.'user.order_details', compact('user','orders_data'));
    }

    /**
     * Generate a unique filename for the uploaded file.
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateUniqueFileName($file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . time() . '.' . $extension;
        return $filename;
    }

    protected function getUser(array $data)
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);

        return $user;
    }
}