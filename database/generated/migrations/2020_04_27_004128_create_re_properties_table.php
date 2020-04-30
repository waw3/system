<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRePropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('re_properties', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 300);
			$table->string('type', 20)->default('sale');
			$table->string('description', 400)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('location', 191)->nullable();
			$table->text('images', 65535)->nullable();
			$table->integer('project_id')->unsigned()->default(0);
			$table->integer('number_bedroom')->nullable();
			$table->integer('number_bathroom')->nullable();
			$table->integer('number_floor')->nullable();
			$table->integer('square')->nullable();
			$table->decimal('price', 15, 0)->nullable();
			$table->integer('currency_id')->unsigned()->nullable();
			$table->boolean('is_featured')->default(0);
			$table->string('status', 60)->default('selling');
			$table->timestamps();
			$table->integer('city_id')->unsigned()->nullable();
			$table->string('period', 30)->default('month');
			$table->integer('author_id')->nullable();
			$table->string('author_type')->default('Modules\ACL\Models\User');
			$table->integer('category_id')->unsigned()->nullable();
			$table->string('moderation_status', 60)->default('pending');
			$table->date('expire_date')->nullable();
			$table->boolean('auto_renew')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('re_properties');
	}

}
