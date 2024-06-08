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
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->string('order_number')->nullable();
			$table->integer('customer_id')->nullable();
			$table->text('shipping_id')->nullable();
			$table->text('shipping_address')->nullable();
			$table->decimal('shipping_charge')->nullable();
			$table->decimal('total_amount')->nullable();
			$table->string('coupon_code')->nullable();
			$table->decimal('coupon_amount')->nullable();
			$table->integer('order_type')->nullable();
			$table->integer('payment_status');
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
		Schema::dropIfExists('orders');
	}
};