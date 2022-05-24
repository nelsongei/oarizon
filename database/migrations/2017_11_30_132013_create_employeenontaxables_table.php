<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeNonTaxablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_employeenontaxables', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('employee_id')->unsigned()->default('0')->index('employeenontaxables_employee_id_foreign');
            $table->integer('nontaxable_id')->unsigned()->default('0')->index('employeenontaxables_nontaxable_id_foreign');
            $table->string('formular');
            $table->integer('instalments')->default('0')->nullable();
			$table->string('nontaxable_amount')->default('0.00');
			$table->date('nontaxable_date');
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
		Schema::drop('employee_deductions');
	}

}
