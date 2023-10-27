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
        Schema::create('factory_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('material_sku', 255);
            $table->string('type', 255)->default('')->nullable();
            $table->string('name', 255)->default('')->nullable();
            $table->string('color', 255)->default('')->nullable();
            $table->string('size', 255)->default('')->nullable();
            $table->string('unit_per', 255)->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factory_materials');
    }
};
