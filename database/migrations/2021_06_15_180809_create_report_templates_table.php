<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->enum('type', array('time','cost'))->default('time');
            $table->enum('output_format', array('PDF'))->default('PDF');
            $table->enum('schedule', array('monthly', 'weekly', 'daily','once','disabled'))->default('disabled');
            $table->enum('timespan', array('one month back from now','last month', 'current month', 'one week back from now','last week', 'current week','one day back from now', 'yesterday', 'today'))->default('last month');
            $table->dateTime('startdate');
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
        Schema::dropIfExists('report_templates');
    }
}
