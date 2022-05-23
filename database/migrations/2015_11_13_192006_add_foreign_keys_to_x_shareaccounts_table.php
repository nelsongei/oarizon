<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXShareaccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('shareaccounts', function(Blueprint $table)
		{
			$table->foreign('member_id', 'shareaccounts_member_id_foreign')->references('id')->on('x_members')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('shareaccounts', function(Blueprint $table)
		{
			$table->dropForeign('shareaccounts_member_id_foreign');
		});
	}

}
