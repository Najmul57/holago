<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
	use HasFactory;

	protected $guarded = ['id'];


	public function subcategory(){
		return $this->belongsTo(Subcategory::class);
	}		
}
