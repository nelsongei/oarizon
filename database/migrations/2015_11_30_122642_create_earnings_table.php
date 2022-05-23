<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_earnings', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('employee_id')->unsigned()->default('0')->index('earnings_employee_id_foreign');
            $table->integer('earning_id');
            $table->string('narrative');
            $table->string('formular');
            $table->integer('instalments');
            $table->string('earnings_amount')->default('0.00');
            $table->date('earning_date');
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
		Schema::drop('x_earnings');
	}

}
