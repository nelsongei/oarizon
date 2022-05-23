<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXKinsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
//		Schema::create('kins', function(Blueprint $table)
//		{
//			$table->increments('id');
//			$table->string('name');
//			$table->string('rship')->nullable();
//			$table->float('goodwill', 10, 0)->nullable();
//			$table->string('id_number')->nullable();
//			$table->integer('member_id')->unsigned()->index('kins_member_id_foreign');
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
	//	Schema::drop('kins');
	}

}
