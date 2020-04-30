<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('user_id')->unsigned();
			$table->string('name', 191);
			$table->string('stripe_id', 191);
			$table->string('stripe_status', 191);
			$table->string('stripe_plan', 191);
			$table->integer('quantity');
			$table->dateTime('trial_ends_at')->nullable();
			$table->dateTime('ends_at')->nullable();
			$table->timestamps();
			$table->index(['user_id','stripe_status']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subscriptions');
	}

}
