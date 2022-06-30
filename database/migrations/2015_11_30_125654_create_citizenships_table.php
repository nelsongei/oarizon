<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCitizenshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('citizenships', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('organization_id')->unsigned();
			$table->foreign('organization_id')->references('id')->on('x_organizations')->onDelete('cascade')->onUpdate('cascade');
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
		Schema::drop('citizenships');
	}

}
