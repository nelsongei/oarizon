<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXLoanrepaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loanrepayments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('loanaccount_id')->unsigned()->index('loanrepayments_loanaccount_id_foreign');
			$table->date('date');
			$table->float('principal_paid', 12)->default(0.00);
			$table->float('interest_paid', 12)->default(0.00);
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
		Schema::drop('loanrepayments');
	}

}
