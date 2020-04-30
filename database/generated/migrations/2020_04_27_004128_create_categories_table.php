<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->integer('parent_id')->unsigned()->default(0)->index();
			$table->text('description', 65535)->nullable();
			$table->string('status', 60)->default('published');
			$table->integer('author_id')->unsigned()->index('categories_user_id_index');
			$table->string('author_type')->default('Modules\ACL\Models\User');
			$table->string('icon', 60)->nullable();
			$table->boolean('is_featured')->default(0);
			$table->boolean('order')->default(0);
			$table->boolean('is_default')->default(0);
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
		Schema::drop('categories');
	}

}
