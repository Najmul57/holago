<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Models\language;
use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        $languages = Language::get();
        return view('admin.language.index',compact('languages'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'code'=>'required',
            'image'=>'required|image|mimes:jpg,jpeg,png',
        ]);

        $data = '{}';
        $json_file = strtolower($request->code) . '.json';
        $path = resource_path('lang/') . $json_file;
        File::put($path, $data);

        if ($request->default) {
            Language::where('is_default', 1)->update([
                'is_default' => 0
            ]);
        }

        if ($request->hasFile('image')) {
            try {
                $imageData = [
                    'file'=>$request->image,
                    'path'=>'assets/images/language/',
                    'size'=>'120x120',
                    'prevFile'=>null,
                ];
                $image = $this->uploadFile('image',$imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }

        Language::create([
            'icon' => $image,
            'name' => $request->name,
            'lang_code' => strtolower($request->code),
            'is_default' => $request->default ? 1 : 0,
        ]);

        $alert = ['success','Language created successfully'];
        return back()->withAlert($alert);
    }

    public function edit(Request $request,$id)
    {
        $request->validate([
            'name'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $language = Language::find($id);
        if (!$language) {
            $alert = ['danger','Language not found'];
            return back()->withAlert($alert);
        }
        if ($request->is_default) {
            Language::where('is_default', 1)->update([
                'is_default' => 0
            ]);
        }

        $image = $language->icon;
        if ($request->hasFile('image')) {
            try {
                $imageData = [
                    'file'=>$request->image,
                    'path'=>'assets/images/language/',
                    'size'=>'120x120',
                    'prevFile'=>$language->icon,
                ];
                $image = $this->uploadFile('image',$imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }

        $language->name = $request->name;
        $language->is_default = $request->is_default ? 1 : 0;
        $language->icon = $image;
        $language->save();

        $alert = ['success','Language udpated successfully'];
        return back()->withAlert($alert);
    }

    public function delete(Request $request,$id)
    {
        $language = Language::findOrFail($id);
        $location = 'assets/images/language/'.$language->icon;
        $this->deleteFile($location);
        $language->delete();
        $alert = ['success','Language deleted successfully'];
        return back()->withAlert($alert);
    }

    public function langTranslate($id)
    {
        $lang = Language::find($id);
        $title = "Update " . $lang->name;
        $json = file_get_contents(resource_path('lang/') . $lang->lang_code . '.json');
        $list_lang = Language::all();


        if (empty($json)) {
            $alert = ['danger', 'File not found'];
            return back()->withAlert($alert);
        }
        $json = json_decode($json);

        return view('admin.language.langtranslate', compact('title', 'json', 'lang', 'list_lang'));
    }
    public function storeJson(Request $request,$id)
    {
        $lang = Language::find($id);
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);

        $items = file_get_contents(resource_path('lang/') . $lang->lang_code . '.json');

        $reqKey = trim($request->key);

        if (array_key_exists($reqKey, json_decode($items, true))) {
            $alert = ['danger', "`$reqKey` Already exist"];
            return back()->withAlert($alert);
        } else {
            $newArr[$reqKey] = trim($request->value);
            $itemsss = json_decode($items, true);
            $result = array_merge($itemsss, $newArr);
            file_put_contents(resource_path('lang/') . $lang->lang_code . '.json', json_encode($result));
            $alert = ['success', "`".trim($request->key)."` has been added"];
            return back()->withAlert($alert);
        }
    }

    public function deleteJson(Request $request,$id)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required'
        ]);

        $reqkey = $request->key;
        $lang = Language::find($id); 
        $data = file_get_contents(resource_path('lang/') . $lang->lang_code . '.json');

        $json_arr = json_decode($data, true);
        unset($json_arr[$reqkey]);

        file_put_contents(resource_path('lang/'). $lang->lang_code . '.json', json_encode($json_arr));
        $alert = ['success', "`".trim($request->key)."` has been removed"];
        return back()->withAlert($alert);
    }

    public function updateJson(Request $request,$id)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required'
        ]);

        $reqkey = trim($request->key);
        $reqValue = $request->value;
        $lang = Language::find($id);

        $data = file_get_contents(resource_path('lang/') . $lang->lang_code . '.json');

        $json_arr = json_decode($data, true);

        $json_arr[$reqkey] = $reqValue;

        file_put_contents(resource_path('lang/'). $lang->lang_code . '.json', json_encode($json_arr));

        $alert = ['success', 'Updated successfully'];
        return back()->withAlert($alert);
    }
}
