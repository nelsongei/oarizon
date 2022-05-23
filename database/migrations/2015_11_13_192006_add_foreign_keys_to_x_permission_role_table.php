<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXPermissionRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::table('x_permission_role', function(Blueprint $table)
//		{
//			$table->foreign('permission_id', 'permission_role_permission_id_foreign')->references('id')->on('permissions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
//			$table->foreign('role_id', 'permission_role_role_id_foreign')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
//		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::table('permission_role', function(Blueprint $table)
//		{
//			$table->dropForeign('permission_role_permission_id_foreign');
//			$table->dropForeign('permission_role_role_id_foreign');
//		});
	}

}
