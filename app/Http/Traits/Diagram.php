<?php

namespace App\Http\Traits;

use HTMLPurifier;
use App\Models\Setting;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\ManageTemplate;


trait Diagram
{

	use FileUploadTrait, ManageTemplate;

	protected static $validate 			= [];
	protected static $filenames 		= [];
	protected static $filePath 			= '';
	protected static $imageFilePath 	= '';
	protected static $basisValue 		= [];
	protected static $existedBasis 	= null;


	//Save Data
	public function basisSave(Request $request,$id = null){
		$key = $request->key;
		$setting = Setting::first();
		$theme = $setting->template;
		$tempArr = $this->$theme();
		if(!array_key_exists($key, $tempArr)){
    		abort(404);
    	}
    	$item = $tempArr[$key];
    	$fields = $item[$request->type];

		self::$filePath = 'assets/'.$setting->template.'/'.'files/'.$key.'/';
		self::$imageFilePath = 'assets/'.$setting->template.'/'.'images/'.$key.'/';

    	$methods = ['validation','purify','fileUpload','createItemValue'];

    	$basis = new Template;
    	if ($id) {
    		$basis = Template::findOrFail($id);
    	}
    	self::$existedBasis = $basis;

    	foreach ($methods as $k => $method) {
    		$this->fieldLoop($fields,$request,$method);
    		if ($k == 0) {
				$request->validate(self::$validate);
    		}
    	}


		$basis->name = $key;
		$basis->data = self::$basisValue;
		$basis->is_multiple = self::isMultiple($request->type);
		$basis->template_name = $setting->template;
		$basis->save();

		$alert = ['success', ucfirst(str_replace('_', ' ', $basis->name)).' saved successfully'];
		return back()->withAlert($alert);

	}

	//Remove Data
	public function remove ($id)
	{
		$basis = Template::findOrFail($id);
		$basis->delete();

		$alert = ['success', ucfirst(str_replace('_', ' ', $basis->name)). ' deleted successfully'];
		return back()->withAlert($alert);
	}

	//Validation
	protected function validation($request,$data,$key,$validation = []){
		if (@$data['required'] && $data['required'] == true) {
			if (($data['type'] == 'file') && self::$existedBasis->id) {
				$validation[$key][] = 'nullable';
			}else{
				$validation[$key][] = 'required';
			}
		}
		if (@$data['type'] == 'file') {
			if (@$data['is_image'] == true) {
				$validation[$key][] = 'image';
			}
			$validation[$key][] = 'mimes:'.$data['mimes'];
		}
		if (@$data['type'] == 'select') {
			$validation[$key][] = 'in:'.implode(',', $data['options']);
		}
		if (@$validation[$key]) {
			$validation[$key] = implode('|', $validation[$key]);
			static::$validate = array_merge(static::$validate,$validation);
		}
	}

	//Html Purifier

	protected function purify($request, $data, $key)
	{
		$purifier = new HTMLPurifier();

		if (@$data['type'] != 'file') {
			$purifier->purify($request->$key);
		}
	}

	//File Upload
	protected function fileUpload($request, $data, $key)
	{
		if (@$data['type'] == 'file') {

			$basis = self::$existedBasis;
			$oldFile = null;

			if ($basis->id) {
				$oldFile = $basis->data->$key;
			}

			if ($request->hasFile($key)) {
				$type = 'others';
				$size = null;
				$path = self::$filePath;

				if (@$data['is_image'] == true) {
					$type 	= 'image';
					$size 	= $data['size'];
					$path 	= self::$imageFilePath;
				}

				$imageData = [
					'file'		=> $request->$key,
					'path'		=> $path,
					'size'		=> $size,
					'prevFile'	=> $oldFile,
				];

				$filename[$key] = $this->uploadFile($type, $imageData);

			}else{

				$filename[$key] = $oldFile;

			}

			self::$filenames = array_merge(self::$filenames, $filename);
		}
	}

	//create or update
	protected function createItemValue($request, $data, $key)
	{
		if (@$data['type'] == 'checkbox') {
			$item[$key] = @$request->$key ? '1'	: '0';
		}elseif (@$data['type'] == 'file'){
			if (array_key_exists($key, self::$filenames)) {
				$item[$key] = self::$filenames[$key];
			}
		}else{
			$item[$key] = $request->$key;
		}
		self::$basisValue = array_merge(self::$basisValue, $item);
	}

	//Field loop
	protected function fieldLoop($fields, $request, $method)
	{
		foreach ($fields as $key => $data)
		{
			$this->$method($request, $data, $key);
		}
	}


	public function classicmart()
	{
		$array = $this->getTemplateSection();
	    return $array;
	}

	//Multiple
	private static function isMultiple($type)
	{
		if ($type == 'single_item') {
			$is_multiple = 0;
		}else{
			$is_multiple = 1;
		}
		return $is_multiple;
	}

	public function getTemplateModule($key, $isMultiple)
	{
		$setting = Setting::first();
		$template = $setting->template;
		if ($isMultiple) {
			$item = Template::where('name',$key)->where('template_name', $setting->template)->where('is_multiple', 1)->get();
		}else{
			$item = Template::where('name', $key)->where('template_name', $setting->template)->where('is_multiple', 0)->first();
		}

		return $item;
	}

}

?>
