<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXChargeLoanproductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('charge_loanproduct', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('charge_id')->unsigned()->index('loancharges_charge_id_foreign');
			$table->integer('loanproduct_id')->unsigned()->index('loancharges_loanproduct_id_foreign');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('charge_loanproduct');
	}

}
