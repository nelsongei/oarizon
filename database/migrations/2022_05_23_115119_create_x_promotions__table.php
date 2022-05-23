<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('x_promotions', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->unsigned()->default('0')->index('promotions_employee_id_foreign');
            $table->double('salary',2);
            $table->text('reason');
            $table->string('type');
            $table->integer('department_id')->unsigned()->default('0')->index('promotions_department_id_foreign');
            $table->integer('organization_id')->unsigned()->default('0')->index('promotions_organization_id_foreign');
            $table->integer('stationfrom');
            $table->integer('stationto');
            $table->integer('position');
            $table->date('date');
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
        Schema::dropIfExists('x_promotions_');
    }
}
