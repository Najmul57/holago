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
		Schema::create('customers', function (Blueprint $table) {
			$table->id();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('username');
			$table->string('email')->nullable();
			$table->string('password')->nullable();
			$table->string('phone_number')->nullable();
			$table->text('address');
			$table->string('city');
			$table->string('zip_code');
			$table->string('state');
			$table->string('country')->nullable();
			$table->integer('email_verify');
			$table->integer('sms_verify');
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
		Schema::dropIfExists('customers');
	}
};