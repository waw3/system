<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->integer('state_id')->unsigned();
			$table->integer('country_id')->unsigned()->nullable();
			$table->boolean('order')->default(0);
			$table->boolean('is_default')->default(0);
			$table->string('status', 60)->default('published');
			$table->timestamps();
			$table->string('slug', 120)->nullable()->unique();
			$table->boolean('is_featured')->default(0);
			$table->string('image')->nullable();
			$table->string('record_id', 40)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cities');
	}

}
