<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->integer('author_id')->unsigned()->index('tags_user_id_index');
			$table->string('author_type')->default('Modules\ACL\Models\User');
			$table->string('description', 400)->nullable()->default('');
			$table->string('status', 60)->default('published');
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
		Schema::drop('tags');
	}

}
