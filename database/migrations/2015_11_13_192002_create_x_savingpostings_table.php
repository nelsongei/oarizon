<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXSavingpostingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('savingpostings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('savingproduct_id')->unsigned()->index('savingpostings_savingproduct_id_foreign');
			$table->string('transaction');
			$table->integer('debit_account');
			$table->integer('credit_account');
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
		Schema::drop('savingpostings');
	}

}
