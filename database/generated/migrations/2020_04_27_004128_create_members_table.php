<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 191);
			$table->string('email', 191)->unique();
			$table->string('password', 191);
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->date('dob')->nullable();
			$table->string('phone', 25)->nullable();
			$table->dateTime('confirmed_at')->nullable();
			$table->string('last_name', 120)->nullable();
			$table->text('description', 65535)->nullable();
			$table->string('gender', 20)->nullable();
			$table->integer('avatar_id')->unsigned()->nullable();
			$table->string('email_verify_token', 120)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('members');
	}

}
