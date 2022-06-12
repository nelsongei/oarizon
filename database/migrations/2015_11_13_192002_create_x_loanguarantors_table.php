<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXLoanguarantorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_loanguarantors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('member_id')->unsigned()->index('loanguarantors_member_id_foreign');
			$table->integer('loanaccount_id')->unsigned()->index('loanguarantors_loanaccount_id_foreign');
			$table->float('amount', 10, 0)->default(0);
			$table->timestamps();
            $table->integer('organization_id')->nulable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('loanguarantors');
	}

}
