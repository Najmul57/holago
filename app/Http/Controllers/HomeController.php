<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\ApiGateway;
use App\Http\Traits\IpnGateway;
use App\Models\GatewayCurrency;
use App\Models\Payment;
use App\Models\Setting;

class HomeController extends Controller
{
    protected $setting;
    protected $template;

    public function __construct(){
        $this->setting = Setting::first();
        $this->template = 'templates.'.$this->setting->template.'.';
    }

    public function about()
    {
        return view($this->template.'about');
    }
    public function location()
    {
        return view($this->template.'location');
    }
    public function privacyPolicy()
    {
        return view($this->template.'privacy-policy');
    }
    public function club()
    {
        return view($this->template.'club');
    }
    public function refund()
    {
        return view($this->template.'refund');
    }
    public function tou()
    {
        return view($this->template.'tou');
    }
    public function requestCallback()
    {
        return view($this->template.'callback');
    }
    public function orderTracking()
    {
        return view($this->template.'order-racking');
    }
    public function needHelp()
    {
        return view($this->template.'need-help');
    }

}
