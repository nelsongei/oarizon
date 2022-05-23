<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXChargeSavingproductTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('charge_savingproduct', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('charge_id')->unsigned()->index('savingcharges_charge_id_foreign');
			$table->integer('savingproduct_id')->unsigned()->index('savingcharges_savingproduct_id_foreign');
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
		Schema::drop('charge_savingproduct');
	}

}
