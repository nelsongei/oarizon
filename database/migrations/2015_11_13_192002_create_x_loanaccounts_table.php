<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXLoanaccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_loanaccounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('member_id')->unsigned()->index('loanaccounts_member_id_foreign');
			$table->integer('loanproduct_id')->unsigned()->index('loanaccounts_loanproduct_id_foreign');
			$table->boolean('is_new_application')->default(1);
			$table->date('application_date');
			$table->float('amount_applied', 10, 0);
			$table->float('interest_rate', 10, 0);
			$table->integer('period');
			$table->boolean('is_approved')->default(0);
			$table->date('date_approved')->nullable();
			$table->float('amount_approved', 10, 0)->nullable();
			$table->boolean('is_rejected')->default(0);
			$table->string('rejection_reason')->nullable();
			$table->boolean('is_amended')->default(0);
			$table->date('date_amended')->nullable();
			$table->boolean('is_disbursed')->default(0);
			$table->float('amount_disbursed', 10, 0)->nullable();
			$table->date('date_disbursed')->nullable();
			$table->date('repayment_start_date')->nullable();
			$table->boolean('is_matured')->default(0);
			$table->boolean('is_written_off')->default(0);
			$table->boolean('is_defaulted')->default(0);
			$table->boolean('is_overpaid')->default(0);
			$table->string('account_number')->nullable();
			$table->timestamps();
			$table->integer('repayment_duration')->nullable();
			$table->boolean('is_top_up')->nullable()->default(0);
			$table->float('top_up_amount', 15, 3)->nullable()->default(0.000);
			$table->string('loan_purpose')->nullable();
            $table->integer('organization_id')->nulable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('loanaccounts');
	}

}
