<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('custom_fields', function(Blueprint $table)
		{
			$table->foreign('field_item_id')->references('id')->on('field_items')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('custom_fields', function(Blueprint $table)
		{
			$table->dropForeign('custom_fields_field_item_id_foreign');
		});
	}

}
