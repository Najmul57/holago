<?php

namespace App\Http\Controllers;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Termwind\render;
class SslCommerzPaymentController extends Controller
{
    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        // dd($request->all());
        $user = auth()->user();
        $post_data = array();
        $post_data['total_amount'] = $request->grand_total; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name;
        $post_data['cus_email'] =  $request->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['shipping_charge'] = $request->shipping_charge;
        $post_data['cus_phone'] = $request->mobile;
        $post_data['payment_option'] = $request->payment_option;
        $post_data['note'] = $request->note;
        $post_data['address'] = $request->address;
        $post_data['district_id'] = $request->district_id;
        $post_data['shipping_place'] = $request->shipping_place;
        $post_data['subtotal'] = $request->subtotal;
        $post_data['point_discount'] = $request->pointDiscount;
        $post_data['total_point'] = $request->totalPoint;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "clothing";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

     #custom code

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

        $prefix = 'HLG';
        $uniqueId = DB::table('orders')->count() + 1;

        // Ensure the uniqueId is limited to 4 digits
        $uniqueId = str_pad($uniqueId, 7, '0', STR_PAD_LEFT);

        $invoiceNumber = "{$prefix}-{$uniqueId}";

        $order = new Order();
        $order->customer_id = auth()->user()->id ?? null;
        $order->order_number =$invoiceNumber;
        $order->shipping_address = [
            'name' => $post_data['cus_name'],
            'mobile' => $post_data['cus_phone'],
            'email' => $post_data['cus_email'],
            'district_id' => $post_data['district_id'],
            'address' => $post_data['cus_add1'],
            'shipping_place' => $post_data['shipping_place'],
            'note' => $post_data['note']
        ];
        $order->shipping_charge = $post_data['shipping_charge'];
        $order->total_amount =  $post_data['total_amount'];
        $order->transaction_id = $post_data['tran_id'];
        $order->order_type =  $post_data['payment_option'];
        $order->payment_status = 'Pending';
         $order->total_point =  $post_data['total_point'];
        $order->point_discount =  $post_data['point_discount'];
        $order->save();
         $user = $order->user;
        // dd($user);
        if ($user) {
            $user->points += $post_data['total_point'];
            $user->save();
        }

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
             $order_details->attribute = $v_content->productAttributes->content ?? '';
            $order_details->wholesale_price = $v_content->product->wholesale_price;
            $order_details->wholesale_minimum_quantity = $v_content->product->wholesale_min_qty;
            $order_details->details = null;
            $order_details->total_price = $v_content->product->regular_price * $v_content->quantity;
            $order_details->save();
        }
        if ($user !== null) {
            $current_user = User::where('id',$user->id)->first();
            // dd($current_user);
            $remainingPoint = $user->points - $request->redeem_point;
            $current_user->update([
                'points' => $remainingPoint
            ]);
        }
        foreach($data as $cart){
            $cart->delete();
        }

//        #Before  going to initiate the payment order status need to insert or update as Pending.
//        $update_product = DB::table('orders')
//            ->where('transaction_id', $post_data['tran_id'])
//            ->updateOrInsert([
//                'name' => $post_data['cus_name'],
//                'email' => $post_data['cus_email'],
//                'phone' => $post_data['cus_phone'],
//                'amount' => $post_data['total_amount'],
//                'status' => 'Pending',
//                'address' => $post_data['cus_add1'],
//                'transaction_id' => $post_data['tran_id'],
//                'currency' => $post_data['currency']
//            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');
        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    public function payViaAjax(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $decode = json_decode($request->cart_json);

        $post_data = array();
        $post_data['total_amount'] = '100'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $decode->cus_name;
        $post_data['cus_email'] = 'cus_email';
        $post_data['cus_add1'] = 'cus_addr1';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = 'cus_phone';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                  'payment_status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
        // dd($request->all());
        // echo "Transaction is Successful";

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
             ->select('transaction_id', 'payment_status', 'status', 'currency', 'amount')->first();

        if ($order_details->payment_status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                  ->update([
                        'payment_status' => 'Paid',

                    ]);
                return redirect()->route('order.success');

            }
        } else if ($order_details->payment_status == 'Processing' || $order_details->payment_status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";

        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }
    }
    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
             ->select('transaction_id', 'status', 'payment_status', 'currency', 'amount')->first();

        if ($order_details->payment_status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['payment_status' => 'Failed']);
                    return redirect()->route('order.failed');

        } else if ($order_details->payment_status == 'Processing' || $order_details->payment_status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }
    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status','payment_status', 'currency', 'amount')->first();

        if ($order_details->payment_status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                 ->update(['payment_status' => 'Canceled','status' => 4]);
                return redirect()->route('order.cancel');
            echo "Transaction is Cancel";
        } else if ($order_details->payment_status == 'Processing' || $order_details->payment_status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status','payment_status', 'currency', 'amount')->first();

            if ($order_details->payment_status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['payment_status' => 'Paid']);

                    return redirect()->route('order.success');
                }
            } else if ($order_details->payment_status == 'Processing' || $order_details->payment_status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
