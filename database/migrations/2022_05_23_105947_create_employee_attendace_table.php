<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAttendaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendace', function (Blueprint $table) {
            $table->id();
            $table->integer('office_shift_id')->unsigned();
//            $table->foreign('office_shift_id')->references('id')->on('work_shifts')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('employee_id')->unsigned();
//            $table->foreign('employee_id')->references('id')->on('x_employee')->onUpdate('cascade')->onDelete('cascade');
            $table->date('attendace_date');
            $table->string('attendace_status');
            $table->time('clock_in');
            $table->time('clock_out');
            $table->integer('time_late');
            $table->time('early_leaving')->nullable();
            $table->integer('overtime');
            $table->integer('total_work');
            $table->integer('total_rest');
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
        Schema::dropIfExists('employee_attendace');
    }
}
