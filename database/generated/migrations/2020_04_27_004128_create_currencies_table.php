<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 60);
			$table->string('symbol', 10);
			$table->boolean('is_prefix_symbol')->default(0);
			$table->boolean('decimals')->default(0);
			$table->integer('order')->unsigned()->default(0);
			$table->boolean('is_default')->default(0);
			$table->float('exchange_rate', 10, 0)->default(1);
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
		Schema::drop('currencies');
	}

}
