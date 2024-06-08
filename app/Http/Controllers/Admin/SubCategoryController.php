<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Support\Facades\File;
use App\Models\SubCategory;
use App\Models\Setting;

class SubCategoryController extends Controller
{
	use FileUploadTrait;
	    protected $setting;
    protected $template;
    protected $templateAssets;

	public function index()
	{
		$data['sub_categories'] = SubCategory::orderBy('id','desc')->with('category')->paginate(20);
		return view('admin.sub_category.index', $data);
	}
	public function create()
	{
		$data['categories'] = Category::orderBy('id','desc')->get();
		return view('admin.sub_category.create', $data);
	}

	public function store(Request $request)
	{
		$request->validate([
			'category' => 'required',
			'name' => 'required',
			'slug' => 'nullable|unique:sub_categories,slug,',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_category' => 'nullable',
			'special_category' => 'nullable',
			'filter_category' => 'nullable',
		]);

		$sub_category = new SubCategory();
		$sub_category->category_id = $request->category;
		$sub_category->name = $request->name;
		$sub_category->slug = $request->slug ?? '';
		$sub_category->meta_title = $request->meta_title;
		$sub_category->meta_description = $request->meta_description;
		$sub_category->meta_keywords = $request->meta_keywords;
		$sub_category->top_category = $request->top_category ? 1 : 0;
		$sub_category->special_category = $request->special_category ? 1 : 0;
		$sub_category->filter_category = $request->filter_category ? 1 : 0;
		 $image = null;
        if ($request->hasFile('image')) {
            try {
                $imageData = [
                    'file' => $request->image,
                    'path' => 'assets/classicmart/images/sub_categories/',
                    'size' => '419x588',
                    'prevFile' => null,
                ];
                $image = $this->uploadFile('image', $imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something went wrong.'];
                return back()->withAlert($alert);
            }
        }
        $sub_category->image =  $image;

		$sub_category->save();
		$alert = ['success', 'Sub_category created successfully'];
		return back()->withAlert($alert);
	}

	public function edit($id)
	{
		$data['sub_category'] = SubCategory::where('id', $id)->firstOrFail();
		$data['categories'] = Category::orderBy('id','desc')->get();
		return view('admin.sub_category.edit', $data);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'category' => 'required',
			'name' => 'required',
// 			'slug' => 'nullable|unique:sub_categories,slug,',
			'meta_title' => 'nullable',
			'meta_description' => 'nullable',
			'meta_keywords' => 'nullable',
			'top_category' => 'nullable',
			'special_category' => 'nullable',
			'filter_category' => 'nullable',
		]);

		$sub_category = SubCategory::findOrFail($id);
		$sub_category->category_id = $request->category;
		$sub_category->name = $request->name;
		$sub_category->slug = $request->slug ?? '';
		$sub_category->meta_title = $request->meta_title;
		$sub_category->meta_description = $request->meta_description;
		$sub_category->meta_keywords = $request->meta_keywords;
		$sub_category->top_category = $request->top_category ? 1 : 0;
		$sub_category->special_category = $request->special_category ? 1 : 0;
		$sub_category->filter_category = $request->filter_category ? 1 : 0;
		 $image = $sub_category->image;
        if ($request->hasFile('image')) {
            try {
                $imageData = [
                    'file' => $request->image,
                    'path' => 'assets/classicmart/images/sub_categories/',
                    'size' => '419x588',
                    'prevFile' => $sub_category->image ?? null,
                ];
                $image = $this->uploadFile('image', $imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something went wrong.'];
                return back()->withAlert($alert);
            }
        }
        $sub_category->image =  $image;

		$sub_category->save();
		$alert = ['success', 'Sub_category updated successfully'];
		return back()->withAlert($alert);
	}

	public function enable(Request $request)
	{
		$sub_category = SubCategory::findOrFail($request->id);
		$sub_category->status = 1;
		$sub_category->save();

		$alert = ['success', 'Sub_category enable successfully'];
		return back()->withAlert($alert);
	}

	public function disable(Request $request)
	{
		$sub_category = SubCategory::findOrFail($request->id);
		$sub_category->status = 0;
		$sub_category->save();

		$alert = ['success', 'Sub_category disable successfully'];
		return back()->withAlert($alert);
	}

	public function destroy($id)
	{
		$sub_category = SubCategory::findOrFail($id);
		$sub_category->delete();

		$alert = ['success', 'Sub_category deleted successfully'];
		return back()->withAlert($alert);
	}

}