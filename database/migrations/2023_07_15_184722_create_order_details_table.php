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
		Schema::create('order_details', function (Blueprint $table) {
			$table->id();
			$table->integer('order_id')->nullable();
			$table->integer('product_id')->nullable();
			$table->decimal('buying_price')->nullable();
			$table->decimal('regular_price')->nullable();
			$table->decimal('wholesale_price');
			$table->string('wholesale_minimum_quantity');
			$table->decimal('total_price')->nullable();
			$table->text('details');
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
		Schema::dropIfExists('order_details');
	}
};