<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXSavingproductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('savingproducts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('shortname');
			$table->float('opening_balance', 10, 0);
			$table->string('type');
            $table->string('currency');
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
		Schema::drop('savingproducts');
	}

}
