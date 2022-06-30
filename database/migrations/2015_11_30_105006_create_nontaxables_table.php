<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateNonTaxablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_nontaxables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
            $table->integer('organization_id')->unsigned()->default('0')->index('nontaxables_organization_id_foreign');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('nontaxables');
	}


}
