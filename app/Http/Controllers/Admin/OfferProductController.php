<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Product;
use App\Models\OfferProduct;

class OfferProductController extends Controller
{
	public function index()
	{
		$data['offer_products'] = OfferProduct::orderBy('id','desc')->with('offer','product')->paginate(20);
		$data['offers'] = Offer::where('status',1)->orderBy('id','desc')->get();		
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();		
		return view('admin.offer_product.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'offer' => 'required',
			'product' => 'required',
		]);

		$offer_product = new OfferProduct();
		$offer_product->offer_id = $request->offer;
		$offer_product->product_id = $request->product;
		$offer_product->save();

		$alert = ['success', 'Offer_product created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'offer' => 'required',
			'product' => 'required',
		]);

		$offer_product = OfferProduct::findOrFail($id);
		$offer_product->offer_id = $request->offer_id;
		$offer_product->product_id = $request->product_id;
		$offer_product->save();

		$alert = ['success', 'Offer_product updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$offer_product = OfferProduct::findOrFail($request->id);
		$offer_product->status = 1;
		$offer_product->save();

		$alert = ['success', 'Offer_product enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$offer_product = OfferProduct::findOrFail($request->id);
		$offer_product->status = 0;
		$offer_product->save();

		$alert = ['success', 'Offer_product disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$offer_product = OfferProduct::findOrFail($id);
		$offer_product->delete();

		$alert = ['success', 'Offer_product deleted successfully'];
		return back()->withAlert($alert);
	}

}