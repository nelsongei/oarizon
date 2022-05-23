<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXSavingaccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('savingaccounts', function(Blueprint $table)
		{
			$table->foreign('member_id', 'savingaccounts_member_id_foreign')->references('id')->on('x_members')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('savingproduct_id', 'savingaccounts_fk')->references('id')->on('savingproducts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('savingaccounts', function(Blueprint $table)
		{
			$table->dropForeign('savingaccounts_member_id_foreign');
			$table->dropForeign('savingaccounts_fk');
		});
	}

}
