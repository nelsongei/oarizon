<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_organizations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('XARA CBS')->nullable();
			$table->string('logo')->nullable();
			$table->string('email')->nullable();
			$table->string('website')->nullable();
			$table->string('address')->nullable();
			$table->string('phone')->nullable();
			$table->string('kra_pin')->nullable();
			$table->string('nssf_no')->nullable();
			$table->string('nhif_no')->nullable();
			$table->integer('bank_id')->unsigned()->default('0')->index('organization_bank_id_foreign');
			$table->integer('bank_branch_id')->unsigned()->default('0')->index('organization_bank_branch_id_foreign');
			$table->string('bank_account_number')->nullable();
			$table->string('swift_code')->nullable();
			$table->string('license_type')->nullable()->default('evaluation');
			$table->string('license_code')->nullable();
			$table->string('license_key')->nullable();
            $table->string('annual_support_key');
			$table->bigInteger('licensed')->nullable()->default(100);
            $table->date('installation_date')->default(date('Y-m-d'));
            $table->date('license_due_date')->default(date('Y-m-d'));
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
		Schema::drop('x_organizations');
	}

}
