<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDeductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_employee_deductions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->default('0')->index('employee_deductions_employee_id_foreign');
			$table->integer('deduction_id')->unsigned()->default('0')->index('employee_deductions_deduction_id_foreign');
            $table->string('formular');
            $table->integer('instalments')->default('0')->nullable();
			$table->string('deduction_amount')->default('0.00');
			$table->date('deduction_date');
			$table->date('first_day_month');
			$table->date('last_day_month');
            $table->integer('organization_id')->nulable();
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
		Schema::drop('x_employee_deductions');
	}

}
