<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumberFilterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('number_filter_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('priority')->unique();
            $table->enum('direction', array('sender','receiver'))->default('receiver');
            $table->string('filter');
            $table->double('cost');
            $table->enum('cost_multiplier', array('second','minute'))->default('minute');
            $table->boolean('ignore_on_timereport')->default(false);
            $table->boolean('ignore_on_costreport')->default(false);
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
        Schema::dropIfExists('number_filter_settings');
    }
}
