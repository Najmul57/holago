<?php

namespace App\Http\Traits;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;


trait ApiGateway{

	//Strip
	public function stripe($payment,$gatewayCurrency,$gateway)
	{

		$data = [
			'trx'			=> $payment->trx_number,
			'redirect'		=>false,
			'ipn'			=>route('ipn.stripe'),
			'view'			=>$this->rootPaymentPath('stripe')
		];

		return $data;
	}


	//Paypal
	public function paypal($payment,$gatewayCurrency,$gateway)
	{
		$setting = Setting::first();
		$credentials = $gateway->setting;

		$data = [
			'redirect'		=>false,
			'view'			=>$this->rootPaymentPath('autoSubmit'),
			'method'		=>'post',
			'url'			=>'https://www.paypal.com/cgi-bin/webscr',
		];

		$data['value'] = [
			'cmd'			=>'_xclick',
			'business'		=>$credentials->email,
			'cbt'			=>$setting->site_name,
			'currency_code'	=>$payment->gateway_currency->currency,
			'quantity'		=>1,
			'item_name'		=>"Payment To $setting->site_name Account",
			'custom'		=>"$payment->trx_number",
			'amount'		=>round($payment->after_convert,2),
			'return'		=>route('home'),
			'cancel_return'	=>route('home'),
			'notify_url'	=>route('ipn.paypal'),

		];
		return $data;
	}

	//skrill
	public function skrill($payment,$gatewayCurrency,$gateway)
	{
		$credentials = $gateway->setting;
		$setting = Setting::first();
		$data = [
			'redirect'				=> false,
			'view'					=> $this->rootPaymentPath('autoSubmit'),
			'method'				=> 'post',
			'url'					=> 'https://www.moneybookers.com/app/payment.pl',
		];
		$data['value'] = [
			'pay_to_email' 			=> trim($credentials->merchant_mail),
			'transaction_id'		=> "$payment->trx_number",
			'return_url'			=> route('home'),
			'return_url_text'		=> "Return $setting->site_name",
			'cancel_url'			=>route('home'),
			'status_url'			=>route('ipn.skrill'),
			'language'				=>'EN',
			'amount'				=>round($payment->after_convert,2),
			'currency'				=>"$gatewayCurrency->currency",
			'detail1_description'	=> "$setting->site_name",
			'detail1_text'			=>"Pay To $setting->site_name",
			'logo_url'				=> asset('assets/images/logo/logo.png'),
		];

		return $data;
	}

	//Razorpay
	public function razorpay($payment,$gatewayCurrency,$gateway)
	{
		$credentials = $gateway->setting;
		$api = new Api($credentials->key_id, $credentials->key_secret);
		$order = $api->order->create(
			array(
				'receipt' => $payment->trx_number,
				'amount'	=>$payment->after_convert * 100,
				'currency'	=>$gatewayCurrency->currency,
				'payment_capture'	=> '0'
			)
		);
		$payment->extra_data = $order->id;
		$payment->save();
		$data = [
			'method' => 'POST',
			'url' => route('ipn.razorpay'),
			'custom' => $payment->trx_number,
			'checkout_js'	=> "https://checkout.razorpay.com/v1/checkout.js",
			'redirect'	=> false,
			'view'	=> 'user.payment.razorpay',
		];
		$data['value'] = [
			'key' => $credentials->key_id,
			'amount'	=> $payment->after_convertm * 100,
			'currency'	=>$gatewayCurrency->currency,
			'order_id'	=> $order['id'],
			'buttontext'	=>"Pay with Razorpay",
			'name'	=>Auth::user()->username,
			'description'	=>"test",
			'image'	=>asset('assets/images/logo/logo.png'),
			'prefill.name'	=> Auth::user()->fullname(),
			'prefill.email'	=>Auth::user()->email,
			'prefill.contact'	=>Auth::user()->phone,
			'template.color'	=> "#2ecc71",
		];

		return $data;
	}

	//FlutterWave
	public function flutterwave($payment,$gatewayCurrency,$gateway)
	{
		$credentials = $gateway->setting;
		$data  = [
			'public_key'	=> $credentials->public_key,
			'email'	=> auth()->user()->email,
			'amount'	=> round($payment->after_convert),
			'phone'	=> auth()->user()->phone,
			'currency'	=> $gatewayCurrency->currency,
			'trx'	=>$payment->trx_number,
			'redirect'	=>false,
			'view'	=> $this->rootPaymentPath('flutterwave'),
		];

		return $data;
	}














	protected function rootPaymentPath($view){
		return 'user.payment.'.$view;
	}
}


?>