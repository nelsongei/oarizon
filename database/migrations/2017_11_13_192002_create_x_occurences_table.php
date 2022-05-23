<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXOccurencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_occurences', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('occurence_brief');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('x_employee')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('occurencesetting_id')->unsigned();
			$table->foreign('occurencesetting_id')->references('id')->on('x_occurencesettings')->onDelete('restrict')->onUpdate('cascade');
			$table->text('narrative')->nullable();
			$table->string('doc_path')->nullable();
			$table->date('occurence_date');
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
		Schema::drop('occurences');
	}

}
