<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXSavingtransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('savingtransactions', function(Blueprint $table)
		{
			$table->foreign('savingaccount_id', 'savingtransactions_savingaccount_id_foreign')->references('id')->on('savingaccounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('savingtransactions', function(Blueprint $table)
		{
			$table->dropForeign('savingtransactions_savingaccount_id_foreign');
		});
	}

}
