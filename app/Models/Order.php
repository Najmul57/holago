<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use HasFactory;
    protected $casts = [
        'shipping_address' => 'array',
    ];

	protected $guarded = ['id'];


	public function customer(){
		return $this->belongsTo(Customer::class);
	}

	public function shipping(){
		return $this->belongsTo(Shipping::class);
	}

	public function order_details(){
		return $this->hasMany(OrderDetails::class);
	}

	public function coupon_category(){
		return $this->hasMany(CouponCategory::class);
	}
	public function user()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
	
	
}