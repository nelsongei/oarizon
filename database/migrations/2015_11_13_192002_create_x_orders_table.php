<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('x_orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('product_id')->unsigned()->index('orders_product_id_index');
			$table->date('order_date')->nullable();
			$table->string('customer_name')->nullable();
			$table->string('sacco')->nullable();
			$table->string('customer_phone')->nullable();
			$table->string('customer_number')->nullable();
			$table->string('status')->default('new');
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
		Schema::drop('orders');
	}

}
