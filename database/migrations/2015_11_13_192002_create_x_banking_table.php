<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXBankingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Banking', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('account_from');
			$table->string('account_to');
			$table->double('amount');
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
		Schema::drop('Banking');
	}

}
