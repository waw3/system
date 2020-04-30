<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tag_id')->unsigned()->index('post_tag_tag_id_index');
			$table->integer('post_id')->unsigned()->index('post_tag_post_id_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_tags');
	}

}
