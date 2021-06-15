<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportPhoneCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_phone_calls', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('time');
            $table->bigInteger('receiver');
            $table->bigInteger('report_number_filter_setting_id')->nullable()->unsigned();
            $table->bigInteger('report_caller_id')->nullable()->unsigned();
            $table->bigInteger('report_id')->nullable()->unsigned();

            $table->timestamps();
            $table->foreign('report_number_filter_setting_id')->references('id')->on('report_number_filter_settings')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('report_caller_id')->references('id')->on('report_callers')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('report_id')->references('id')->on('reports')->cascadeOnUpdate()->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_phone_calls');
    }
}
