<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFieldGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('field_groups', function(Blueprint $table)
		{
			$table->foreign('created_by')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('updated_by')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('field_groups', function(Blueprint $table)
		{
			$table->dropForeign('field_groups_created_by_foreign');
			$table->dropForeign('field_groups_updated_by_foreign');
		});
	}

}
