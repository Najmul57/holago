<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Models\PaymentGateway;
use App\Models\GatewayCurrency;
use Illuminate\Support\Str;
use HTMLPurifier;

class PaymentGatewayController extends Controller
{
    use FileUploadTrait; 

    public function index()
    {
        $gateways = PaymentGateway::orderBy('name')->get();
        return view('admin.gateway.list',compact('gateways'));
    }

    public function edit($id)
    {
        $gateways = PaymentGateway::findOrFail($id);
        $gateway_currency = GatewayCurrency::where('payment_gateway_id', $id)->orderBy('id','desc')->paginate(20);
        $title = 'Edit '. $gateways->name . ' Gateway';
        return view('admin.gateway.edit',compact('gateways','title','gateway_currency'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name'=>'required',
            'setting.*'=>'required',
            'currencies.*'=>'sometimes|required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $gateway = PaymentGateway::findOrFail($id);
        $image = $gateway->image;
        if ($request->hasFile('image')) {
            $image = $this->imageUpload($request->image,$gateway->image);
        }

        $setting = $request->setting;
        $gateway->update([
            'name'=>$request->name,
            'image'=>$image,
            'setting'=>$setting,
        ]);
        $alert = ['success','Payment Gateway Updated'];
        return back()->withAlert($alert);


    }

    public function activate(Request $request)
    {
        $request->validate(['act' => 'required']);
        $gateway = PaymentGateway::where('act', $request->act)->firstOrFail();
        $gateway->status = 1;
        $gateway->save();
        $alert = ['success', $gateway->name . ' has been activated.'];
        return back()->withAlert($alert);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['act' => 'required']);
        $gateway = PaymentGateway::where('act', $request->act)->firstOrFail();
        $gateway->status = 0;
        $gateway->save();
        $alert = ['success', $gateway->name . ' has been disabled.'];
        return back()->withAlert($alert);
    }

    public function currencyEdit(Request $request,$id)
    {
        $gateway_currency = GatewayCurrency::findOrFail($id);
        $title = 'Edit ' . $gateway_currency->currency_name . ' Currency';
        return view('admin.gateway.currencyUpdate',compact('gateway_currency','title'));
    }

    public function currencyUpdate(Request $request,$id){
        $request->validate([
            'minimum'=>'required|numeric|gt:0',
            'maximum'=>'required|numeric|gt:'.$request->minimum,
            'fixed_charge'=>'required|numeric|gt:0',
            'percent_charge'=>'required|numeric|gt:0',
            'conversion_rate'=>'required|numeric|gt:0',
            'instruction'=>'sometimes|required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $currency = GatewayCurrency::findOrFail($id);
        $currency->minimum = $request->minimum;
        $currency->maximum = $request->maximum;
        $currency->fixed_charge = $request->fixed_charge;
        $currency->percent_charge = $request->percent_charge;
        $currency->conversion_rate = $request->conversion_rate;
        $currency->enable_status = $request->status ? 1 : 0;

        $image = $currency->image;
        if ($request->hasFile('image')) {
            $image = $this->currencyImageUpload($request->image,$currency->image);
        }

        $currency->image = $image;
        $currency->save();

        $alert = ['success','Gateway Currency Updated Successfully'];
        return back()->withAlert($alert);
    }

    protected function imageUpload($image,$old){
        $imageData = [
            'file'=>$image,
            'path'=>'assets/images/paymentGateway/',
            'size'=>'300x300',
            'prevFile'=>$old,
        ];
        $image = $this->uploadFile('image',$imageData);
        return $image;
    }

    protected function currencyImageUpload($image,$old){
        $imageData = [
            'file'=>$image,
            'path'=>'assets/images/paymentGateway/gatewayCurrency/',
            'size'=>'300x300',
            'prevFile'=>$old,
        ];
        $image = $this->uploadFile('image',$imageData);
        return $image;
    }
}
