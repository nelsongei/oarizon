<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pensions', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->unsigned()->default('0')->index('pensions_employee_id_foreign');
            $table->float('employee_contribution',2);
            $table->float('employer_contribution',2);
            $table->float('employer_percentage',);
            $table->float('employee_percentage',);
            $table->float('monthly_deduction',2);
            $table->string('type');
            $table->integer('organization_id')->nulable();
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
        Schema::dropIfExists('pensions');
    }
}
