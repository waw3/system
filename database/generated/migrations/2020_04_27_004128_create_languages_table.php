<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('languages', function(Blueprint $table)
		{
			$table->increments('lang_id');
			$table->string('lang_name', 120);
			$table->string('lang_locale', 20);
			$table->string('lang_code', 20);
			$table->string('lang_flag', 20)->nullable();
			$table->boolean('lang_is_default')->default(0);
			$table->integer('lang_order')->default(0);
			$table->boolean('lang_is_rtl')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('languages');
	}

}
