<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXTransactPensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_transact_pensions', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->unsigned()->default('0')->index('transact_pensions_employee_id_foreign');
            $table->integer('organization_id')->unsigned()->default('0')->index('transact_pensions_organization_id_foreign');
            $table->string('pension_file_number');
            $table->double('employee_amount',2);
            $table->double('employer_amount',2);
            $table->integer('employee_percentage');
            $table->double('employer_percentage',2);
            $table->integer('month');
            $table->integer('year');
            $table->date('financial_month_year');
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
        Schema::dropIfExists('x_transact_pensions');
    }
}
