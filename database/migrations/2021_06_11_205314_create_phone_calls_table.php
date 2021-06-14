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
            $table->string('guid')->nullable();
            $table->string('sys')->nullable();
            $table->string('pbx')->nullable();
            $table->string('node')->nullable();
            $table->string('cn')->nullable();
            $table->string('e164')->nullable();
            $table->string('h323')->nullable();
            $table->string('device')->nullable();
            $table->string('dir')->nullable();
            $table->string('utc')->nullable();
            $table->string('local')->nullable();
            $table->bigInteger('caller_id')->nullable()->unsigned();
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
