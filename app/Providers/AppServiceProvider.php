<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Models\Extension;
use Illuminate\Support\Str;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $viewShare['setting'] = Setting::first();
        $viewShare['template'] ='templates.'. $viewShare['setting']->template.'.';
        $viewShare['templateInclude'] ='templates.'. $viewShare['setting']->template.'.includes.';
        $viewShare['templateUserInclude'] ='templates.'. $viewShare['setting']->template.'.user.includes.';
        $viewShare['templateAssets'] ='assets/'. $viewShare['setting']->template.'/';
        $viewShare['extension'] = Extension::get();
        view()->share($viewShare);

        Str::macro('strToKey',function($str){
            $str = str_replace(' ', '_', $str);
            $str = str_replace('-', '_', $str);
            $str = strtolower($str);
            return $str;
        });

        Str::macro('keyToStr',function($str){
            $str = str_replace('_', ' ', $str);
            $str = ucfirst($str);
            return $str;
        });


        Paginator::useBootstrap();
    }

}
