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
		Schema::create('coupons', function (Blueprint $table) {
			$table->id();
			$table->string('name')->nullable();
			$table->string('code')->nullable();
			$table->tinyinteger('discount_type')->nullable();
			$table->double('coupon_amount')->nullable();
			$table->double('mini_spend');
			$table->double('max_spend');
			$table->integer('customers_limit_per_coupon');
			$table->integer('customers_limit_per_customer');
			$table->string('start_date')->nullable();
			$table->string('end_date')->nullable();
			$table->text('description');
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
		Schema::dropIfExists('coupons');
	}
};