<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXLoanrepaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('loanrepayments', function(Blueprint $table)
		{
			$table->foreign('loanaccount_id', 'loanrepayments_loanaccount_id_foreign')->references('id')->on('x_loanaccounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loanrepayments', function(Blueprint $table)
		{
			$table->dropForeign('loanrepayments_loanaccount_id_foreign');
		});
	}

}
