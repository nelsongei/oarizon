<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateBankReconciliationTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_accounts', function(Blueprint $table){
			$table->increments('id');
			$table->string('bank_name', 100);
			$table->string('account_name', 100);
			$table->string('account_number', 20);
            $table->integer('organization_id')->nulable();
			$table->timestamps();
		});


		Schema::create('bank_statements', function(Blueprint $table){
			$table->increments('id');
			$table->integer('bank_account_id')->unsigned();
			$table->float('bal_bd');
			$table->float('adj_bal_bd');
			$table->string('stmt_month');
			$table->boolean('is_reconciled');
            $table->integer('organization_id')->nulable();
			$table->timestamps();

			$table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onUpdate('cascade');
		});


		Schema::create('stmt_transactions', function(Blueprint $table){
			$table->increments('id');
			$table->integer('bank_statement_id')->unsigned();
			$table->date('transaction_date');
			$table->string('description');
			$table->string('ref_no')->nullable();
			$table->float('transaction_amnt');
			$table->string('check_no')->nullable();
			$table->string('status', 50);
            $table->integer('organization_id')->nulable();
			$table->timestamps();

			$table->foreign('bank_statement_id')->references('id')->on('bank_statements')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bank_accounts');
		Schema::drop('bank_statements');
		Schema::drop('stmt_transactions');
	}

}
