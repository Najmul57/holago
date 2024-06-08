<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;

//session_start();

class PublicSslCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {

            # Here you have to receive all the order data to initate the payment.
            # Lets your oder trnsaction informations are saving in a table called "orders"
            # In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
            $amount = 0;
            if(Session::has('payment_amount')){
                $amount = round($request->session()->get('payment_amount'));
            }
            //dd(Session::get('payment_type'));
            if(Session::has('payment_type')){
                if(Session::get('payment_type') == 'cart_payment'){
                    $post_data = array();
                    $post_data['total_amount'] = $amount; # You cant not pay less than 10
                    $post_data['currency'] = "BDT";
                    $post_data['tran_id'] = substr(md5($request->session()->get('invoice_no')), 0, 10); // tran_id must be unique

                    $request_data['cus_name'] = $request->name;
                    $request_data['cus_phone'] = $request->phone;
                    $request_data['cus_email'] = $request->email;

                    $data_string = $request->name."__#__".$request->phone."__#__".$request->email."__#__".$request->division_id."__#__".$request->district_id."__#__".$request->upazilla_id."__#__".$request->address;

                    $post_data['value_a'] = $post_data['tran_id'];
                    $post_data['value_b'] = $request->session()->get('invoice_no');
                    $post_data['value_c'] = $request->session()->get('payment_method');
                    $post_data['value_d'] = $data_string;

                    //dd($request);

                    $post_data['cus_name'] = $request->name;
                    $post_data['cus_phone'] = $request->phone;
                    $post_data['cus_email'] = $request->email;

                    #Start to save these value  in session to pick in success page.
                    // $_SESSION['payment_values']['tran_id']=$post_data['tran_id'];
                    // $_SESSION['payment_values']['order_id']=$request->session()->get('order_id');
                    // $_SESSION['payment_values']['payment_type']=$request->session()->get('payment_type');
                    #End to save these value  in session to pick in success page.

                    # CUSTOMER INFORMATION
//                    $post_data['cus_name'] = $request->session()->get('shipping_info')['name'];
//                    $post_data['cus_add1'] = $request->session()->get('shipping_info')['address'];
//                    $post_data['cus_city'] = $request->session()->get('shipping_info')['city'];
//                    $post_data['cus_postcode'] = $request->session()->get('shipping_info')['postal_code'];
//                    $post_data['cus_country'] = $request->session()->get('shipping_info')['country'];
//                    $post_data['cus_phone'] = $request->session()->get('shipping_info')['phone'];
//                    $post_data['cus_email'] = $request->session()->get('shipping_info')['email'];

                }

                //dd($request);

                //session()->get('invoice_no');
    	   	    //session()->forget('invoice_no');

    	   	    //session()->get('user_id');
    	   	    //session()->forget('user_id');

    	   	    //session()->get('payment_method');
        	   	//session()->forget('payment_method');

                //session()->get('payment_type');
        	   	//session()->forget('payment_type');

        	   	//session()->get('payment_amount');
        	   	//session()->forget('payment_amount');

        	   	//Session::put('payment_type', 'cart_payment');


                # CUSTOMER INFORMATION
                //$user = Auth::user();

            }

            $server_name=$request->root()."/";
            $post_data['success_url'] = $server_name . "sslcommerz/success";
            $post_data['fail_url'] = $server_name . "sslcommerz/fail";
            $post_data['cancel_url'] = $server_name . "sslcommerz/cancel";

            //dd($post_data['cancel_url']);

            # SHIPMENT INFORMATION
            //$post_data['ship_name'] = 'ship_name';
            // $post_data['ship_add1 '] = 'Ship_add1';
            // $post_data['ship_add2'] = "";
            // $post_data['ship_city'] = "";
            // $post_data['ship_state'] = "";
            // $post_data['ship_postcode'] = "";
            // $post_data['ship_country'] = "Bangladesh";

            # OPTIONAL PARAMETERS
            // $post_data['value_a'] = "ref001";
            // $post_data['value_b'] = "ref002";
            // $post_data['value_c'] = "ref003";
            // $post_data['value_d'] = "ref004";

            //Session::put('checkout_request', $request->all());

            $sslc = new SSLCommerz();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->initiate($post_data, false);

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            }

    }

    public function success(Request $request)
    {
        //echo "Transaction is Successful";
        dd($request);

        $sslc = new SSLCommerz();
        #Start to received these value from session. which was saved in index function.
        $tran_id = $request->value_a;
        #End to received these value from session. which was saved in index function.
        $payment = json_encode($request->all());

        $carts = Cart::content();
        //dd($carts);

        // if($carts->isEmpty()){
        //     $notification = array(
        //         'message' => 'Your cart is empty.',
        //         'alert-type' => 'error'
        //     );
        //     return redirect()->route('home')->with($notification);
        // }

        // dd($request->all());

        $data_string = $request->value_d;

        $request_data = explode("__#__", $data_string);
        //dd($request_data);

        if(Auth::check()){
            $user_id = Auth::id();
            $type = 1;
        }else{
            $user_id = 1;
            $type = 2;
        }

        // order add //
        $order = Order::create([
            'user_id' => $user_id,
            'grand_total' => Cart::total(),
            'payment_method' => 'sslcommerz',
            'payment_status' => 1,
            'invoice_no' => $request->value_b,
            'delivery_status' => 'pending',
            'phone' => $request_data[1],
            'email' => $request_data[2],
            'division_id' => $request_data[3],
            'district_id' => $request_data[4],
            'upazilla_id' => $request_data[5],
            'address' => $request_data[6],
            'type' => $type,
            //'created_by' => Auth::guard('admin')->user()->id,
        ]);

        if(get_setting('otp_system')){
            $sms_template = SmsTemplate::where('name','order_message')->where('status',1)->first();
            if($sms_template){
                $sms_body       = $sms_template->body;
                $sms_body       = str_replace('[[order_code]]', $order->invoice_no, $sms_body);
                $sms_body       = str_replace('[[order_amount]]', $order->grand_total, $sms_body);
                $sms_body       = str_replace('[[site_name]]', env('APP_NAME'), $sms_body);

                if($order->pay_status == 1){
                    $payment_info = json_decode($order->payment_info);
                    $sms_body     = str_replace('[[payment_details]]', 'পেমেন্ট স্ট্যাটাসঃ paid'.', ট্রান্সেকশন আইডিঃ '.$order->transaction_id.', মাধ্যমঃ '.$order->payment_method.' ', $sms_body);
                }else{
                    $sms_body       = str_replace('[[payment_details]]', '', $sms_body);
                }

                if(substr($order->phone,0,3)=="+88"){
                    $phone = $order->phone;
                }elseif(substr($order->phone,0,2)=="88"){
                    $phone = '+'.$order->phone;
                }else{
                    $phone = '+88'.$order->phone;
                }
                //dd($phone);
                SendSMSUtility::sendSMS($phone, $sms_body);

                // $sms_body = str_replace('আপনার', 'নতুন', $sms_body);
                // $setting = Setting::where('name', 'phone')->first();
                // if($setting->value != null){
                //     $admin_phone=$setting->value;

                //     if(substr($admin_phone,0,3)=="+88"){
                //         $phone = $admin_phone;
                //     }elseif(substr($admin_phone,0,2)=="88"){
                //         $phone = '+'.$admin_phone;
                //     }else{
                //         $phone = '+88'.$admin_phone;
                //     }
                //     SendSMSUtility::sendSMS($admin_phone, $sms_body);
                // }
            }
        }


        // order details add //
        foreach ($carts as $cart) {
            $product = Product::find($cart->id);
            if($cart->options->is_varient == 1){
                $variations = array();
                for($i=0; $i<count($cart->options->attribute_names); $i++){
                    $item['attribute_name'] = $cart->options->attribute_names[$i];
                    $item['attribute_value'] = $cart->options->attribute_values[$i];
                    array_push($variations, $item);
                }
                OrderDetail::insert([
                    'order_id' => $order->id,
                    'product_id' => $cart->id,
                    'is_varient' => 1,
                    'variation' => json_encode($variations, JSON_UNESCAPED_UNICODE),
                    'qty' => $cart->qty,
                    'price' => $cart->price,
                    'tax' => $cart->tax,
                    'created_at' => Carbon::now(),
                ]);

                // stock calculation //
                $stock = ProductStock::where('varient', $cart->options->varient)->first();
                // dd($cart);
                if($stock){
                    // dd($stock);
                    $stock->qty = $stock->qty - $cart->qty;
                    $stock->save();
                }

            }else{
                OrderDetail::insert([
                    'order_id' => $order->id,
                    'product_id' => $cart->id,
                    'is_varient' => 0,
                    'qty' => $cart->qty,
                    'price' => $cart->price,
                    'tax' => $cart->tax,
                    'created_at' => Carbon::now(),
                ]);
            }

            $product->stock_qty = $product->stock_qty - $cart->qty;
            $product->save();
        }

        Cart::destroy();

        //Ledger Entry
        $ledger = AccountLedger::create([
            'account_head_id' => 2,
            'particulars' => 'Order ID: '.$order->id,
            'credit' => $order->grand_total,
            'order_id' => $order->id,
            'type' => 2,
        ]);
        $ledger->balance = get_account_balance() + $order->grand_total;
        $ledger->save();

        $notification = array(
            'message' => 'Your order has been placed successfully.',
            'alert-type' => 'success'
        );

        return redirect()->route('checkout.success', $order->invoice_no)->with($notification);


        if(isset($request->value_c)){
            if(Session::get('payment_type') == 'cart_payment'){
                //dd($request);
                //$checkoutController = new CheckoutController;
                //$checkout_request = new Request;
                //$checkout_request = new Request(Session::get('checkout_request'));
                //return $checkoutController->store($checkout_request);
            }
            elseif ($request->value_c == 'wallet_payment') {
                $data['amount'] = $request->value_b;
                $data['payment_method'] = 'sslcommerz';
                Auth::login(User::find($request->value_d));

                $walletController = new WalletController;
                return $walletController->wallet_payment_done($data, $payment);
            }
            elseif ($request->value_c == 'customer_package_payment') {
                $data['customer_package_id'] = $request->value_b;
                $data['payment_method'] = 'sslcommerz';
                Auth::login(User::find($request->value_d));

                $customer_package_controller = new CustomerPackageController;
                return $customer_package_controller->purchase_payment_done($data, $payment);
            }
            elseif ($request->value_c == 'seller_package_payment') {
                $data['seller_package_id'] = $request->value_b;
                $data['payment_method'] = 'sslcommerz';
                Auth::login(User::find($request->value_d));

                $seller_package_controller = new SellerPackageController;
                return $seller_package_controller->purchase_payment_done(json_decode($request->value_b), $payment);
            }
        }
    }

    public function fail(Request $request)
    {
        $request->session()->forget('order_id');
        $request->session()->forget('payment_data');
        flash(translate('Payment Failed'))->warning();
        return redirect()->route('home');
    }

    public function cancel(Request $request)
    {
        dd($request);
        //$request->session()->forget('order_id');
        //$request->session()->forget('payment_data');
        Session::flash('error','Payment cancelled');
    	return redirect()->route('checkout');
    }

     public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
      if($request->input('tran_id')) #Check transation id is posted or not.
      {
          $tran_id = $request->input('tran_id');

          #Check order status in order tabel against the transaction id or order id.
          $combined_order = CombinedOrder::findOrFail($request->session()->get('combined_order_id'));

                if($order->payment_status =='Pending')
                {
                    $sslc = new SSLCommerz();
                    $validation = $sslc->orderValidate($tran_id, $order->grand_total, 'BDT', $request->all());
                    if($validation == TRUE)
                    {
                        /*
                        That means IPN worked. Here you need to update order status
                        in order table as Processing or Complete.
                        Here you can also sent sms or email for successfull transaction to customer
                        */
                        echo "Transaction is successfully Complete";
                    }
                    else
                    {
                        /*
                        That means IPN worked, but Transation validation failed.
                        Here you need to update order status as Failed in order table.
                        */

                        echo "validation Fail";
                    }

                }
        }
        else
        {
            echo "Inavalid Data";
        }
    }
}
