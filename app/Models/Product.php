<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	protected $guarded = ['id'];
	protected $casts = [
        'meta_keyword' => 'object'
    ];

	public function supplier(){
		return $this->belongsTo(Supplier::class);
	}
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->hasMany(SubCategory::class);
    }

	public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id','sub_category_id');
    }
    public function sub_categories()
    {
        return $this->belongsToMany(SubCategory::class,'sub_category_id');
    }

	public function product_category(){
		return $this->hasMany(ProductCategory::class);
	}

	public function product_attribute(){
		return $this->hasMany(ProductAttribute::class);
	}

	public function product_image(){
		return $this->hasMany(ProductImage::class,'product_id');
	}

	public function stocks(){
        return $this->hasMany(ProductStocks::class);
    }

	public function product_review(){
		return $this->hasMany(ProductReview::class);
	}

	public function order_details(){
		return $this->hasMany(OrderDetails::class);
	}

	public function coupon_category(){
		return $this->hasMany(CouponCategory::class);
	}

	public function offer_product(){
		return $this->hasMany(OfferProduct::class);
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

    public function productPreviewImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productVariantImages()
    {
        return $this->hasMany(ProductImage::class)->where('product_attribute_id', '!=' ,0);
    }

    public function assignAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function userReview()
    {
        return $this->hasOne(ProductReview::class, 'product_id')->where('customer_id', auth()->user()->id);
    }

}
