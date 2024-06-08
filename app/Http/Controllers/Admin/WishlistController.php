<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
	public function index()
	{
		$data['wishlists'] = Wishlist::orderBy('id','desc')->with('customer','product')->paginate(20);
		$data['customers'] = Customer::where('status',1)->orderBy('id','desc')->get();		
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();		
		return view('admin.wishlist.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'session_id' => 'nullable',
		]);

		$wishlist = new Wishlist();
		$wishlist->customer_id = $request->customer;
		$wishlist->product_id = $request->product;
		$wishlist->session_id = $request->session_id;
		$wishlist->save();

		$alert = ['success', 'Wishlist created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'session_id' => 'nullable',
		]);

		$wishlist = Wishlist::findOrFail($id);
		$wishlist->customer_id = $request->customer_id;
		$wishlist->product_id = $request->product_id;
		$wishlist->session_id = $request->session_id;
		$wishlist->save();

		$alert = ['success', 'Wishlist updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$wishlist = Wishlist::findOrFail($request->id);
		$wishlist->status = 1;
		$wishlist->save();

		$alert = ['success', 'Wishlist enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$wishlist = Wishlist::findOrFail($request->id);
		$wishlist->status = 0;
		$wishlist->save();

		$alert = ['success', 'Wishlist disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$wishlist = Wishlist::findOrFail($id);
		$wishlist->delete();

		$alert = ['success', 'Wishlist deleted successfully'];
		return back()->withAlert($alert);
	}

}