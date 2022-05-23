<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppraisalCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_appraisalcategories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			//$table->integer('organization_id')->unsigned();
			//$table->foreign('organization_id')->references('id')->on('x_organizations')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('rate')->nullable()->default('10');
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
		Schema::drop('appraisalcategories');
	}

}
