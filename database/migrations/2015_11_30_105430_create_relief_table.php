<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateReliefTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_relief', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('relief_name');
			$table->integer('organization_id')->unsigned()->default('0')->index('relief_organization_id_foreign');
			$table->timestamps();
		});

		DB::table('x_relief')->insert(array(
            array('relief_name' => 'Insurance Relief','organization_id' => '1'),
        ));
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('x_relief');
	}


}
