<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTransactEarningsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_transact_earnings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->default('0')->index('transact_earnings_employee_id_foreign');
			$table->string('earning_name');
            $table->integer('organization_id')->unsigned()->default('0')->index('transact_earnings_oranization_id_foreign');
			$table->string('earning_amount')->default('0.00');
			$table->string('financial_month_year');
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
		Schema::drop('transact_earnings');
	}


}
