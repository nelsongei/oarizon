<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXLoantransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loantransactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('loanaccount_id')->unsigned()->index('loantransactions_loanaccount_id_foreign');
			$table->date('date');
			$table->string('description')->nullable();
			$table->string('trans_no')->nullable();
			$table->float('amount', 10, 0)->default(0);
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
		Schema::drop('loantransactions');
	}

}
