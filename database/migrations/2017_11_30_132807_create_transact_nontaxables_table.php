<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTransactNontaxablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_transact_nontaxables', function(Blueprint $table)
		{
			$table->increments('id');
//			$table->integer('employee_id')->unsigned();
//			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('employee_id')->unsigned()->default('0')->index('transact_earnings_employee_id_foreign');
			$table->integer('organization_id')->unsigned()->default('0')->index('transact_earnings_organization_id_foreign');
			$table->integer('employee_nontaxable_id')->unsigned();
			$table->integer('nontaxable_id')->unsigned();
			$table->string('nontaxable_name');
			$table->string('nontaxable_amount')->default('0.00');
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
		Schema::drop('transact_deductions');
	}

}
