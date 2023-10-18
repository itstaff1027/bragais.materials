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
        Schema::create('outgoing_product_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->default(0);
            $table->integer('order_number')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('status', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_product_logs');
    }
};
