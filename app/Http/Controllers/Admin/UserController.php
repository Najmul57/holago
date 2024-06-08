<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailLog;
use App\Models\UserLoginHistory;
use Auth;

class UserController extends Controller
{
    public function list()
    {
        $users = User::orderBy('id','desc')->get();
        return view('admin.users.list',compact('users'));
    }

    public function active(){
        $title = 'Active Users';
        $users = User::orderBy('id','desc')->where('status',1)->paginate(20);
        return view('admin.users.list',compact('users','title'));
    }

    public function unverified(){
        $title = 'Un-verified Users';
        $users = User::orderBy('id','desc')->where('email_verified',0)->paginate(20);
        return view('admin.users.list',compact('users','title'));
    }

    public function banned(){
        $title = 'Banned Users';
        $users = User::orderBy('id','desc')->where('status',0)->paginate(20);
        return view('admin.users.list',compact('users','title'));
    }

    public function details($id)
    {
        $user = User::findOrfail($id);
        return view('admin.users.details',compact('user'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'email' => ['required'],
        ]);
        $user = User::findOrfail($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->points = $request->points;
        $user->email = $request->email;
        $user->address = $request->address_details;
        $user->status = $request->status ? 1 : 0;
        $user->email_verified = $request->email_verified ? 1 : 0;
        $user->save();
        $alert = ['success','User details updated successfully'];
        return back()->withAlert($alert);
    }

    public function userLoginHistory($id)
    {
        $user = User::findOrFail($id);
        $title = 'User Login History - ' . $user->username;
        $loginLogs = $user->loginLogs()->orderBy('id','desc')->with('user')->get();
        return view('admin.users.logins', compact('title', 'loginLogs'));
    }

    public function ipHistory($ip)
    {
        $title = 'Login By - ' . $ip;
        $loginLogs = UserLoginHistory::where('user_ip',$ip)->orderBy('id','desc')->with('user')->get();
        return view('admin.users.iphistory', compact('title', 'loginLogs','ip'));
    }

    public function sendMailUser($id)
    {
        $user = User::findOrFail($id);
        $title = 'Send Email To: ' . $user->username;
        return view('admin.users.email', compact('title', 'user'));
    }

    public function submitMailUser(Request $request, $id)
    {
         $request->validate([
            'message' => 'required',
            'subject' => 'required',
        ]);

        $user = User::findOrFail($id);
        sendRegularEmail($user->email, $request->subject, $request->message, $user->username);
        $alert = ['success', $user->username . ' will receive an email shortly.'];
        return back()->withAlert($alert);
    }

    public function login($id)
    {
        $user = User::findOrFail($id);
        Auth::login($user);
        return redirect()->route('user.dashboard');
    }

    public function userEmailHistory($id)
    {
        $user = User::findOrFail($id);
        $title = 'Email log of '.$user->username;
        $logs = EmailLog::where('user_id',$id)->with('user')->orderBy('id','desc')->get();
        return view('admin.users.emaillog', compact('title','logs','user'));
    }
    public function userEmailDetails($id)
    {
        $email_details = EmailLog::findOrFail($id);
        $title = "Email Details";
        return view('admin.users.emaildetails', compact('email_details','title'));    }
}