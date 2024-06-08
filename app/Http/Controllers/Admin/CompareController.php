<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Compare;

class CompareController extends Controller
{
	public function index()
	{
		$data['compares'] = Compare::orderBy('id','desc')->with('customer','product')->paginate(20);
		$data['customers'] = Customer::where('status',1)->orderBy('id','desc')->get();		
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();		
		return view('admin.compare.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'session_id' => 'nullable',
		]);

		$compare = new Compare();
		$compare->customer_id = $request->customer;
		$compare->product_id = $request->product;
		$compare->session_id = $request->session_id;
		$compare->save();

		$alert = ['success', 'Compare created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'session_id' => 'nullable',
		]);

		$compare = Compare::findOrFail($id);
		$compare->customer_id = $request->customer_id;
		$compare->product_id = $request->product_id;
		$compare->session_id = $request->session_id;
		$compare->save();

		$alert = ['success', 'Compare updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$compare = Compare::findOrFail($request->id);
		$compare->status = 1;
		$compare->save();

		$alert = ['success', 'Compare enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$compare = Compare::findOrFail($request->id);
		$compare->status = 0;
		$compare->save();

		$alert = ['success', 'Compare disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$compare = Compare::findOrFail($id);
		$compare->delete();

		$alert = ['success', 'Compare deleted successfully'];
		return back()->withAlert($alert);
	}

}