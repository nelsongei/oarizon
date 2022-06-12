<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTransactAdvancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_transact_advances', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('employee_id')->unsigned()->default('0')->index('transact_advances_employee_id_foreign');
			$table->integer('account_id')->unsigned()->default('0')->index('transact_account_id_foreign');
            $table->integer('organization_id')->unsigned()->default('0')->index('transact_advances_organization_id_foreign');
			$table->string('amount')->default('0.00');
			$table->string('financial_month_year');
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
		Schema::drop('x_transact_advances');
	}
}
