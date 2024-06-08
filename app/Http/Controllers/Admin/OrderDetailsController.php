<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;

class OrderDetailsController extends Controller
{
	public function index()
	{
		$data['order_details'] = OrderDetails::orderBy('id','desc')->with('order','product')->paginate(20);
		return view('admin.order_details.index', $data);
	}
	public function create()
	{
		$data['orders'] = Order::orderBy('id','desc')->get();
		$data['products'] = Product::orderBy('id','desc')->get();
		return view('admin.order_details.create', $data);
	}

	public function store(Request $request)
	{
		$request->validate([
			'order' => 'required',
			'product' => 'required',
			'buying_price' => 'required',
			'regular_price' => 'required',
			'wholesale_price' => 'nullable',
			'wholesale_minimum_quantity' => 'nullable',
			'total_price' => 'required',
			'details' => 'nullable',
		]);

		$order_details = new OrderDetails();
		$order_details->order_id = $request->order;
		$order_details->product_id = $request->product;
		$order_details->buying_price = $request->buying_price;
		$order_details->regular_price = $request->regular_price;
		$order_details->wholesale_price = $request->wholesale_price;
		$order_details->wholesale_minimum_quantity = $request->wholesale_minimum_quantity;
		$order_details->total_price = $request->total_price;
		$order_details->details = $request->details;
		$order_details->save();

		$alert = ['success', 'Order_details created successfully'];
		return back()->withAlert($alert);
	}

	public function edit($id)
	{
		$data['order_details'] = OrderDetails::where('id', $id)->firstOrFail();
		$data['orders'] = Order::orderBy('id','desc')->get();
		$data['products'] = Product::orderBy('id','desc')->get();
		return view('admin.order_details.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'order' => 'required',
			'product' => 'required',
			'buying_price' => 'required',
			'regular_price' => 'required',
			'wholesale_price' => 'nullable',
			'wholesale_minimum_quantity' => 'nullable',
			'total_price' => 'required',
			'details' => 'nullable',
		]);

		$order_details = OrderDetails::findOrFail($id);
		$order_details->order_id = $request->order_id;
		$order_details->product_id = $request->product_id;
		$order_details->buying_price = $request->buying_price;
		$order_details->regular_price = $request->regular_price;
		$order_details->wholesale_price = $request->wholesale_price;
		$order_details->wholesale_minimum_quantity = $request->wholesale_minimum_quantity;
		$order_details->total_price = $request->total_price;
		$order_details->details = $request->details;
		$order_details->save();

		$alert = ['success', 'Order_details updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$order_details = OrderDetails::findOrFail($request->id);
		$order_details->status = 1;
		$order_details->save();

		$alert = ['success', 'Order_details enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$order_details = OrderDetails::findOrFail($request->id);
		$order_details->status = 0;
		$order_details->save();

		$alert = ['success', 'Order_details disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$order_details = OrderDetails::findOrFail($id);
		$order_details->delete();

		$alert = ['success', 'Order_details deleted successfully'];
		return back()->withAlert($alert);
	}

}