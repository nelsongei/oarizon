<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateBankBranchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_branches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('branch_code',30);
			$table->string('bank_branch_name');
			$table->integer('organization_id')->unsigned()->default('0')->index('bank_branches_organization_id_foreign');
			$table->integer('bank_id')->unsigned()->default('0')->index('bank_branches_bank_id_foreign');
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
		Schema::drop('bank_branches');
	}

}
