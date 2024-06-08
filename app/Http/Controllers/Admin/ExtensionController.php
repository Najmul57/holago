<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Extension;

class ExtensionController extends Controller
{
     public function index(){
        $extensions = Extension::orderBy('status','desc')->get();
        return view('admin.extension.index', compact('extensions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'site_key'=>'required',
            'secret_key'=>'required',
        ]);
        $extension = Extension::findOrFail($id);
        $extension->update([
            'shortcode'=>[
                'site_key'=>$request->site_key,
                'secret_key'=>$request->secret_key,

            ]
        ]);
        $alert = ['success', $extension->name . ' has been updated'];
        return redirect()->route('admin.setting.extensions.index')->withAlert($alert);
    }

    public function activate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $extension = Extension::findOrFail($request->id);
        $extension->status = 1;
        $extension->save();
        $alert = ['success', $extension->name . ' has been activated'];
        return redirect()->route('admin.setting.extensions.index')->withAlert($alert);
    }

    public function deactivate(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $extension = Extension::findOrFail($request->id);
        $extension->status = 0;
        $extension->save();
        $alert = ['success', $extension->name . ' has been disabled'];
        return redirect()->route('admin.setting.extensions.index')->withAlert($alert);
    }
}
