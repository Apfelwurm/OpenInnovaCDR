<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneCallEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_call_events', function (Blueprint $table) {
            $table->id();
            $table->string('msg');
            $table->integer('time');
            $table->string('type')->nullable();
            $table->integer('e164')->nullable();
            $table->integer('root')->nullable();
            $table->string('h323')->nullable();
            $table->string('conf')->nullable();
            $table->string('cause')->nullable();
            $table->boolean('more')->nullable();
            $table->bigInteger('phone_call_id')->unsigned();
            $table->timestamps();


            $table->foreign('phone_call_id')->references('id')->on('phone_calls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_call_events');
    }
}
