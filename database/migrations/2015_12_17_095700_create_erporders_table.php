<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateErpordersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('erporders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->foreign('client_id')->references('id')->on('clients');
			$table->date('date')->nullable();
			$table->date('credit_period')->nullable();
			$table->string('status')->nullablle();
			$table->double('total_amount')->nullable();
			$table->double('discount_amount')->nullable();
			$table->string('type');
			$table->boolean('is_lease')->default(0);
			$table->boolean('is_paid')->default(0);
			$table->string('payment_type')->nullable();
			$table->string('order_number')->nullable();
			$table->string('inv_number')->nullable();
			$table->date('due_date')->nullable();
			$table->string('ordered_by')->nullable();
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
		Schema::drop('erporders');
	}

}
