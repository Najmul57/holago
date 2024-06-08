<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'setting'=>'object'
    ];

    public function currencies(){
        return $this->hasMany(GatewayCurrency::class);
    }
}
