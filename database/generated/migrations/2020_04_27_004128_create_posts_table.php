<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('description', 400)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('status', 60)->default('published');
			$table->integer('author_id');
			$table->string('author_type')->default('Modules\ACL\Models\User');
			$table->boolean('is_featured')->default(0);
			$table->string('image')->nullable();
			$table->integer('views')->unsigned()->default(0);
			$table->string('format_type', 30)->nullable();
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
		Schema::drop('posts');
	}

}
