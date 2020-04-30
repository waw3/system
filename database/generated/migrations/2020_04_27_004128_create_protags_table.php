<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProtagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('protags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 120);
			$table->integer('author_id');
			$table->string('author_type')->default('Modules\ACL\Models\User');
			$table->string('description', 400)->nullable()->default('');
			$table->integer('parent_id')->unsigned()->default(0);
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
		Schema::drop('protags');
	}

}
