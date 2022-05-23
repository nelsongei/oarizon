<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXUserRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::create('x_user_role', function(Blueprint $table)
//		{
//			$table->integer('id')->primary();
//			$table->integer('user_id')->unsigned()->nullable()->index('user_id');
//			$table->integer('role_id')->unsigned()->nullable()->index('x_user_role_fk1');
//		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('user_role');
	}

}
