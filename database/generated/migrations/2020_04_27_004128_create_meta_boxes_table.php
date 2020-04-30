<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetaBoxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meta_boxes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reference_id')->unsigned()->index('meta_boxes_content_id_index');
			$table->string('meta_key');
			$table->text('meta_value', 65535)->nullable();
			$table->string('reference_type', 120);
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
		Schema::drop('meta_boxes');
	}

}
