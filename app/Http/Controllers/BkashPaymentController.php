<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class BkashPaymentController extends Controller
{
    private $base_url;

    public function __construct()
    {
        // Sandbox
         // $this->base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta';
        // Live
       $this->base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta';
    }
    public function authHeaders(){
        return array(
            'Content-Type:application/json',
            'Authorization:' .$this->grant(),
            'X-APP-Key:DvmI1xPoLKMYwvOWNbJdOqbFtc'
        );
    }

    public function curlWithBody($url,$header,$method,$body_data_json){
        $curl = curl_init($this->base_url.$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $body_data_json);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function grant()
    {
        $header = array(
            'Content-Type:application/json',
            'username:01917999931',
            'password:Z,;*N&tQE0-'
        );
        $header_data_json=json_encode($header);
//        dd($header_data_json);
        $body_data = array('app_key'=> 'DvmI1xPoLKMYwvOWNbJdOqbFtc', 'app_secret'=>'KQRuJ6GMOvLn4u0Sh7THVqCCV76zwZi2zQBYfpUROoMByksmMnRv');
        $body_data_json=json_encode($body_data);
        $response = $this->curlWithBody('/tokenized/checkout/token/grant',$header,'POST',$body_data_json);
        $token = json_decode($response)->id_token;
//       dd($token);
        return $token;
    }

    public function payment(Request $request)
    {
        return view('CheckoutURL.pay');
    }

    public function createPayment(Request $request)
    {
        $header =$this->authHeaders();
        $website_url = URL::to("/");
        $body_data = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => $website_url.'/bkash/callback',
            'amount' => $request->grand_total,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => "Inv".Str::random(8) // you can pass here OrderID
        );
        $body_data_json=json_encode($body_data);
        $response = $this->curlWithBody('/tokenized/checkout/create',$header,'POST',$body_data_json);
        return redirect((json_decode($response)->bkashURL));
    }

    public function executePayment($paymentID)
    {
        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID
        );
        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/execute',$header,'POST',$body_data_json);

        $res_array = json_decode($response,true);

        if(isset($res_array['trxID'])){
            // your database insert operation
            // save $response
        }

        return $response;
    }

    public function queryPayment($paymentID)
    {
        $header =$this->authHeaders();
        $body_data = array(
            'paymentID' => $paymentID,
        );
        $body_data_json=json_encode($body_data);
        $response = $this->curlWithBody('/tokenized/checkout/payment/status',$header,'POST',$body_data_json);
        $res_array = json_decode($response,true);
        if(isset($res_array['trxID'])){
            // your database insert operation
            // insert $response to your db
        }
        return $response;
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();
        if(isset($allRequest['status']) && $allRequest['status'] == 'failure'){
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Failure'
            ]);
        }else if(isset($allRequest['status']) && $allRequest['status'] == 'cancel'){
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Cancel'
            ]);
        }else{
            $response = $this->executePayment($allRequest['paymentID']);
            $arr = json_decode($response,true);
            if(array_key_exists("statusCode",$arr) && $arr['statusCode'] != '0000'){
                return view('CheckoutURL.fail')->with([
                    'response' => $arr['statusMessage'],
                ]);
            }else if(array_key_exists("message",$arr)){
                sleep(1);
                $query = $this->queryPayment($allRequest['paymentID']);
                return view('CheckoutURL.success')->with([
                    'response' => $query
                ]);
            }

            $user_id = auth()->user()->id??null;
            if($user_id != null){
                $data = Cart::where('customer_id', $user_id)->with(['product', 'product.stocks', 'product.categories'])
                    ->get();
            }else{
                $s_id       = session()->get('session_id');
                $data = Cart::where('session_id', $s_id)
                    ->with(['product', 'product.stocks', 'product.categories'])
                    ->get();
            }
            Session::forget('coupon');
            $order = new Order();
            $order->customer_id = auth()->user()->id ?? null;
            $order->order_number = trxNumber();
            $order->shipping_address = [
                'name' => Session::get('name'),
                'mobile' => Session::get('mobile'),
                'email' => Session::get('email'),
                'district_id' => Session::get('district_id'),
                'address' => Session::get('address'),
                'shipping_place' => Session::get('shipping_place'),
                'note' => Session::get('note')
            ];
            $order->shipping_charge = Session::get('shipping_charge');
            $order->total_amount = Session::get('shipping_charge');
            $order->order_type = Session::get('payment_method');
            $order->payment_status = 'paid';
            $order->save();
            $order_id = $order->id;
            $contents = $data;
            foreach ($contents as  $v_content)
            {
                $order_details = new OrderDetails();
                $order_details->order_id = $order_id;
                $order_details->product_id = $v_content->product->id;
                $order_details->quantity = $v_content->quantity;
                $order_details->buying_price = $v_content->product->buying_price;
                $order_details->regular_price = $v_content->product->regular_price;
                $order_details->discount_price = $v_content->product->discount_price;
                $order_details->wholesale_price = $v_content->product->wholesale_price;
                $order_details->wholesale_minimum_quantity = $v_content->product->wholesale_min_qty;
                $order_details->details = null;
                $order_details->total_price = $v_content->product->regular_price * $v_content->quantity;
                $order_details->save();
            }
            foreach($data as $cart){
                $cart->delete();
            }
            return view('CheckoutURL.success')->with([
                'response' => $response
            ]);
        }
    }
    public function getRefund(Request $request)
    {
        return view('CheckoutURL.refund');
    }

    public function refundPayment(Request $request)
    {
        $header =$this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'amount' => $request->amount,
            'trxID' => $request->trxID,
            'sku' => 'sku',
            'reason' => 'Quality issue'
        );

        $body_data_json=json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/refund',$header,'POST',$body_data_json);

        // your database operation
        // save $response

        return view('CheckoutURL.refund')->with([
            'response' => $response,
        ]);
    }
}
