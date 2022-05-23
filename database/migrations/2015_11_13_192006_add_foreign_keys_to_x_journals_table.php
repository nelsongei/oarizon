<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToXJournalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('x_journals', function(Blueprint $table)
		{
			$table->foreign('account_id', 'journals_account_id_foreign')->references('id')->on('x_accounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('journals', function(Blueprint $table)
		{
			$table->dropForeign('journals_account_id_foreign');
		});
	}

}
