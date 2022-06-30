<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('item_make');
			$table->string('item_size');
			$table->date('date')->nullable();
			$table->string('description')->nullable();
			$table->double('purchase_price')->default(0);;
			$table->double('selling_price')->default(0);
			$table->string('sku')->nullable();
			$table->string('tag_id')->nullable();
			$table->integer('reorder_level')->nullable();
            $table->integer('organization_id')->nullable();
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
		Schema::drop('items');
	}

}
