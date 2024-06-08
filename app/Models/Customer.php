<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	use HasFactory;

	protected $guarded = ['id'];
		

	public function product_review(){
		return $this->hasMany(ProductReview::class);
	}

	public function order(){
		return $this->hasMany(Order::class);
	}

	public function coupon_category(){
		return $this->hasMany(CouponCategory::class);
	}

	public function wishlist(){
		return $this->hasMany(Wishlist::class);
	}

	public function compare(){
		return $this->hasMany(Compare::class);
	}

	public function cart(){
		return $this->hasMany(Cart::class);
	}
}
