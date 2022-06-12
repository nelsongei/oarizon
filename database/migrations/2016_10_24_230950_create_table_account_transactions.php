<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableAccountTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_transactions', function(Blueprint $table){
			$table->increments('id');
			$table->date('transaction_date');
			$table->string('description');
			$table->integer('account_debited')->unsigned();
			$table->integer('account_credited')->unsigned();
			$table->integer('bank_transaction_id')->unsigned();
			$table->integer('bank_statement_id')->unsigned();
			$table->float('transaction_amount');
			$table->string('status', 50);
            $table->integer('organization_id')->nulable();
			$table->timestamps();

			$table->foreign('account_debited')->references('id')->on('x_accounts')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('account_credited')->references('id')->on('x_accounts')->onDelete('cascade')->onUpdate('cascade');
			//$table->foreign('bank_transaction')->references('id')->on('stmt_transactions')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_transactions');
	}

}
