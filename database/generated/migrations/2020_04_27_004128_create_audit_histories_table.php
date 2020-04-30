<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuditHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('audit_histories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('audit_history_user_id_index');
			$table->string('module', 60)->index('audit_history_module_index');
			$table->text('request', 65535)->nullable();
			$table->string('action', 120);
			$table->text('user_agent', 65535)->nullable();
			$table->string('ip_address', 25)->nullable();
			$table->integer('reference_user')->unsigned();
			$table->integer('reference_id')->unsigned();
			$table->string('reference_name');
			$table->string('type', 20);
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
		Schema::drop('audit_histories');
	}

}
