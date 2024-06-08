<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	use HasFactory;

	protected $guarded = ['id'];
    protected $casts    = ['attributes'=>'array'];


	public function customer(){
		return $this->belongsTo(Customer::class);
	}

	public function product(){
		return $this->belongsTo(Product::class);
	}
    public function attributes()
    {
        return $this->belongsTo(ProductAttribute::class, 'attributes');
    }
    public function productAttributes()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }
}
