<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\ProductAttribute;

class ProductAttributeController extends Controller
{
	public function index()
	{
		$data['product_attributes'] = ProductAttribute::orderBy('id','desc')->with('product','attribute')->paginate(20);
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();
		$data['attributes'] = Attribute::where('status',1)->orderBy('id','desc')->get();
		return view('admin.product_attribute.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'product' => 'required',
			'attribute' => 'required',
			'name' => 'required',
			'content' => 'required',
			'extra_price' => 'nullable',
			'is_default' => 'nullable',
		]);

		$product_attribute = new ProductAttribute();
		$product_attribute->product_id = $request->product;
		$product_attribute->attribute_id = $request->attribute;
		$product_attribute->name = $request->name;
		$product_attribute->content = $request->content;
		$product_attribute->extra_price = $request->extra_price;
		$product_attribute->is_default = $request->is_default;
		$product_attribute->save();

		$alert = ['success', 'Product_attribute created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'product' => 'required',
			'attribute' => 'required',
			'name' => 'required',
			'content' => 'required',
			'extra_price' => 'nullable',
			'is_default' => 'nullable',
		]);

		$product_attribute = ProductAttribute::findOrFail($id);
		$product_attribute->product_id = $request->product_id;
		$product_attribute->attribute_id = $request->attribute_id;
		$product_attribute->name = $request->name;
		$product_attribute->content = $request->content;
		$product_attribute->extra_price = $request->extra_price;
		$product_attribute->is_default = $request->is_default;
		$product_attribute->save();

		$alert = ['success', 'Product_attribute updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$product_attribute = ProductAttribute::findOrFail($request->id);
		$product_attribute->status = 1;
		$product_attribute->save();

		$alert = ['success', 'Product_attribute enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$product_attribute = ProductAttribute::findOrFail($request->id);
		$product_attribute->status = 0;
		$product_attribute->save();

		$alert = ['success', 'Product_attribute disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$product_attribute = ProductAttribute::findOrFail($id);
		$product_attribute->delete();

		$alert = ['success', 'Product_attribute deleted successfully'];
		return back()->withAlert($alert);
	}

}
