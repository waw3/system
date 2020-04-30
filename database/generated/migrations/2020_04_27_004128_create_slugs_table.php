<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlugsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slugs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key');
			$table->integer('reference_id')->unsigned();
			$table->string('reference_type');
			$table->timestamps();
			$table->string('prefix', 120)->nullable()->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('slugs');
	}

}
