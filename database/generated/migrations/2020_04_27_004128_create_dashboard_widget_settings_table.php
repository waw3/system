<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDashboardWidgetSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dashboard_widget_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('settings', 65535)->nullable();
			$table->integer('user_id')->unsigned()->index();
			$table->integer('widget_id')->unsigned()->index();
			$table->boolean('order')->default(0);
			$table->boolean('status')->default(1);
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
		Schema::drop('dashboard_widget_settings');
	}

}
