<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguageMetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('language_meta', function(Blueprint $table)
		{
			$table->increments('lang_meta_id');
			$table->integer('reference_id')->unsigned()->index('language_meta_lang_meta_content_id_index');
			$table->text('lang_meta_code', 65535)->nullable();
			$table->string('reference_type', 120);
			$table->string('lang_meta_origin');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('language_meta');
	}

}
