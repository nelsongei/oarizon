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
