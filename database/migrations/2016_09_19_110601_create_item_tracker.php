<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTracker extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_tracker', function($table){
			$table->increments('id');
			$table->integer('item_id')->unsigned();
			$table->tinyInteger('items_leased')->unsigned();
			$table->tinyInteger('items_returned')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->integer('client_id')->unsigned();
			$table->string('status', 20);
			$table->date('date_leased');
			$table->date('date_returned');
			$table->timestamps();

			$table->foreign('item_id')->references('id')->on('items');
			$table->foreign('location_id')->references('id')->on('locations');
			$table->foreign('client_id')->references('id')->on('clients');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item_tracker');
	}

}
