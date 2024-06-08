<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string('name')->nullable();
			$table->string('sku')->nullable();
			$table->string('product_model');
			$table->string('brand_id')->nullable();
			$table->string('supplier_id')->nullable();
			$table->decimal('buying_price')->nullable();
			$table->decimal('regular_price')->nullable();
			$table->decimal('wholesale_price');
			$table->string('wholesale_min_qty');
			$table->longtext('description');
			$table->text('summary');
			$table->longtext('extra_description');
			$table->longtext('specification');
			$table->integer('track_inventory');
			$table->integer('has_variants');
			$table->text('video_link');
			$table->integer('is_featured');
			$table->integer('is_special');
			$table->string('meta_title');
			$table->text('meta_description');
			$table->text('meta_keyword');
			$table->string('image');
			$table->integer('status')->default(1);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('products');
	}
};