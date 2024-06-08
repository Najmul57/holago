<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
	use HasFactory;

	protected $guarded = ['id'];
	protected $fillable = ['name'];


	public function product(){
		return $this->belongsTo(Product::class);
	}

	public function productAttribute(){
		return $this->belongsTo(Attribute::class,'attribute_id');
	}

	public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_attribute_id');
    }
}
