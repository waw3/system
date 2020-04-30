<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->float('amount', 10, 0)->unsigned();
			$table->string('currency', 120);
			$table->integer('user_id')->unsigned()->default(0);
			$table->string('charge_id', 60);
			$table->string('payment_channel', 60)->nullable();
			$table->timestamps();
			$table->string('description')->nullable();
			$table->string('name', 120);
			$table->string('status', 60)->default('published');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payments');
	}

}
