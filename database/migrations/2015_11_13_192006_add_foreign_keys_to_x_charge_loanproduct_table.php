<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXChargeLoanproductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('charge_loanproduct', function(Blueprint $table)
		{
			$table->foreign('charge_id', 'loancharges_charge_id_foreign')->references('id')->on('charges')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('loanproduct_id', 'loancharges_loanproduct_id_foreign')->references('id')->on('loanproducts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('charge_loanproduct', function(Blueprint $table)
		{
			$table->dropForeign('loancharges_charge_id_foreign');
			$table->dropForeign('loancharges_loanproduct_id_foreign');
		});
	}

}
