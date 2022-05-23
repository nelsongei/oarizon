<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXLoanguarantorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('x_loanguarantors', function(Blueprint $table)
		{
			$table->foreign('loanaccount_id', 'loanguarantors_loanaccount_id_foreign')->references('id')->on('x_loanaccounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('member_id', 'loanguarantors_member_id_foreign')->references('id')->on('x_members')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('loanguarantors', function(Blueprint $table)
		{
			$table->dropForeign('loanguarantors_loanaccount_id_foreign');
			$table->dropForeign('loanguarantors_member_id_foreign');
		});
	}

}
