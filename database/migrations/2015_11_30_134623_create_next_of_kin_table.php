<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateNextOfKinTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_nextofkins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->default('0')->index('next_of_kin_employee_id_foreign');
			$table->string('kin_name')->nullable();
			$table->string('relation')->nullable();
			$table->string('contact')->unique()->nullable();
			$table->string('id_number')->unique()->nullable();
			$table->double('amount',15,2)->default('0.00');
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
		Schema::drop('next_of_kin');
	}

}
