<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayCurrency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function paymentGateway(){
        return $this->belongsTo(PaymentGateway::class);
    }
}
