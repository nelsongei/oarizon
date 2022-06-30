<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentmethodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paymentmethods', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('account_id')->unsigned();
			$table->foreign('account_id')->references('id')->on('x_accounts');
            $table->integer('organization_id')->nullable();
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
		Schema::drop('paymentmethods');
	}

}
