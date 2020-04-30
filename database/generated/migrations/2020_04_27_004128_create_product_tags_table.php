<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('protag_id')->unsigned()->nullable();
			$table->integer('pro_tag_id')->unsigned();
			$table->integer('product_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_tags');
	}

}
