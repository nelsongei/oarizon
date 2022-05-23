<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXLoanpostingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('x_loanpostings', function(Blueprint $table)
		{
			$table->foreign('loanproduct_id', 'loanpostings_loanproduct_id_foreign')->references('id')->on('loanproducts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loanpostings', function(Blueprint $table)
		{
			$table->dropForeign('loanpostings_loanproduct_id_foreign');
		});
	}

}
