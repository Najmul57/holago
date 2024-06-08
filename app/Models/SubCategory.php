<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	protected $casts = [
        'meta_keywords' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id')->with('children');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }
}