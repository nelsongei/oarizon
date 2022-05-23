<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXSavingpostingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('savingpostings', function(Blueprint $table)
		{
			$table->foreign('savingproduct_id', 'savingpostings_savingproduct_id_foreign')->references('id')->on('savingproducts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('savingpostings', function(Blueprint $table)
		{
			$table->dropForeign('savingpostings_savingproduct_id_foreign');
		});
	}

}
