<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXLoanpostingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_loanpostings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('loanproduct_id')->unsigned()->index('loanpostings_loanproduct_id_foreign');
			$table->string('transaction');
			$table->string('debit_account');
			$table->string('credit_account');
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
		Schema::drop('loanpostings');
	}

}
