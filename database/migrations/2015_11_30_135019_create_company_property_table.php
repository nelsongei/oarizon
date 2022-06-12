<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPropertyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_properties', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned()->default('0')->index('company_property_employee_id_foreign');
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('serial');
			$table->string('digitalserial');
			$table->string('issued_by');
			$table->date('issue_date');
			$table->float('monetary',2);
			$table->date('scheduled_return_date');
            $table->string('state');
			$table->double('property_amount',15,2)->default('0.00');
			$table->char('returned',1);
			$table->date('return_date');
			$table->string('received_by');
            $table->integer('organization_id')->nulable();
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
		Schema::drop('company_property');
	}

}
