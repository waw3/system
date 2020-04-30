<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_carts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('carts_id')->unsigned()->nullable();
			$table->string('carts_size')->nullable();
			$table->string('carts_amound')->nullable();
			$table->integer('product_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_carts');
	}

}
