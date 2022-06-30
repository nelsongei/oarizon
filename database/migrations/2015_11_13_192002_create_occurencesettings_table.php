<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccurenceSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_occurencesettings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('occurence_type');
			$table->integer('organization_id')->unsigned();
			//$table->foreign('organization_id')->references('id')->on('x_organizations')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('x_occurencesettings');
	}

}
