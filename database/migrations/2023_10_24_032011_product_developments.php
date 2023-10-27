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
        Schema::create('product_developments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title', 255);
            $table->string('remarks', 255);
            $table->string('delivery_date', 255);
            $table->string('arrival_date', 255);
            $table->string('status', 255);
            $table->string('action', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_developments');
    }
};
