<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_calls', function (Blueprint $table) {
            $table->id();
            $table->string('guid');
            $table->string('sys');
            $table->string('pbx');
            $table->string('node');
            $table->string('cn');
            $table->string('e164');
            $table->string('h323');
            $table->string('device');
            $table->string('dir');
            $table->string('utc');
            $table->string('local');
            $table->bigInteger('caller_id')->unsigned();
            $table->timestamps();
            $table->foreign('caller_id')->references('id')->on('callers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_calls');
    }
}
