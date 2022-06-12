<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeBenefitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_employeebenefits', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('jobgroup_id')->unsigned()->default('0')->index('employeebenefits_jobgroup_id_foreign');
            $table->integer('benefit_id')->unsigned()->default('0')->index('employeebenefits_benefit_id_foreign');
			$table->string('amount')->default('0.00');
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
		Schema::drop('employeebenefits');
	}

}
