<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->text('content')->nullable();
			$table->string('status', 60)->default('published');
			$table->integer('user_id');
			$table->string('image')->nullable();
			$table->string('template', 60)->nullable();
			$table->boolean('is_featured')->default(0);
			$table->string('description', 400)->nullable();
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
		Schema::drop('pages');
	}

}
