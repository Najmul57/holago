<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
	use HasFactory;

	protected $guarded = ['id'];


	public function customer(){
		return $this->belongsTo(Customer::class);
	}

	public function coupon(){
		return $this->belongsTo(Coupon::class);
	}

	public function order(){
		return $this->belongsTo(Order::class);
	}		
}
