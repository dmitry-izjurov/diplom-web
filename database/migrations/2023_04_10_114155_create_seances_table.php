<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->string('time_begin');
            $table->bigInteger('film_id')->unsigned();
            $table->bigInteger('hall_id')->unsigned();
            $table->foreign('film_id')->references('id')->on('films');
            $table->foreign('hall_id')->references('id')->on('halls');
            $table->string('types_of_chairs');
            $table->string('price_of_chair');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
