<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEducationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('education', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('education_name');
			$table->integer('organization_id')->unsigned()->default('0')->index('education_organization_id_foreign');
			$table->timestamps();
		});

		DB::table('education')->insert(array(
            array('education_name' => 'Primary School','organization_id' => '1'),
            array('education_name' => 'Secondary School','organization_id' => '1'),
            array('education_name' => 'College - Certificate','organization_id' => '1'),
            array('education_name' => 'College - Diploma','organization_id' => '1'),
            array('education_name' => 'Degree','organization_id' => '1'),
            array('education_name' => 'Masters Degree','organization_id' => '1'),
            array('education_name' => 'PHD','organization_id' => '1'),
            array('education_name' => 'None','organization_id' => '1'),
        ));
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('education');
	}

}
