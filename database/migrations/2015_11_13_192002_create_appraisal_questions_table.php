<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_appraisalquestions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('question');
			$table->integer('appraisalcategory_id')->unsigned();
			$table->foreign('appraisalcategory_id')->references('id')->on('x_appraisalcategories')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('appraisalquestions');
	}

}
