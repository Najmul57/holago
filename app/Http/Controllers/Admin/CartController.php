<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
	public function index()
	{
		$data['carts'] = Cart::orderBy('id','desc')->with('customer','product')->paginate(20);
		$data['customers'] = Customer::where('status',1)->orderBy('id','desc')->get();		
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();		
		return view('admin.cart.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'session_id' => 'nullable',
			'attributes' => 'nullable',
			'quantity' => 'nullable',
		]);

		$cart = new Cart();
		$cart->customer_id = $request->customer;
		$cart->product_id = $request->product;
		$cart->session_id = $request->session_id;
		$cart->attributes = $request->attributes;
		$cart->quantity = $request->quantity;
		$cart->save();

		$alert = ['success', 'Cart created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'session_id' => 'nullable',
			'attributes' => 'nullable',
			'quantity' => 'nullable',
		]);

		$cart = Cart::findOrFail($id);
		$cart->customer_id = $request->customer_id;
		$cart->product_id = $request->product_id;
		$cart->session_id = $request->session_id;
		$cart->attributes = $request->attributes;
		$cart->quantity = $request->quantity;
		$cart->save();

		$alert = ['success', 'Cart updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$cart = Cart::findOrFail($request->id);
		$cart->status = 1;
		$cart->save();

		$alert = ['success', 'Cart enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$cart = Cart::findOrFail($request->id);
		$cart->status = 0;
		$cart->save();

		$alert = ['success', 'Cart disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$cart = Cart::findOrFail($id);
		$cart->delete();

		$alert = ['success', 'Cart deleted successfully'];
		return back()->withAlert($alert);
	}

}