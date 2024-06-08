<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
	public function index()
	{
		$data['suppliers'] = Supplier::orderBy('id','desc')->paginate(20);
		return view('admin.supplier.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'phone' => 'required',
			'email' => 'nullable',
			'address' => 'nullable',
		]);

		$supplier = new Supplier();
		$supplier->name = $request->name;
		$supplier->phone = $request->phone;
		$supplier->email = $request->email;
		$supplier->address = $request->address;
		$supplier->save();

		$alert = ['success', 'Supplier created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'phone' => 'required',
			'email' => 'nullable',
			'address' => 'nullable',
		]);

		$supplier = Supplier::findOrFail($id);
		$supplier->name = $request->name;
		$supplier->phone = $request->phone;
		$supplier->email = $request->email;
		$supplier->address = $request->address;
		$supplier->save();

		$alert = ['success', 'Supplier updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$supplier = Supplier::findOrFail($request->id);
		$supplier->status = 1;
		$supplier->save();

		$alert = ['success', 'Supplier enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$supplier = Supplier::findOrFail($request->id);
		$supplier->status = 0;
		$supplier->save();

		$alert = ['success', 'Supplier disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$supplier = Supplier::findOrFail($id);
		$supplier->delete();

		$alert = ['success', 'Supplier deleted successfully'];
		return back()->withAlert($alert);
	}

}