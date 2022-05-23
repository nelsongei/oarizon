<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXChargeSavingproductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('charge_savingproduct', function(Blueprint $table)
		{
			$table->foreign('charge_id', 'savingcharges_charge_id_foreign')->references('id')->on('charges')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('savingproduct_id', 'savingcharges_savingproduct_id_foreign')->references('id')->on('savingproducts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('charge_savingproduct', function(Blueprint $table)
		{
			$table->dropForeign('savingcharges_charge_id_foreign');
			$table->dropForeign('savingcharges_savingproduct_id_foreign');
		});
	}

}
