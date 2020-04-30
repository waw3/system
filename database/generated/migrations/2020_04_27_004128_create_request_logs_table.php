<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('request_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('status_code')->nullable();
			$table->string('url', 191)->nullable();
			$table->integer('count')->default(0);
			$table->string('user_id')->nullable();
			$table->text('referrer', 65535)->nullable();
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
		Schema::drop('request_logs');
	}

}
