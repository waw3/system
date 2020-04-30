<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('re_projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 300);
			$table->string('description', 400)->nullable();
			$table->text('content', 65535)->nullable();
			$table->text('images', 65535)->nullable();
			$table->string('location', 191)->nullable();
			$table->integer('investor_id')->unsigned();
			$table->integer('number_block')->nullable();
			$table->smallInteger('number_floor')->nullable();
			$table->smallInteger('number_flat')->nullable();
			$table->boolean('is_featured')->default(0);
			$table->date('date_finish')->nullable();
			$table->date('date_sell')->nullable();
			$table->decimal('price_from', 15, 0)->nullable();
			$table->decimal('price_to', 15, 0)->nullable();
			$table->integer('currency_id')->unsigned()->nullable();
			$table->string('status', 60)->default('selling');
			$table->timestamps();
			$table->integer('city_id')->unsigned()->nullable();
			$table->integer('author_id')->nullable();
			$table->string('author_type')->default('Modules\ACL\Models\User');
			$table->integer('category_id')->unsigned()->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('re_projects');
	}

}
