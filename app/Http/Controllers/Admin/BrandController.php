<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\File;
use App\Models\Brand;

class BrandController extends Controller
{
	use FileUploadTrait;

	public function index()
	{
		$data['brands'] = Brand::orderBy('id','desc')->paginate(20);
		return view('admin.brand.index', $data);
	}
	public function create()
	{
		return view('admin.brand.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_brand' => 'nullable',
			'image' => 'nullable',
		]);

		$brand = new Brand();
		$brand->name = $request->name;
		$brand->meta_title = $request->meta_title;
		$brand->meta_description = $request->meta_description;
		$brand->meta_keywords = $request->meta_keywords;
		$brand->top_brand = $request->top_brand ? 1 : 0;
		$image = null;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/brands/',
					'size' => '1920x1100',
					'prevFile' => null,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$brand->image =  $image;
		$brand->save();

		$alert = ['success', 'Brand created successfully'];
		return back()->withAlert($alert);
	}

	public function edit($id)
	{
		$data['brand'] = Brand::where('id', $id)->firstOrFail();
		return view('admin.brand.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_brand' => 'nullable',
			'image' => 'nullable',
		]);

		$brand = Brand::findOrFail($id);
		$brand->name = $request->name;
		$brand->meta_title = $request->meta_title;
		$brand->meta_description = $request->meta_description;
		$brand->meta_keywords = $request->meta_keywords;
		$brand->top_brand = $request->top_brand ? 1 : 0;
		$image = $brand->image;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/brands/',
					'size' => '1920x1100',
					'prevFile' => $brand->image,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$brand->image =  $image;
		$brand->save();

		$alert = ['success', 'Brand updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$brand = Brand::findOrFail($request->id);
		$brand->status = 1;
		$brand->save();

		$alert = ['success', 'Brand enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$brand = Brand::findOrFail($request->id);
		$brand->status = 0;
		$brand->save();

		$alert = ['success', 'Brand disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$brand = Brand::findOrFail($id);
		$brand->delete();

		$alert = ['success', 'Brand deleted successfully'];
		return back()->withAlert($alert);
	}

}