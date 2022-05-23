<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXChargesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('charges', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('category');
			$table->string('calculation_method');
			$table->string('payment_method');
			$table->string('percentage_of')->nullable();
			$table->float('amount', 10, 0);
			$table->boolean('fee');
			$table->timestamps();
			$table->boolean('disabled')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('charges');
	}

}
