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
		Schema::create('product_stocks', function (Blueprint $table) {
			$table->id();
			$table->string('product_id')->nullable();
			$table->longtext('attributes')->nullable();
			$table->string('sku')->nullable();
			$table->integer('quantity')->nullable();
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
		Schema::dropIfExists('product_stocks');
	}
};