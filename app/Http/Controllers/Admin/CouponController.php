<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
	public function index()
	{
		$data['coupons'] = Coupon::orderBy('id','desc')->paginate(20);
		return view('admin.coupon.index', $data);
	}
	public function create()
	{
		return view('admin.coupon.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'code' => 'required',
			'discount_type' => 'required',
			'amount' => 'required',
		]);

		$coupon = new Coupon();
		$coupon->name = $request->name;
		$coupon->code = $request->code;
		$coupon->discount_type = $request->discount_type;
		$coupon->coupon_amount = $request->amount;
		$coupon->save();

		$alert = ['success', 'Coupon created successfully'];
		return back()->withAlert($alert);
	}

	public function edit($id)
	{
		$data['coupon'] = Coupon::where('id', $id)->firstOrFail();
		return view('admin.coupon.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'code' => 'required',
			'discount_type' => 'required',
			'amount' => 'required',
		]);

		$coupon = Coupon::findOrFail($id);
		$coupon->name = $request->name;
		$coupon->code = $request->code;
		$coupon->discount_type = $request->discount_type;
		$coupon->coupon_amount = $request->amount;
		$coupon->save();

		$alert = ['success', 'Coupon updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$coupon = Coupon::findOrFail($request->id);
		$coupon->status = 1;
		$coupon->save();

		$alert = ['success', 'Coupon enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$coupon = Coupon::findOrFail($request->id);
		$coupon->status = 0;
		$coupon->save();

		$alert = ['success', 'Coupon disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$coupon = Coupon::findOrFail($id);
		$coupon->delete();

		$alert = ['success', 'Coupon deleted successfully'];
		return back()->withAlert($alert);
	}

}