<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXTaxOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tax_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tax_id')->nullable();
			$table->string('order_number')->nullable();
			$table->double('amount',15,2)->nullable();
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
		Schema::drop('tax_orders');
	}

}
