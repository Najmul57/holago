<?php

namespace App\Providers;

use App\Models\Setting;
use App\Http\Traits\Diagram;
use Illuminate\Support\ServiceProvider;

class DiagramServiceProvider extends ServiceProvider
{
    use Diagram;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.includes.sidebar', function ($view) {
            $setting = Setting::first();
            $theme = $setting->template;
            $tempBars = $this->$theme();
            $view->with('tempBars', $tempBars);
        });
    }
}
