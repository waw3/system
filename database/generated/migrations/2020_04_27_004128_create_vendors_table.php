<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vendors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 120);
			$table->string('last_name', 120);
			$table->text('description', 65535)->nullable();
			$table->string('gender', 20)->nullable();
			$table->string('email', 191)->unique();
			$table->string('password', 191);
			$table->integer('avatar_id')->unsigned()->nullable();
			$table->date('dob')->nullable();
			$table->string('phone', 25)->nullable();
			$table->dateTime('confirmed_at')->nullable();
			$table->string('email_verify_token', 120)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->integer('credits')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vendors');
	}

}
