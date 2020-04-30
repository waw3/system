<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug', 120)->unique();
			$table->string('name', 120);
			$table->text('permissions', 65535)->nullable();
			$table->string('description')->nullable();
			$table->boolean('is_default')->default(0);
			$table->integer('created_by')->unsigned()->index();
			$table->integer('updated_by')->unsigned()->index();
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
		Schema::drop('roles');
	}

}
