<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXSavingaccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('savingaccounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('member_id')->unsigned()->index('savingaccounts_member_id_foreign');
			$table->integer('savingproduct_id')->unsigned()->index('x_savingaccounts_fk');
			$table->string('account_number')->unique('account_number');
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
		Schema::drop('savingaccounts');
	}

}
