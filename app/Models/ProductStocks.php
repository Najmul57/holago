<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStocks extends Model
{
	use HasFactory;

	protected $guarded = ['id'];


	public function stockLogs(){
        return $this->hasMany(StockLog::class, 'stock_id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
    
    public function scopeQuantity($query, $id, $attributeId)
    {
        $size =  (string)$attributeId;
        return $query->where('product_id', $id)->whereJsonContains('attributes',$size);
    }
}