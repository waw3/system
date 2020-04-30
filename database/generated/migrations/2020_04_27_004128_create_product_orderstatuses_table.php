<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductOrderstatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_orderstatuses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('orderstatuses_id')->unsigned()->nullable();
			$table->integer('cart_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_orderstatuses');
	}

}
