<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductReview;

class ProductReviewController extends Controller
{
	public function index()
	{
		$data['product_reviews'] = ProductReview::orderBy('id','desc')->with('customer','product')->paginate(20);
		$data['customers'] = Customer::where('status',1)->orderBy('id','desc')->get();		
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();		
		return view('admin.product_review.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'review' => 'required',
			'rating' => 'required',
		]);

		$product_review = new ProductReview();
		$product_review->customer_id = $request->customer;
		$product_review->product_id = $request->product;
		$product_review->review = $request->review;
		$product_review->rating = $request->rating;
		$product_review->save();

		$alert = ['success', 'Product_review created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'customer' => 'required',
			'product' => 'required',
			'review' => 'required',
			'rating' => 'required',
		]);

		$product_review = ProductReview::findOrFail($id);
		$product_review->customer_id = $request->customer_id;
		$product_review->product_id = $request->product_id;
		$product_review->review = $request->review;
		$product_review->rating = $request->rating;
		$product_review->save();

		$alert = ['success', 'Product_review updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$product_review = ProductReview::findOrFail($request->id);
		$product_review->status = 1;
		$product_review->save();

		$alert = ['success', 'Product_review enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$product_review = ProductReview::findOrFail($request->id);
		$product_review->status = 0;
		$product_review->save();

		$alert = ['success', 'Product_review disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$product_review = ProductReview::findOrFail($id);
		$product_review->delete();

		$alert = ['success', 'Product_review deleted successfully'];
		return back()->withAlert($alert);
	}

}