<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Setting;
use App\http\Traits\Diagram;

class DiagramController extends Controller
{
    use Diagram;

    protected $template;

    public function __construct(){
        $setting = Setting::first();
        $theme = $setting->template;
        $this->template = $this->$theme();
    }

    public function item($key){
        $tempArr = $this->template;
        if(!array_key_exists($key, $tempArr)){
            abort(404);
        }
        $item = $tempArr[$key];
        $hasImage = searchForKey(true,'is_image', $item['single_item']);
        $title = $item['name'];
        $basis = $this->getTemplateModule($key,false);
        $themeDatas = null;
        if (array_key_exists('multiple_item', $item)) {
            $themeDatas = $this->getTemplateModule($key,true);
        }
        $basisName = $key;
        return view('admin.template.module',compact('item','title','hasImage','key','basis','basisName','themeDatas'));
    }

    public function create($key){
        $tempArr = $this->template;
        if(!array_key_exists($key, $tempArr)){
            abort(404);
        }
        $item = $tempArr[$key];
        $hasImage = searchForKey(true,'is_image', $item['multiple_item']);
        $title = $item['name'];
        $basisName = $key;
        return view('admin.template.add',compact('item','title','hasImage','basisName'));
    }

    public function edit($key,$id){
        $tempArr = $this->template;
        if(!array_key_exists($key, $tempArr)){
            abort(404);
        }
        $basis = Template::findOrFail($id);
        $item = $tempArr[$key];
        $hasImage = searchForKey(true,'is_image', $item['multiple_item']);
        $title = $item['name'];
        $basisName = $key;
        return view('admin.template.edit',compact('item','title','hasImage','basisName','basis'));
    }




}
