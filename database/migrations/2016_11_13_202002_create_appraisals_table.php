<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_appraisals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('x_employee')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('appraisalquestion_id')->unsigned();
			$table->foreign('appraisalquestion_id')->references('id')->on('x_appraisalquestions')->onDelete('restrict')->onUpdate('cascade');
			$table->string('performance');
			$table->integer('rate')->default('0');
			$table->integer('examiner')->unsigned();
			$table->foreign('examiner')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->date('appraisaldate');
			$table->text('comment');
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
		Schema::drop('appraisals');
	}

}
