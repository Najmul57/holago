<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\EmailTemplate;

class EmailController extends Controller
{
    public function generalEmail()
    {
        return view('admin.setting.email.index');
    }

    public function generalEmailUpdate(Request $request)
    {
        $setting = Setting::first();
        $setting->email_template = $request->email_template;
        $setting->save();
        $alert = ['success','General email template has been updated.'];
        return back()->withAlert($alert);
    }

    public function emailSettingUpdate(Request $request){
        $request->validate([
            'host'=>'required',
            'port'=>'required|integer',
            'encryption'=>'required|in:ssl,tls',
            'username'=>'required',
            'password'=>'required',
            'email_from'=>'required',
        ]);
        $setting = Setting::first();
        $setting->mail = [
            'host' => $request->host,
            'port' => $request->port,
            'encryption' => $request->encryption,
            'username' => $request->username,
            'password' => $request->password,
            'email_from' => $request->email_from,
        ];
        $setting->save();

        $alert = ['success','Mail configuration updated successfully'];
        return back()->withAlert($alert);
    }

    public function emailMethodUpdate(Request $request){

        $request->validate([
            'email_method' => 'required|in:php,smtp,sendgrid,mailjet',
            'public_key' => 'required_if:email_method,mailjet',
            'secret_key' => 'required_if:email_method,mailjet',
        ]);

        $data['name'] = 'smtp';
        $setting = Setting::first();
        $setting->mail_config = $data;
        $setting->save();

        $alert = ['success','Mail configuration updated successfully'];
        return back()->withAlert($alert);
    }

    public function sendTestMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $setting = Setting::first();
        $config = json_decode($setting->mail_config);
        $receiver_name = explode('@', $request->email)[0];
        $subject = 'Testing ' . strtoupper($config->name) . ' Mail';
        $message = 'This is a test email, please ignore it if you are not meant to get this email.';

        try {

            sendRegularEmail($request->email, $subject, $message, $receiver_name);
           
        }
         catch (\Exception $exp) {
            $alert = ['danger', 'Invalid credential'];
            return back()->withAlert($alert);
        }

        $alert = ['success','You should receive a test mail at ' . $request->email . ' shortly.'];
        return back()->withAlert($alert);
    }

    public function index()
    {
        $allData = EmailTemplate::get();
        return view('admin.setting.email.email_template',compact('allData'));
    }

    public function edit(Request $request,$id)
    {
        $editData = EmailTemplate::findOrfail($id);
        $title = $editData->name;
        return view('admin.setting.email.email_template_edit',compact('editData','title'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'subject' => 'required',
            'email_body' => 'required',
        ]);
        $allData = EmailTemplate::findOrFail($id);
        $allData->subj = $request->subject;
        $allData->email_body = $request->email_body;
        $allData->email_status = $request->email_status ? 1 : 0;
        $allData->save();

        $alert = ['success', $allData->name . ' template has been updated.'];
        return back()->withAlert($alert);
    }
}
