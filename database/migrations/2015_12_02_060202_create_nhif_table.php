<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNhifTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_hospital_insurance', function(Blueprint $table)
		{
			$table->increments('id');
			$table->double('income_from',15,2)->default('0.00');
			$table->double('income_to',15,2)->default('0.00');
			$table->double('hi_amount',15,2)->default('0.00');
			$table->integer('organization_id');
			$table->timestamps();
		});

        DB::table('x_hospital_insurance')->insert(array(
            array('income_from' => '0.00', 'income_to' => '0.00', 'hi_amount' => '0.00', 'organization_id' => '1'),
            array('income_from' => '1.00', 'income_to' => '5999.00', 'hi_amount' => '150.00', 'organization_id' => '1'),
            array('income_from' => '6000.00', 'income_to' => '7999.00', 'hi_amount' => '300.00', 'organization_id' => '1'),
            array('income_from' => '8000.00', 'income_to' => '11999.00', 'hi_amount' => '400.00', 'organization_id' => '1'),
            array('income_from' => '12000.00', 'income_to' => '14999.00', 'hi_amount' => '500.00', 'organization_id' => '1'),
            array('income_from' => '15000.00', 'income_to' => '19999.00', 'hi_amount' => '600.00', 'organization_id' => '1'),
            array('income_from' => '20000.00', 'income_to' => '24999.00', 'hi_amount' => '750.00', 'organization_id' => '1'),
            array('income_from' => '25000.00', 'income_to' => '29999.00', 'hi_amount' => '850.00', 'organization_id' => '1'),
            array('income_from' => '30000.00', 'income_to' => '34999.00', 'hi_amount' => '900.00', 'organization_id' => '1'),
            array('income_from' => '35000.00', 'income_to' => '39999.00', 'hi_amount' => '950.00', 'organization_id' => '1'),
            array('income_from' => '40000.00', 'income_to' => '44999.00', 'hi_amount' => '1000.00', 'organization_id' => '1'),
            array('income_from' => '45000.00', 'income_to' => '49999.00', 'hi_amount' => '1100.00', 'organization_id' => '1'),
            array('income_from' => '50000.00', 'income_to' => '59999.00', 'hi_amount' => '1200.00', 'organization_id' => '1'),
            array('income_from' => '60000.00', 'income_to' => '69999.00', 'hi_amount' => '1300.00', 'organization_id' => '1'),
            array('income_from' => '70000.00', 'income_to' => '79999.00', 'hi_amount' => '1400.00', 'organization_id' => '1'),
            array('income_from' => '80000.00', 'income_to' => '89999.00', 'hi_amount' => '1500.00', 'organization_id' => '1'),
            array('income_from' => '90000.00', 'income_to' => '99999.00', 'hi_amount' => '1600.00', 'organization_id' => '1'),
            array('income_from' => '100000.00', 'income_to' => '99000000.00', 'hi_amount' => '1700.00', 'organization_id' => '1'),
        ));
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('x_hospital_insurance');
	}

}
