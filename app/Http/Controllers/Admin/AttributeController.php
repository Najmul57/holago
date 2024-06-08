<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
	public function index()
	{
		$data['attributes'] = Attribute::orderBy('id','desc')->paginate(20);
		return view('admin.attribute.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'value_type' => 'required',
		]);

		$attribute = new Attribute();
		$attribute->name = $request->name;
		$attribute->value_type = $request->value_type;
		$attribute->save();

		$alert = ['success', 'Attribute created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'value_type' => 'required',
		]);

		$attribute = Attribute::findOrFail($id);
		$attribute->name = $request->name;
		$attribute->value_type = $request->value_type;
		$attribute->save();

		$alert = ['success', 'Attribute updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$attribute = Attribute::findOrFail($request->id);
		$attribute->status = 1;
		$attribute->save();

		$alert = ['success', 'Attribute enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$attribute = Attribute::findOrFail($request->id);
		$attribute->status = 0;
		$attribute->save();

		$alert = ['success', 'Attribute disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$attribute = Attribute::findOrFail($id);
		$attribute->delete();

		$alert = ['success', 'Attribute deleted successfully'];
		return back()->withAlert($alert);
	}

}