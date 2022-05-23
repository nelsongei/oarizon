<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mails', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('driver')->default('smtp');
			$table->string('host')->nullable();
			$table->string('username')->nullable();
			$table->string('password')->nullable();
			$table->string('port')->nullable();
			$table->string('encryption')->nullablle();
			$table->string('sender_name')->nullable();
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
		Schema::drop('mails');
	}

}
