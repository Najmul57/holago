<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
	public function index()
	{
		$data['offers'] = Offer::orderBy('id','desc')->paginate(20);
		return view('admin.offer.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'discount_type' => 'required',
			'amount' => 'required',
			'start_date' => 'nullable',
			'end_date' => 'nullable',
		]);

		$offer = new Offer();
		$offer->name = $request->name;
		$offer->discount_type = $request->discount_type;
		$offer->amount = $request->amount;
		$offer->start_date = $request->start_date;
		$offer->end_date = $request->end_date;
		$offer->save();

		$alert = ['success', 'Offer created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'discount_type' => 'required',
			'amount' => 'required',
			'start_date' => 'nullable',
			'end_date' => 'nullable',
		]);

		$offer = Offer::findOrFail($id);
		$offer->name = $request->name;
		$offer->discount_type = $request->discount_type;
		$offer->amount = $request->amount;
		$offer->start_date = $request->start_date;
		$offer->end_date = $request->end_date;
		$offer->save();

		$alert = ['success', 'Offer updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$offer = Offer::findOrFail($request->id);
		$offer->status = 1;
		$offer->save();

		$alert = ['success', 'Offer enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$offer = Offer::findOrFail($request->id);
		$offer->status = 0;
		$offer->save();

		$alert = ['success', 'Offer disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$offer = Offer::findOrFail($id);
		$offer->delete();

		$alert = ['success', 'Offer deleted successfully'];
		return back()->withAlert($alert);
	}

}