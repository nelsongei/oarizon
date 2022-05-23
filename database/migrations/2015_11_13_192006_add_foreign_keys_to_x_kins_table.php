<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXKinsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::table('kins', function(Blueprint $table)
//		{
//			$table->foreign('member_id', 'kins_member_id_foreign')->references('id')->on('members')->onUpdate('RESTRICT')->onDelete('RESTRICT');
//		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('kins', function(Blueprint $table)
		{
			$table->dropForeign('kins_member_id_foreign');
		});
	}

}
