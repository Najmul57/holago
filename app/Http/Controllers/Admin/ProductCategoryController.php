<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
	public function index()
	{
		$data['product_categories'] = ProductCategory::orderBy('id','desc')->with('category','product')->paginate(20);
		$data['categories'] = Category::where('status',1)->orderBy('id','desc')->get();		
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();		
		return view('admin.product_category.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'category' => 'required',
			'product' => 'required',
		]);

		$product_category = new ProductCategory();
		$product_category->category_id = $request->category;
		$product_category->product_id = $request->product;
		$product_category->save();

		$alert = ['success', 'Product_category created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'category' => 'required',
			'product' => 'required',
		]);

		$product_category = ProductCategory::findOrFail($id);
		$product_category->category_id = $request->category_id;
		$product_category->product_id = $request->product_id;
		$product_category->save();

		$alert = ['success', 'Product_category updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$product_category = ProductCategory::findOrFail($request->id);
		$product_category->status = 1;
		$product_category->save();

		$alert = ['success', 'Product_category enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$product_category = ProductCategory::findOrFail($request->id);
		$product_category->status = 0;
		$product_category->save();

		$alert = ['success', 'Product_category disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$product_category = ProductCategory::findOrFail($id);
		$product_category->delete();

		$alert = ['success', 'Product_category deleted successfully'];
		return back()->withAlert($alert);
	}

}