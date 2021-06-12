<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number')->unique();
            $table->bigInteger('organisation_unit_id')->unsigned();
            $table->timestamps();


            $table->foreign('organisation_unit_id')->references('id')->on('organisation_units')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callers');
    }
}
