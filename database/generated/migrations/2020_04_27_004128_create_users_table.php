<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 191)->unique();
			$table->string('password', 191)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->text('permissions', 65535)->nullable();
			$table->dateTime('last_login')->nullable();
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('username', 60)->nullable()->unique();
			$table->boolean('super_user')->default(0);
			$table->boolean('manage_supers')->default(0);
			$table->integer('avatar_id')->unsigned()->nullable();
			$table->string('stripe_id', 191)->nullable()->index();
			$table->string('card_brand', 191)->nullable();
			$table->string('card_last_four', 4)->nullable();
			$table->dateTime('trial_ends_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
