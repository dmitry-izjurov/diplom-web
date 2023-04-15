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
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->timestamps();
            $table->boolean('is_sell_ticket')->default(false);
            $table->string('types_of_chairs')->default('d,d,d,s,s,d,d,d|d,d,s,s,s,s,d,d|d,s,s,s,s,s,s,d|s,s,s,v,v,s,s,s|s,s,v,v,v,v,s,d|s,s,v,v,v,v,s,d|s,s,v,v,v,v,s,d|s,s,s,s,s,s,s,d|s,s,s,s,s,s,s,s|s,s,s,s,s,s,s,s');
            $table->string('price_of_chair')->default('s:150|v:350');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
