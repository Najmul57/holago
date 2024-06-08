<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
	public function index()
	{
		$data['shippings'] = Shipping::orderBy('id','desc')->paginate(20);
		return view('admin.shipping.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'charge' => 'required',
			'delivery_time' => 'required',
			'description' => 'nullable',
		]);

		$shipping = new Shipping();
		$shipping->name = $request->name;
		$shipping->charge = $request->charge;
		$shipping->delivery_time = $request->delivery_time;
		$shipping->description = $request->description;
		$shipping->save();

		$alert = ['success', 'Shipping created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'charge' => 'required',
			'delivery_time' => 'required',
			'description' => 'nullable',
		]);

		$shipping = Shipping::findOrFail($id);
		$shipping->name = $request->name;
		$shipping->charge = $request->charge;
		$shipping->delivery_time = $request->delivery_time;
		$shipping->description = $request->description;
		$shipping->save();

		$alert = ['success', 'Shipping updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$shipping = Shipping::findOrFail($request->id);
		$shipping->status = 1;
		$shipping->save();

		$alert = ['success', 'Shipping enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$shipping = Shipping::findOrFail($request->id);
		$shipping->status = 0;
		$shipping->save();

		$alert = ['success', 'Shipping disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$shipping = Shipping::findOrFail($id);
		$shipping->delete();

		$alert = ['success', 'Shipping deleted successfully'];
		return back()->withAlert($alert);
	}

}