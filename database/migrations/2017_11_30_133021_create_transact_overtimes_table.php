<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTransactOvertimesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_transact_overtimes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('organization_id')->unsigned()->default('0')->index('transact_overtimes_organization_id_foreign');
            $table->integer('employee_id')->unsigned()->default('0')->index('transact_overtimes_employee_id_foreign');
			$table->string('overtime_type');
			$table->float('overtime_period',15,2);
			$table->string('overtime_amount')->default('0.00');
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
		Schema::drop('transact_overtimes');
	}


}
