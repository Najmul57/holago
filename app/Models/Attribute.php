<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
	use HasFactory;

	protected $guarded = ['id'];
		

	public function assignAttributes(){
		return $this->hasMany(ProductAttribute::class, 'attribute_id');
	}
}
