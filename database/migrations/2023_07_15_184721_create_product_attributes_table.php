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
		Schema::create('product_attributes', function (Blueprint $table) {
			$table->id();
			$table->string('product_id')->nullable();
			$table->string('attribute_id')->nullable();
			$table->text('name')->nullable();
			$table->text('content')->nullable();
			$table->text('extra_price');
			$table->integer('is_default');
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
		Schema::dropIfExists('product_attributes');
	}
};