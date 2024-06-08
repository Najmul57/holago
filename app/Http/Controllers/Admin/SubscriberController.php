<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index(){
        $subscribers = Subscriber::orderBy('id','desc')->paginate(20);
        return view('admin.subscriber.index',compact('subscribers'));
    }

    public function delete($id){
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        $alert = ['success','Subscriber deleted successfully'];
        return back()->withAlert($alert);
    }

    public function sendMail()
    {
        return view('admin.subscriber.mail');
    }

    public function submitMail(Request $request){
        $request->validate([
            'subject'=>'required',
            'message'=>'required',
        ]);
        $subscribers = Subscriber::all();
        $subject = $request->subject;
        $message = $request->message;
        foreach ($subscribers as $subscriber) {
            
            $receiver_name = explode('@', $subscriber->email)[0];

            sendRegularEmail($subscriber->email, $subject, $message, $receiver_name);

        }
        $alert = ['success','Mail sent successfully'];
        return back()->withAlert($alert);
    }
}
