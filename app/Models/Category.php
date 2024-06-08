<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

	protected $guarded = ['id'];
	protected $casts = [
        'meta_keywords' => 'array'
    ];

	public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id')->orderBy('name');
    }

    public function allSubCategories()
    {
        return $this->subCategories()->with('children');
    }

	public function sub_category(){
		return $this->hasMany(SubCategory::class);
	}

	public function product_category(){
		return $this->hasMany(ProductCategory::class);
	}

	public function coupon_category(){
		return $this->hasMany(CouponCategory::class);
	}

	public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }
}
