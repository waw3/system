<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('field_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('field_group_id')->unsigned()->index('field_items_field_group_id_foreign');
			$table->integer('parent_id')->unsigned()->nullable()->index('field_items_parent_id_foreign');
			$table->integer('order')->nullable()->default(0);
			$table->string('title');
			$table->string('slug');
			$table->string('type', 100);
			$table->text('instructions', 65535)->nullable();
			$table->text('options', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('field_items');
	}

}
