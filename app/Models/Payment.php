<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = ['details'=>'object'];

    public function gateway_currency(){
        return $this->belongsTo(GatewayCurrency::class);
    }

    public function gatewayName(){
        return $this->gateway_currency->paymentGateway->name;
    }
    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
