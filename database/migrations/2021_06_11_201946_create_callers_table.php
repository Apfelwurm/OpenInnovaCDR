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
            $table->string('name')->unique();
            $table->string('number')->unique();
            $table->bigInteger('organisation_unit_id')->unsigned()->nullable()->default(null);
            $table->timestamps();


            $table->foreign('organisation_unit_id')->references('id')->on('organisation_units')->nullable()->cascadeOnUpdate()->nullOnDelete();

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
