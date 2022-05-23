<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXLoanproductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loanproducts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('short_name');
			$table->string('formula');
			$table->float('interest_rate', 10, 0);
			$table->timestamps();
			$table->string('amortization')->nullable()->default('EI');
			$table->integer('period')->nullable();
			$table->string('currency');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('loanproducts');
	}

}
