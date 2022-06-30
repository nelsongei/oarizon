<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXAuditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_audits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('date')->nullable();
			$table->string('user')->nullable();
			$table->string('action')->nullable();
			$table->string('entity')->nullable();
			$table->float('amount', 10, 0)->nullable();
			$table->string('description')->nullable();
            $table->integer('organization_id')->nullable();
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
		Schema::drop('audits');
	}

}
