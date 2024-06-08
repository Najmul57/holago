<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Purchase;

class PaymentController extends Controller
{
    public function list()
    {
        $payments = Payment::orderBy('id','desc')->paginate(20);
        return view('admin.payment.list',compact('payments'));
    }

    public function purchaseList()
    {
        $purchses = Purchase::orderBy('id','desc')->paginate(20);
        return view('admin.payment.purchse',compact('purchses'));
    }
}
