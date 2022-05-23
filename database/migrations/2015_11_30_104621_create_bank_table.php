<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBankTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('bank_name');
			$table->integer('organization_id')->unsigned()->default('0')->index('banks_organization_id_foreign');
			$table->timestamps();
		});

		DB::table('banks')->insert(array(
            array('bank_name' => 'Equity Bank','organization_id' => '1'),
            array('bank_name' => 'Krep Bank','organization_id' => '1'),
            array('bank_name' => 'CO-Operative Bank','organization_id' => '1'),
            array('bank_name' => 'Family Bank','organization_id' => '1'),
            array('bank_name' => 'Barclays Bank','organization_id' => '1'),
            array('bank_name' => 'Kenya Commercial Bank','organization_id' => '1'),
            array('bank_name' => 'Chase Bank','organization_id' => '1'),
            array('bank_name' => 'Bank of Africa','organization_id' => '1'),
            array('bank_name' => 'COnsolidated Bank','organization_id' => '1'),
            array('bank_name' => 'CFC Stanbic Holdings Bank','organization_id' => '1'),
            array('bank_name' => 'Diamond Trust Bank','organization_id' => '1'),
        ));
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banks');
	}


}
