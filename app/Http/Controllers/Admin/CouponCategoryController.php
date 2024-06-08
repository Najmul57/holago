<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\CouponCategory;

class CouponCategoryController extends Controller
{
	public function index()
	{
		$data['coupon_categories'] = CouponCategory::orderBy('id','desc')->with('customer','coupon','order')->paginate(20);
		$data['customers'] = Customer::where('status',1)->orderBy('id','desc')->get();
		$data['coupons'] = Coupon::where('status',1)->orderBy('id','desc')->get();
		$data['orders'] = Order::where('status',1)->orderBy('id','desc')->get();
		return view('admin.coupon_category.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'customer' => 'required',
			'coupon' => 'required',
			'order' => 'required',
			'amount' => 'required',
		]);

		$coupon_category = new CouponCategory();
		$coupon_category->customer_id = $request->customer;
		$coupon_category->coupon_id = $request->coupon;
		$coupon_category->order_id = $request->order;
		$coupon_category->amount = $request->amount;
		$coupon_category->save();


		$alert = ['success', 'Coupon_category created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'customer' => 'required',
			'coupon' => 'required',
			'order' => 'required',
			'amount' => 'required',
		]);

		$coupon_category = CouponCategory::findOrFail($id);
		$coupon_category->customer_id = $request->customer_id;
		$coupon_category->coupon_id = $request->coupon_id;
		$coupon_category->order_id = $request->order_id;
		$coupon_category->amount = $request->amount;
		$coupon_category->save();

		$alert = ['success', 'Coupon_category updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$coupon_category = CouponCategory::findOrFail($request->id);
		$coupon_category->status = 1;
		$coupon_category->save();

		$alert = ['success', 'Coupon_category enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$coupon_category = CouponCategory::findOrFail($request->id);
		$coupon_category->status = 0;
		$coupon_category->save();

		$alert = ['success', 'Coupon_category disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$coupon_category = CouponCategory::findOrFail($id);
		$coupon_category->delete();

		$alert = ['success', 'Coupon_category deleted successfully'];
		return back()->withAlert($alert);
	}

}
