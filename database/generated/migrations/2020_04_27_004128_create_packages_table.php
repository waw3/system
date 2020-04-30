<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('packages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->float('price', 15)->unsigned();
			$table->integer('currency_id')->unsigned();
			$table->integer('number_of_listings')->unsigned();
			$table->boolean('order')->default(0);
			$table->boolean('is_default')->default(0);
			$table->string('status', 60)->default('published');
			$table->timestamps();
			$table->integer('percent_save')->unsigned()->default(0);
			$table->integer('account_limit')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('packages');
	}

}
