<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeReliefTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_employee_relief', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('relief_id')->unsigned()->default('0')->index('employee_relief_relief_id_foreign');
			$table->integer('employee_id')->unsigned()->default('0')->index('employee_relief_employee_id_foreign');
			$table->string('relief_amount')->default('0.00');
            $table->double('percentage',2);
            $table->double('premium',2);
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
		Schema::drop('x_employee_relief');
	}


}
