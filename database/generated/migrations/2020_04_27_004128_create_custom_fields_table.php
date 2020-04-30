<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_fields', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('use_for');
			$table->integer('use_for_id')->unsigned();
			$table->integer('field_item_id')->unsigned()->index('custom_fields_field_item_id_foreign');
			$table->string('type');
			$table->string('slug');
			$table->text('value', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_fields');
	}

}
