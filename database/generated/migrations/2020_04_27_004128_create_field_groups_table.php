<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('field_groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('rules', 65535)->nullable();
			$table->integer('order')->default(0);
			$table->integer('created_by')->unsigned()->nullable()->index('field_groups_created_by_foreign');
			$table->integer('updated_by')->unsigned()->nullable()->index('field_groups_updated_by_foreign');
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
		Schema::drop('field_groups');
	}

}
