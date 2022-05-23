<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name');
            $table->string('asset_number');
            $table->date('purchase_date');
            $table->double('purchase_price',15,2);
            $table->double('book_value',15,2);
            $table->date('warranty_expiry');
            $table->string('serial_number');
            $table->date('depreciation_start_date');
            $table->date('last_depreciated');
            $table->string('depreciation_method');
            $table->string('averaging_method');
            $table->double('salvage_value',15,2);
            $table->string('method');
            $table->double('rate',3,2);
            $table->smallInteger('years');
            $table->string('status');
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
        Schema::dropIfExists('assets');
    }
}
