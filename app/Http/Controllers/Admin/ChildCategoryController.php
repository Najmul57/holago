<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\File;
use App\Models\ChildCategory;

class ChildCategoryController extends Controller
{
	use FileUploadTrait;

	public function index()
	{
		$data['child_categories'] = ChildCategory::orderBy('id','desc')->with('subcategory')->paginate(20);
		return view('admin.child_category.index', $data);
	}
	public function create()
	{
		$data['subcategories'] = Subcategory::orderBy('id','desc')->get();
		return view('admin.child_category.create', $data);
	}

	public function store(Request $request)
	{
		$request->validate([
			'subcategory' => 'required',
			'name' => 'required',
			'icon' => 'nullable',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_category' => 'nullable',
			'special_category' => 'nullable',
			'filter_category' => 'nullable',
			'image' => 'nullable',
		]);

		$child_category = new ChildCategory();
		$child_category->subcategory_id = $request->subcategory;
		$child_category->name = $request->name;
		$child_category->icon = $request->icon;
		$child_category->meta_title = $request->meta_title;
		$child_category->meta_description = $request->meta_description;
		$child_category->meta_keywords = $request->meta_keywords;
		$child_category->top_category = $request->top_category;
		$child_category->special_category = $request->special_category;
		$child_category->filter_category = $request->filter_category;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/child_categories/',
					'size' => '1920x1100',
					'prevFile' => null,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$child_category->image =  $image;
		$child_category->save();

		$alert = ['success', 'Child_category created successfully'];
		return back()->withAlert($alert);
	}

	public function edit($id)
	{
		$data['child_category'] = ChildCategory::where('id', $id)->firstOrFail();
		$data['subcategories'] = Subcategory::orderBy('id','desc')->get();
		return view('admin.child_category.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'subcategory' => 'required',
			'name' => 'required',
			'icon' => 'nullable',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_category' => 'nullable',
			'special_category' => 'nullable',
			'filter_category' => 'nullable',
			'image' => 'nullable',
		]);

		$child_category = ChildCategory::findOrFail($id);
		$child_category->subcategory_id = $request->subcategory_id;
		$child_category->name = $request->name;
		$child_category->icon = $request->icon;
		$child_category->meta_title = $request->meta_title;
		$child_category->meta_description = $request->meta_description;
		$child_category->meta_keywords = $request->meta_keywords;
		$child_category->top_category = $request->top_category;
		$child_category->special_category = $request->special_category;
		$child_category->filter_category = $request->filter_category;
		$image = $child_category->image;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => 'assets/images/child_categories/',
					'size' => '1920x1100',
					'prevFile' => $child_category->image,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger','Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$child_category->image =  $image;
		$child_category->save();

		$alert = ['success', 'Child_category updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$child_category = ChildCategory::findOrFail($request->id);
		$child_category->status = 1;
		$child_category->save();

		$alert = ['success', 'Child_category enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$child_category = ChildCategory::findOrFail($request->id);
		$child_category->status = 0;
		$child_category->save();

		$alert = ['success', 'Child_category disable successfully'];
		return back()->withAlert($alert);
	}

	public function delete($id)
	{
		$child_category = ChildCategory::findOrFail($id);
		$child_category->delete();

		$alert = ['success', 'Child_category deleted successfully'];
		return back()->withAlert($alert);
	}

}