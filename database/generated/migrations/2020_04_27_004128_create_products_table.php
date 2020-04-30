<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('description', 400)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('status', 60)->default('published');
			$table->integer('author_id');
			$table->string('author_type')->default('Modules\ACL\Models\User');
			$table->boolean('is_featured')->default(0);
			$table->text('image', 65535)->nullable();
			$table->text('imagedl', 65535)->nullable();
			$table->text('images', 65535)->nullable();
			$table->string('pricecost')->nullable();
			$table->string('pricesell');
			$table->string('pricetime')->nullable();
			$table->string('amound', 40)->nullable();
			$table->string('color', 400)->nullable();
			$table->string('colors', 400)->nullable();
			$table->string('sizes', 400)->nullable();
			$table->string('pricesale')->nullable();
			$table->string('price_sale_start', 400)->nullable();
			$table->string('price_sale_end', 400)->nullable();
			$table->integer('views')->unsigned()->default(0);
			$table->string('format_type', 30)->nullable();
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
		Schema::drop('products');
	}

}
