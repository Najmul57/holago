<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Setting;

class CategoryController extends Controller
{
	use FileUploadTrait;

	protected $setting;
	protected $template;
	protected $templateAssets;

	public function __construct()
	{
		$this->setting = Setting::first();
		$this->template = 'templates.' . $this->setting->template . '.';
		$this->templateAssets = 'assets/' . $this->setting->template . '/';
	}

	public function index()
	{
		$data['categories'] = Category::orderBy('id', 'desc')->paginate(20);
		return view('admin.category.index', $data);
	}
	public function create()
	{
		return view('admin.category.create');
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required',
			 'slug' => 'nullable|unique:categories,slug,',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_category' => 'nullable',
			'special_category' => 'nullable',
			'filter_category' => 'nullable',
			'image' => 'nullable',
		]);

		$category = new Category();
		$category->name = $request->name;
		$category->slug = $request->slug ?? '';
		$category->tip_text = $request->tip_text ?? null;
		$category->tip_status = $request->tip_status ? 1 : 0;
        $category->tip_bg = ($category->tip_status == 1) ? $request->tip_bg : null;
		$category->meta_title = $request->meta_title;
		$category->meta_description = $request->meta_description;
		$category->meta_keywords = $request->meta_keywords;
		$category->top_category = $request->top_category ? 1 : 0;
		$category->special_category = $request->special_category ? 1 : 0;
		$category->filter_category = $request->filter_category ? 1 : 0;
		$image = null;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => $this->templateAssets . 'images/categories/',
					'size' => '359x538',
					'prevFile' => null,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger', 'Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$category->image =  $image;
		$category->save();
		$alert = ['success', 'Category created successfully'];
		return back()->withAlert($alert);
	}
	public function edit($id)
	{
		$data['category'] = Category::where('id', $id)->firstOrFail();
		return view('admin.category.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
// 			'slug' => 'nullable|unique:categories,slug,',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_category' => 'nullable',
			'special_category' => 'nullable',
			'filter_category' => 'nullable',
			'image' => 'nullable',
		]);
		$category = Category::findOrFail($id);
		$category->name = $request->name;
		$category->slug = $request->slug ?? '';
		$category->tip_status = $request->input('tip_status') == '1' ? 1 : 0;
		$category->tip_text = $request->tip_text ?? null;
        $category->tip_bg = ($category->tip_status == 1) ? $request->tip_bg : null;
		
		$category->meta_title = $request->meta_title;
		$category->meta_description = $request->meta_description;
		$category->meta_keywords = $request->meta_keywords;
		$category->top_category = $request->top_category ? 1 : 0;
		$category->special_category = $request->special_category ? 1 : 0;
		$category->filter_category = $request->filter_category ? 1 : 0;
		$image = $category->image;
		if ($request->hasFile('image')) {
			try {
				$imageData = [
					'file' => $request->image,
					'path' => $this->templateAssets . 'images/categories/',
					'size' => '359x538',
					'prevFile' => $category->image,
				];
				$image = $this->uploadFile('image', $imageData);
			} catch (Exception $e) {
				$alert = ['danger', 'Something went wrong.'];
				return back()->withAlert($alert);
			}
		}
		$category->image =  $image;
		$category->save();
		$alert = ['success', 'Category updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$category = Category::findOrFail($request->id);
		$category->status = 1;
		$category->save();
		$alert = ['success', 'Category enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$category = Category::findOrFail($request->id);
		$category->status = 0;
		$category->save();
		$alert = ['success', 'Category disable successfully'];
		return back()->withAlert($alert);
	}

	public function destroy($id)
	{
	   $category = Category::with('products','sub_category')->find($id);
		$category->delete();
		$alert = ['success', 'Category deleted successfully'];
		return back()->withAlert($alert);
	}
}