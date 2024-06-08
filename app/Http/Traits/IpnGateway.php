<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\Payment;
use App\Models\Setting;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;


trait IpnGateway{

	//Strip

	public function stripeIpn(Request $request){
		$this->validate($request, [
			'card_number'	=>	'required',
			'card_expiry'	=>	'required',
			'card_cvc'	=>	'required',
			'track'	=>	'required',
		]);

		$data = Payment::where('trx_number', $request->track)->where('status',0)->orderBy('id','desc')->first();
		if (!$data) {
			$alert = ['danger','Oops! Transaction Failed'];
			return redirect()->route($this->redirect())->withAlert($alert);
		}

		$cc = $request->card_number;
		$exp = $request->card_expiry;
		$cvc = $request->card_cvc;

		$exp = $pieces = explode("/", $request->card_expiry);
		$emo = trim($exp[0]);
		$eyr = trim($exp[1]);
		$cnts = round($data->after_convert, 2) * 100;

		$gateway_currency = $data->gateway_currency;
		$gateway = $gateway_currency->paymentGateway;
		$credential = $gateway->setting;


		Stripe::setApiKey($credential->secret_key);

		Stripe::setApiVersion("2020-03-02");

		try {
			$token = Token::create(array(
				"card"	=> array(
					"number"	=> "$cc",
					"exp_month"	=> $emo,
					"exp_year"	=> $eyr,
					"cvc"		=> "$cvc"
				)

			));
			try {
				$charge = Charge::create(array(
					'card'		=> $token['id'],
					'currency'	=> $gateway_currency->currency,
					'amount'	=> $cnts,
					'description'	=>'item',
				));

				if ($charge['status'] == 'succeeded') {
					$this->paymentSuccess($data);
					$alert = ['success','Payment Success.'];
				}
			} catch (\Exception $e) {
				$alert = ['danger', $e->getMessage()];
			}
		} catch (\Exception $e) {
			$alert = ['danger', $e->getMessage()];
		}
		return redirect()->route($this->redirect())->withAlert($alert);
	}

	//Paypal

	public function paypalIpn()
	{
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval){
			$keyval = explode('=', $keyval);
			if(count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}

		$req = 'cmd=_notify-validate';
		if (function_exists('get_magic_quotes_gpc')){
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value){
			if ($get_magic_quotes_exists == true && get_magic_quotes_grp() == 1){
				$value = urlencode(stripslashes($value));
			} else{
				$value = urlencode($value);
			}
			$req .="&$key=$value";
		}

		$paypalURL = "https://ipnpb.paypal.com/cgi-bin/webscr?";
		$url = $paypalURL . $req;
		$ch = curl_int();
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$verify = curl_exec($ch);
		curl_close($ch);

		if ($verify == "VERIFIED"){
			$receiver_email = $_POST['receiver_email'];
			$mc_currency = $_POST['mc_currency'];
			$mc_gross = $_POST['mc_gross'];
			$track = $_POST['custom'];
			$data = Payment::where('trx_number', $track)->orderBy('id', 'DESC')->first();
			$amount = $data->after_convert;
			if ($mc_gross == $amount && $data->status == '0') {
				$this->paymentSuccess($data);
				$alert = ['success','Payment successful'];
			}else{
				$alert = ['danger','Payment failed'];
			}
		}else{
			$alert = ['danger','Payment failed'];
		}

		return redirect()->route($this->redirect())->withAlert($alert);

	}

	//Skrill

	public function skrillIpn()
	{
		$data = Payment::where('trx_number', $_POST['transaction_id'])->orderBy('id','DESC')->first();

		$gateway_currency = $data->gateway_currency;
		$gateway = $gateway_currency->paymentGateway;
		$credential = $gateway->setting;
		$concatFields = $_POST['merchant_id']
			. $_POST['transaction_id']
			. strtoupper(md5($credential->secret_key))
			. $_POST['mb_amount']
			. $_POST['mb_currency']
			. $_POST['status'];

		if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $credential->pay_to_email && $data->status = '0') {
			$this->paymentSuccess($data);
			$alert = ['success','Payment successful'];
		}else{
			$alert = ['danger','Payment failed'];
		}

		return redirect()->route($this->redirect())->withAlert($alert);
	}

	//Razorpay
	public function razorpayIpn(Request $request)
	{
		$data = Payment::where('extra_data', $request->razorpay_order_id)->orderBy('id', 'DESC')->first();

		$gateway_currency = $data->gateway_currency;
		$gateway = $gateway_currency->paymentGateway;
		$credential = $gateway->setting;

		if (!$data) {
			$alert = ['danger','Invalid Request 1'];
		}

		$sig = hash_hmac('sha256', $request->razorpay_order_id . "|". $request->razorpay_payment_id, $credential->key_secret);

		if ($sig == $request->razorpay_signature_signature){

			$this->paymentSuccess($data);
			$alert = ['success','Transaction successful'];
		}else{
			$alert = ['danger',' Invalid Request 2'];
		}

		return redirect()->route($this->redirect())->withAlert($alert);
	}

	//Flutter Wave

	public function flutterwaveIpn($trx,$type)
	{
		if ($type == 'error') {
			$alert = ['danger','Oops! Transaction Failed'];
			return redirect()->route($this->redirect())->withAlert($alert);
		}

		if (!isset($trx)) {
			$alert = ['danger','Oops! Transaction Failed'];
			return redirect()->route($this->redirect())->withAlert($alert);
		}

		$data = Payment::where('trx_number', $trx)->where('status',0)->orderBy('id','desc')->first();

		if (!$data) {
			$alert = ['danger','Oops! Transaction Failed'];
			return reditrect()->route($this->redirect())->withAlert($alert);
		}
		$gateway_currency = $data->gateway_currency;
		$gateway = $gateway_currency->paymentGateway;
		$credentials = $gateway->setting;

		$query = array(
			"SECKEY"	=> $credentials->secret_key,
			"txref"	=> $trx
		);

		$data_string = json_encode($query);
		$ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response);

		if ($response->data->status == "successful") {
			$this->paymentSuccess($data);
			$alert = ['success', 'Transaction was successful, Ref: ' . $trx];
		}else{
			$alert = ['danger', 'Unable to Process'];
		}

		return redirect()->route($this->redirect())->withAlert($alert);

	}









	protected function redirect(){
		return 'company.dashboard';
	}

	protected function paymentSuccess($data)
	{
		$data->status = 1;
		$data->save();
		$user = $data->company;

		$setting = Setting::first();

		alert($user, 'DEPOSIT_COMPLETE', [
            'method_name' => $data->gatewayName(),
            'method_currency' => $data->gateway_currency->currency,
            'amount' => numberFormat($data->amount),
            'charge' => numberFormat($data->charge),
            'currency' => $setting->site_currency,
            'rate' => numberFormat($data->rate),
            'trx' => $data->trx_number
        ]);

	}
}

?>