<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploadTrait;
use App\Models\Setting;
use App\Models\SetCookie;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    use FileUploadTrait;

    protected $setting;
    protected $template;
    protected $templateAssets;

    public function __construct(){
        $this->setting = Setting::first();
        $this->template = 'templates.'.$this->setting->template.'.';
        $this->templateAssets ='assets/'. $this->setting->template.'/';
    }

    public function index()
    {
        $timezones = json_decode(file_get_contents(resource_path('views/admin/includes/timezone.json')));
        return view('admin.setting.index', compact('timezones'));

    }

    public function update(Request $request){
        $request->validate([
            'site_name'=>'required',
            'site_currency'=>'required',
            'currency_symbol'=>'required',
            'inside_dhaka'=>'required',
            'outside_dhaka'=>'required',
             'subarea_dhaka'=>'required',
             'min_point_redeem'=>'required',
             'point_redeem'=>'required',
             'point_redeem_price'=>'required',
             'min_shipping_amount'=>'required',
            'discount_image'=>'nullable'
        ]);
        $setting = Setting::first();
        $image = $setting->discount_image;
        if ($request->hasFile('discount_image')) {
            try {
                $imageData = [
                    'file'=>$request->discount_image,
                    'path'=>$this->templateAssets.'images/discount_banner/',
                    'size' => '2048x779',
                    'prevFile' => $setting->discount_image,
                ];
                $image = $this->uploadFile('discount_image', $imageData);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }
        $setting->update([
            'site_name'=>$request->site_name,
            'discount_image'=>$image,
            'site_currency'=>$request->site_currency,
            'currency_symbol'=>$request->currency_symbol,
            'inside_dhaka'=>$request->inside_dhaka,
            'outside_dhaka'=>$request->outside_dhaka,
            'subarea_dhaka'=>$request->subarea_dhaka,
            'min_point_redeem'=>$request->min_point_redeem,
            'point_redeem'=>$request->point_redeem,
            'point_redeem_price'=>$request->point_redeem_price,
            'min_shipping_amount'=>$request->min_shipping_amount,
            'tawk_chat'=>$request->tawk_chat,
            're_captcha'=>$request->re_captcha,
            'registration'=>$request->registration ? 1 : 0,
            'email_verification'=>$request->email_verification ? 1 : 0,
            'email_queue'=>$request->email_queue ? 1 : 0,
            'multi_lang'=>$request->multi_lang ? 1 : 0,
        ]);


        $timezoneFile = config_path('timezone.php');
        $content = '<?php $timezone = '.$request->timezone.' ?>';
        file_put_contents($timezoneFile, $content);

        $alert = ['success','Site setting updated successfully'];
        return back()->withAlert($alert);
    }

   public function logFav()
   {
       return view('admin.setting.logfav');
   }

   public function logFavUpdate(Request $request){
        $request->validate([
            'logo'=>'nullable|image|mimes:jpg,jpeg,png',
            'logo_dark'=>'nullable|image|mimes:jpg,jpeg,png',
            'favicon'=>'nullable|image|mimes:jpg,jpeg,png',
        ]);
        if ($request->hasFile('logo')) {
            try {
                $data = [
                    'file'=>$request->logo,
                    'path'=>$this->templateAssets.'images/logo',
                ];
                $filename = 'logo.png';
                $this->uploadImage($data,$filename);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }
        if ($request->hasFile('logo_dark')) {
            try {
                $data = [
                    'file'=>$request->logo_dark,
                    'path'=>$this->templateAssets.'images/logo',
                ];
                $filename = 'logo_dark.png';
                $this->uploadImage($data,$filename);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }
        if ($request->hasFile('favicon')) {
            try {
                $data = [
                    'file'=>$request->favicon,
                    'path'=>$this->templateAssets.'images/logo',
                ];
                $filename = 'favicon.png';
                $this->uploadImage($data,$filename);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }

        $alert = ['success','Logo & Favicon updated successfully'];
        return back()->withAlert($alert);
    }

    public function systemInfo()
    {
        $laravelVersion = app()->version();
        $serverDetails = $_SERVER;
        $currentPHP = phpversion();
        $timeZone = config('app.timezone');
        return view('admin.systeminfo',compact('currentPHP', 'laravelVersion', 'serverDetails','timeZone'));
    }

    public function optimize(){
        Artisan::call('optimize:clear');
        $alert = ['success','Cache cleared successfully'];
        return back()->withAlert($alert);
    }

    public function setCookie(){
        $cookie = SetCookie::where('data_keys','cookie.data')->firstOrFail();
        return view('admin.setting.cookie',compact('cookie'));
    }

    public function setCookieSubmit(Request $request){
        $request->validate([
            'link'=>'required',
            'description'=>'required',
        ]);
        $cookie = SetCookie::where('data_keys','cookie.data')->firstOrFail();
        $cookie->data_values = [
            'link' => $request->link,
            'description' => $request->description,
            'status' => $request->status ? 1 : 0,
        ];
        $cookie->save();
        $alert = ['success','Cookie policy updated successfully'];
        return back()->withAlert($alert);
    }


    public function seo(){
        return view('admin.setting.seo');
    }

    public function seoUpdate(Request $request){
        $request->validate([
            'keywords'=>'required|array',
            'meta_description'=>'required',
            'social_title'=>'required',
            'social_description'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $setting = Setting::first();
        $image = @$setting->seo->image;
        if ($request->hasFile('image')) {
            try {
                $data = [
                    'file'=>$request->image,
                    'path'=>$this->templateAssets.'images/seo',
                    'size'=>'590x300',
                    'prevFile'=>$image,
                ];
                $image = $this->uploadFile('image',$data);
            } catch (Exception $e) {
                $alert = ['danger','Something wrong'];
                return back()->withAlert($alert);
            }
        }
        $setting->seo = [
            'keywords'=>$request->keywords,
            'meta_description'=>$request->meta_description,
            'social_title'=>$request->social_title,
            'social_description'=>$request->social_description,
            'image'=>$image,
        ];
        $setting->save();
        $alert = ['success','SEO Setting updated successfully'];
        return back()->withAlert($alert);
    }

}