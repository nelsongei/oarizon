<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToXMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('x_members', function(Blueprint $table)
		{
			$table->foreign('branch_id', 'members_branch_id_foreign')->references('id')->on('x_branches')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('group_id', 'members_group_id_foreign')->references('id')->on('x_groups')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('members', function(Blueprint $table)
		{
			$table->dropForeign('members_branch_id_foreign');
			$table->dropForeign('members_group_id_foreign');
		});
	}

}
