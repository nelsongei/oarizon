<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXLockPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_lock_payroll', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->default('0')->index('lock_payroll_user_id_foreign');
            $table->date('period');
            $table->string('authorized_by');
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
        Schema::dropIfExists('x_lock_payroll');
    }
}
