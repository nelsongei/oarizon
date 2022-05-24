<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_documents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->default('0')->index('documents_employee_id_foreign');
			$table->string('document_name');
			$table->string('document_path');
            $table->string('type');
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
		Schema::drop('documents');
	}

}
