<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\File;
use App\Models\ProductImage;

class ProductImageController extends Controller
{
	use FileUploadTrait;

	public function index()
	{
		$data['product_images'] = ProductImage::orderBy('id','desc')->with('product')->paginate(20);
		$data['products'] = Product::where('status',1)->orderBy('id','desc')->get();		
		return view('admin.product_image.index', $data);
	}
	public function store(Request $request)
	{
		$request->validate([
			'product' => 'required',
			'image' => 'nullable',
		]);

		$product_image = new ProductImage();
		$product_image->product_id = $request->product;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/product_images/',
					'size' => '1920x1100',
					'prevFile' => null,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$product_image->image =  $image;
		$product_image->save();

		$alert = ['success', 'Product_image created successfully'];
		return back()->withAlert($alert);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'product' => 'required',
			'image' => 'nullable',
		]);

		$product_image = ProductImage::findOrFail($id);
		$product_image->product_id = $request->product_id;
		$image = $product_image->image;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/product_images/',
					'size' => '1920x1100',
					'prevFile' => $product_image->image,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$product_image->image =  $image;
		$product_image->save();

		$alert = ['success', 'Product_image updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$product_image = ProductImage::findOrFail($request->id);
		$product_image->status = 1;
		$product_image->save();

		$alert = ['success', 'Product_image enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$product_image = ProductImage::findOrFail($request->id);
		$product_image->status = 0;
		$product_image->save();

		$alert = ['success', 'Product_image disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$product_image = ProductImage::findOrFail($id);
		$product_image->delete();

		$alert = ['success', 'Product_image deleted successfully'];
		return back()->withAlert($alert);
	}

}