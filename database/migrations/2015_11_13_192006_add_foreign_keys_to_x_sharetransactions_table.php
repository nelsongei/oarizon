<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXSharetransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sharetransactions', function(Blueprint $table)
		{
			$table->foreign('shareaccount_id', 'sharetransactions_shareaccount_id_foreign')->references('id')->on('shareaccounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sharetransactions', function(Blueprint $table)
		{
			$table->dropForeign('sharetransactions_shareaccount_id_foreign');
		});
	}

}
