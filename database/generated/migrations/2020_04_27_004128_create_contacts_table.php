<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 60);
			$table->string('email', 60);
			$table->string('phone', 60)->nullable();
			$table->string('address', 120)->nullable();
			$table->text('content', 65535);
			$table->string('subject', 120)->nullable();
			$table->timestamps();
			$table->string('status', 60)->default('unread');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}

}
