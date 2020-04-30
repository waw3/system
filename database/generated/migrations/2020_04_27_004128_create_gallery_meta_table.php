<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryMetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gallery_meta', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reference_id')->unsigned()->index('gallery_meta_content_id_index');
			$table->text('images', 65535)->nullable();
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
		Schema::drop('gallery_meta');
	}

}
