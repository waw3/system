<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('consults', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->string('email', 60);
			$table->string('phone', 60);
			$table->integer('project_id')->unsigned()->nullable();
			$table->integer('property_id')->unsigned()->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('status', 60)->default('unread');
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
		Schema::drop('consults');
	}

}
