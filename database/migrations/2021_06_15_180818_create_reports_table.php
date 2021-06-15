<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->enum('cause', array('scheduled','manual'))->default('manual');
            $table->dateTime('startdate');
            $table->dateTime('enddate');
            $table->bigInteger('report_template_id')->unsigned()->nullable()->default(null);
            $table->enum('status', array('queued','running','finished','error'))->default('queued');
            $table->timestamps();
            $table->foreign('report_template_id')->references('id')->on('report_templates')->nullable()->cascadeOnUpdate()->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
