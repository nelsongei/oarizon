<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHolidaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_holidays', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->date('date')->nullable();
			$table->integer('organization_id')->unsigned();
			$table->foreign('organization_id')->references('id')->on('x_organizations');
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
		Schema::drop('x_holidays');
	}

}
