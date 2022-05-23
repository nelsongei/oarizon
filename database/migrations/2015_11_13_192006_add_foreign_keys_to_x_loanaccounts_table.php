<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXLoanaccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('x_loanaccounts', function(Blueprint $table)
		{
			$table->foreign('loanproduct_id', 'loanaccounts_loanproduct_id_foreign')->references('id')->on('loanproducts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('member_id', 'loanaccounts_member_id_foreign')->references('id')->on('x_members')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loanaccounts', function(Blueprint $table)
		{
			$table->dropForeign('loanaccounts_loanproduct_id_foreign');
			$table->dropForeign('loanaccounts_member_id_foreign');
		});
	}

}
