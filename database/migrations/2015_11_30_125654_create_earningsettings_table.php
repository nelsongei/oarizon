<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_earningsettings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('earning_name');
			$table->integer('organization_id')->unsigned();
			$table->foreign('organization_id')->references('id')->on('x_organizations')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('earningsettings');
	}

}
