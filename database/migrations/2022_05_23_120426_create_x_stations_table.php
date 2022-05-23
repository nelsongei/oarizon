<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_stations', function (Blueprint $table) {
            $table->id();
            $table->string('station_name');
            $table->string('location');
            $table->text('description');
            $table->integer('organization_id')->unsigned()->default('0')->index('stations_organization_id_foreign');
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
        Schema::dropIfExists('x_stations');
    }
}
