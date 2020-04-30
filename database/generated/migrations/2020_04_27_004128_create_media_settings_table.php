<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key', 120);
			$table->text('value', 65535)->nullable();
			$table->integer('media_id')->nullable();
			$table->integer('user_id')->nullable();
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
		Schema::drop('media_settings');
	}

}
