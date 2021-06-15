<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCallersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_callers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->bigInteger('report_organisation_unit_id')->unsigned()->nullable()->default(null);
            $table->timestamps();


            $table->foreign('report_organisation_unit_id')->references('id')->on('report_organisation_units')->nullable()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_callers');
    }
}
