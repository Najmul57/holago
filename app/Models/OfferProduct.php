<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferProduct extends Model
{
	use HasFactory;

	protected $guarded = ['id'];


	public function offer(){
		return $this->belongsTo(Offer::class);
	}

	public function product(){
		return $this->belongsTo(Product::class);
	}		
}
