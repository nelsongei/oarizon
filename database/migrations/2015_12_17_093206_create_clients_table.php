<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->date('date');
			$table->date('code');
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->string('contact_person')->nullable();
			$table->string('contact_person_phone')->nullable();
			$table->string('contact_person_email')->nullable();
			$table->string('type');
			$table->string('prepared_by');
			$table->string('percentage_discount');
			$table->string('credit_limit');
			$table->string('credit_period');
			$table->double('balance')->default(0);
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
		Schema::drop('clients');
	}

}
