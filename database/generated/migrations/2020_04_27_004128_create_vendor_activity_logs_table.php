<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendorActivityLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vendor_activity_logs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('action', 120);
			$table->text('user_agent', 65535)->nullable();
			$table->string('reference_url')->nullable();
			$table->string('reference_name')->nullable();
			$table->string('ip_address', 25)->nullable();
			$table->integer('vendor_id')->unsigned()->index();
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
		Schema::drop('vendor_activity_logs');
	}

}
