<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXLoantransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('loantransactions', function(Blueprint $table)
		{
			$table->foreign('loanaccount_id', 'loantransactions_loanaccount_id_foreign')->references('id')->on('x_loanaccounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loantransactions', function(Blueprint $table)
		{
			$table->dropForeign('loantransactions_loanaccount_id_foreign');
		});
	}

}
