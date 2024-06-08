<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStocks;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
	public function index()
	{
	  	$data['orders'] = Order::orderBy('id','desc')->with('customer','shipping')->paginate(20);
		return view('admin.order.index', $data);
	}
	public function create()
	{
		$data['customers'] = Customer::orderBy('id','desc')->get();
		$data['shippings'] = Shipping::orderBy('id','desc')->get();
		return view('admin.order.create', $data);
	}

	public function store(Request $request)
	{

		$request->validate([
			'order_number' => 'required',
			'customer' => 'required',
			'shipping' => 'required',
			'shipping_address' => 'required',
			'shipping_charge' => 'required',
			'total_amount' => 'required',
			'coupon_code' => 'required',
			'coupon_amount' => 'required',
			'order_type' => 'required',
			'payment_status' => 'nullable',
		]);
        $order = new Order();
		$order->order_number = $request->order_number;
		$order->customer_id = $request->customer;
		$order->shipping_id = $request->shipping;
		$order->shipping_address = $request->shipping_address;
		$order->shipping_charge = $request->shipping_charge;
		$order->total_amount = $request->total_amount;
		$order->coupon_code = $request->coupon_code;
		$order->coupon_amount = $request->coupon_amount;
		$order->order_type = $request->order_type;
		$order->payment_status = $request->payment_status;
		$order->save();

		$alert = ['success', 'Order created successfully'];
		return back()->withAlert($alert);
	}


	public function orderDetails($id)
	{
        $data['order'] = Order::where('id', $id)->with('order_details')->firstOrFail();
		$data['customers'] = Customer::orderBy('id','desc')->get();
		$data['shippings'] = Shipping::orderBy('id','desc')->get();
		return view('admin.order.order-details', $data);
	}
	public function print($id)
	{
	    $data['order'] = Order::where('id', $id)->with('order_details')->firstOrFail();
		$data['customers'] = Customer::orderBy('id','desc')->get();
		$data['shippings'] = Shipping::orderBy('id','desc')->get();
		return view('admin.order.print', $data);
	}

  	    public function changeStatus(Request $request, $id)
    {
      
        $order = Order::where('id', $id)->firstOrFail();
        $order->update([
            'status' => $request->status
        ]);
        $alert = ['success', 'Order Status Updated successfully'];
        return back()->withAlert($alert);
    }

      public function cancellStatus(Request $request, $id){
            $order = Order::where('id', $id)->firstOrFail();
            $order->status = $request->cancelled;
            $order->update();
            $alert = ['success', 'Order Status Updated successfully'];
            return back()->withAlert($alert);
      }
    public function edit($id)
	{
        $data['order'] = Order::with('order_details')->where('id', $id)->firstOrFail();
		$data['customers'] = User::orderBy('id','desc')->get();
		$data['products'] = Product::where('status',1)->with('product_attribute')->get();
		return view('admin.order.edit', $data);
	}
    public function removeItem($id)
    {
        $item = OrderDetails::where('id',$id)->firstOrFail();
        $item->delete();
        $alert = ['success', 'Order Item Delete successfully!'];
        return back()->withAlert($alert);
    }

	public function update(Request $request, $id)
	{

		$order = Order::findOrFail($id);
		$order->customer_id = $request->customer_id;
        $order->shipping_address = [
            'name' => $request->s_name,
            'mobile' => $request->s_phone,
            'email' => $request->s_email,
            'district_id' => $request->district_id,
            'address' => $request->s_address,
            'note' => $request->s_note
        ];
		$order->shipping_charge = $request->shipping_charge;
		$order->coupon_code = $request->coupon_code;
		$order->coupon_amount = $request->coupon_amount;
		$order->order_type = $request->order_type;
		$order->payment_status = $request->payment_status;
		$order->sub_total = $request->sub_total;
		$order->special_discount = $request->special_discount;
        $order->total_amount = $request->final_total - $request->special_discount;
		$order->save();
		$alert = ['success', 'Order Updated Successfully!'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$order = Order::findOrFail($request->id);
		$order->status = 1;
		$order->save();

		$alert = ['success', 'Order enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$order = Order::findOrFail($request->id);
		$order->status = 0;
		$order->save();

		$alert = ['success', 'Order disable successfully'];
		return back()->withAlert($alert);
	}

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        $alert = ['success', 'Order deleted successfully'];
        return back()->withAlert($alert);
    }
    
    
    public function getProductAttribute($id)
    {
        $product = Product::with('product_attribute')->find($id);
        return response()->json([
            'message' => "Attribute Get Successfully!",
            'data' => $product
        ]);
    }


    public function getProductAttributeQuantity($id)
    {
        $productStock = ProductStocks::whereJsonContains('attributes', $id)->select('quantity')->first();
        return response()->json([
            'message' => "stock get successfully!",
            'data' => $productStock
        ]);
    }
    
    
    public function productStore(Request $request)
    {
        try {
            $productQuantity = ProductAttribute::with('product')->find($request->attribute);
            $order = Order::find($request->order_id);
            $totalOrderAmount = $order->total_amount;
            $finalTotalAmount = $totalOrderAmount + $request->totalPrice;

            $order->update([
                'total_amount' => $finalTotalAmount
            ]);
            $orderDetails =  OrderDetails::create([
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'attribute' => $productQuantity->content,
                'quantity' => $request->quantity,
                'regular_price' => $productQuantity->product->regular_price ?? '0',
                'discount_price' => $productQuantity->product->discount_price ?? '0',
                'total_price' => $request->totalPrice,
                'status' => 1
            ]);

            $productStock = ProductStocks::whereJsonContains('attributes', $request->attribute)->first();
            $existingQuantity = $productStock->quantity;
            $currentQuantity = $existingQuantity - $request->quantity;
            $productStock->update([
                'quantity' => $currentQuantity
            ]);

            return response()->json([
                'status' => 1,
                'message' => "update successfully!",
                'orderDetails' => $orderDetails,
                'productStock' => $productStock
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => 'Update failed. Please try again.',
                'error' => $e->getMessage()
            ]);
        }}

}