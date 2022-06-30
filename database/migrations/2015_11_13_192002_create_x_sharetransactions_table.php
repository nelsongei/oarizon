<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXSharetransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sharetransactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('date');
			$table->integer('shareaccount_id')->unsigned()->index('sharetransactions_shareaccount_id_foreign');
			$table->string('trans_no')->nullable();
			$table->string('type');
			$table->string('description');
			$table->float('amount', 10, 0);
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
		Schema::drop('sharetransactions');
	}

}
