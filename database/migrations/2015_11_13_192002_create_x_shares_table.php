<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXSharesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shares', function(Blueprint $table)
		{
			$table->increments('id');
			$table->float('value', 10, 0)->default(0);
			$table->float('transfer_charge', 10, 0)->default(0);
			$table->string('charged_on')->default('donor');
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
		Schema::drop('shares');
	}

}
