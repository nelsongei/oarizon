<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('category');
			$table->integer('code');
			$table->string('name');
			$table->double('balance');
			$table->boolean('active');
            $table->integer('organization_id')->unsigned()->default('0')->index('accounts_organization_id_foreign');
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
		Schema::drop('accounts');
	}

}
