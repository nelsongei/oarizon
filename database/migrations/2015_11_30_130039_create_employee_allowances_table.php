<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAllowancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_employee_allowances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->default('0')->index('employee_allowances_employee_id_foreign');
			$table->integer('allowance_id')->unsigned()->default('0')->index('employee_allowances_allowance_id_foreign');
			$table->string('allowance_amount')->default('0.00');
			$table->string('formular');
			$table->integer('instalments');
			$table->date('allowance_date');
			$table->date('first_day_month');
			$table->date('last_day_month');
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
		Schema::drop('x_employee_allowances');
	}

}
