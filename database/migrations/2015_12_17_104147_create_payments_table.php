<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('account_id')->unsigned();
			$table->integer('erporder_id')->unsigned();
			$table->foreign('erporder_id')->references('id')->on('erporders');
			$table->date('payment_date')->nullable();
			$table->double('amount_paid')->default(0);
			$table->string('received_by')->nullable();
			$table->string('confirmed_id')->nullable();
			$table->string('prepared_by')->nullable();
			$table->integer('paymentmethod_id')->unsigned();
			$table->foreign('paymentmethod_id')->references('id')->on('paymentmethods');
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
		Schema::drop('payments');
	}

}
