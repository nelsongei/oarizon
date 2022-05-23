<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_employee_type', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('employee_type_name');
			$table->integer('organization_id')->unsigned()->default('0')->index('employee_type_organization_id_foreign');
			$table->timestamps();
		});

		DB::table('x_employee_type')->insert(array(
            array('employee_type_name' => 'Full Time','organization_id' => '1'),
            array('employee_type_name' => 'Contract','organization_id' => '1'),
            array('employee_type_name' => 'Internship','organization_id' => '1'),
        ));
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('x_employee_type');
	}

}
