<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('runaway_unique_codes', function(Blueprint $table){
            $table->id();
            $table->uuid('uuid');
            $table->string('left', 255)->default('');
            $table->string('right', 255)->default('');
            $table->integer('order_number')->default(0);
            $table->string('customer')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runaway_unique_codes');
    }
};
