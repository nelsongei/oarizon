<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name');
            $table->string('monday_in')->nullable();
            $table->string('monday_out')->nullable();
            $table->string('tuesday_in')->nullable();
            $table->string('tuesday_out')->nullable();
            $table->string('wednesday_in')->nullable();
            $table->string('wednesday_out')->nullable();
            $table->string('thursday_in')->nullable();
            $table->string('thursday_out')->nullable();
            $table->string('friday_in')->nullable();
            $table->string('friday_out')->nullable();
            $table->string('saturday_in')->nullable();
            $table->string('saturday_out')->nullable();
            $table->string('sunday_in')->nullable();
            $table->string('sunday_out')->nullable();
            $table->string('organization_id');
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
        Schema::dropIfExists('work_shifts');
    }
}
