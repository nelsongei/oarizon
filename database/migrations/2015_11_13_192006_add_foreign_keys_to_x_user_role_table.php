<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXUserRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::table('x_user_role', function(Blueprint $table)
//		{
//			$table->foreign('user_id', 'user_role_fk')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
//			$table->foreign('role_id', 'user_role_fk1')->references('id')->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
//		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::table('user_role', function(Blueprint $table)
//		{
//			$table->dropForeign('user_role_fk');
//			$table->dropForeign('user_role_fk1');
//		});
	}

}
