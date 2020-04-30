<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuNodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_nodes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('menu_id')->unsigned()->index();
			$table->integer('parent_id')->unsigned()->default(0)->index();
			$table->integer('reference_id')->unsigned()->nullable()->default(0)->index('menu_nodes_related_id_index');
			$table->string('reference_type')->nullable();
			$table->string('url', 120)->nullable();
			$table->string('icon_font', 50)->nullable();
			$table->boolean('position')->default(0);
			$table->string('title', 120)->nullable();
			$table->string('css_class', 120)->nullable();
			$table->string('target', 20)->default('_self');
			$table->boolean('has_child')->default(0);
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
		Schema::drop('menu_nodes');
	}

}
