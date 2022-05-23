<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::create('x_permissions', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->string('name')->unique('permissions_name_unique');
//			$table->string('display_name');
//			$table->string('category');
//			$table->timestamps();
//		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
//		Schema::drop('permissions');
	}

}
