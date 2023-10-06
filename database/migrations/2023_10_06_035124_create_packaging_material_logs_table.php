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
        Schema::create('packaging_material_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('packaging_material_id');
            $table->integer('product_id')->default(0);
            $table->integer('order_number')->default(0);
            $table->integer('stocks');
            $table->string('status', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packaging_material_logs');
    }
};
