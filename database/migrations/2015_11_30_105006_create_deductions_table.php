<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_deductions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('deduction_name');
			$table->integer('organization_id')->unsigned()->default('0')->index('deductions_organization_id_foreign');
			$table->timestamps();
		});

		DB::table('x_deductions')->insert(array(
            array('deduction_name' => 'Salary Advance','organization_id' => '1'),
            array('deduction_name' => 'Loans','organization_id' => '1'),
            array('deduction_name' => 'Savings','organization_id' => '1'),
            array('deduction_name' => 'Breakages and spoilages','organization_id' => '1'),
        ));
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('x_deductions');
	}


}
