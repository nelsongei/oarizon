<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_overtimes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('employee_id')->unsigned()->default('0')->index('overtimes_employee_id_foreign');
            $table->string('type');
            $table->float('period',15,2);
            $table->string('formular');
            $table->integer('instalments')->default('0')->nullable();
			$table->string('amount')->default('0.00');
			$table->date('overtime_date');
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
		Schema::drop('overtimes');
	}

}
