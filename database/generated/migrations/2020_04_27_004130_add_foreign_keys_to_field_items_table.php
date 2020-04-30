<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFieldItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('field_items', function(Blueprint $table)
		{
			$table->foreign('field_group_id')->references('id')->on('field_groups')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('parent_id')->references('id')->on('field_items')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('field_items', function(Blueprint $table)
		{
			$table->dropForeign('field_items_field_group_id_foreign');
			$table->dropForeign('field_items_parent_id_foreign');
		});
	}

}
