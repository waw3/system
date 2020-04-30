<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned()->index('post_category_category_id_index');
			$table->integer('post_id')->unsigned()->index('post_category_post_id_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_categories');
	}

}
