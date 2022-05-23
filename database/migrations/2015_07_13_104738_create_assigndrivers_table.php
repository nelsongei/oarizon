<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssigndriversTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assigndrivers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('date')->nullable();
			$table->string('time_out')->nullable();
			$table->string('driver')->nullable();
			$table->integer('contact')->unsigned();
			$table->string('reg_no')->nullable();
			$table->string('model')->nullable();
			$table->string('oil_level')->nullable();
			$table->string('water_level')->nullable();
			$table->string('fuel_level')->nullable();
			$table->string('tire_pressure')->nullable();
			$table->string('general_comments')->nullable();
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
		Schema::drop('assigndrivers');
	}

}
