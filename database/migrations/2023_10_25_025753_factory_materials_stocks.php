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
        Schema::create('factory_materials_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('material_id');
            $table->integer('stocks');
            $table->string('remarks', 255)->default('')->nullable();
            $table->string('status', 255)->default('')->nullable();
            $table->string('action', 255)->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factory_materials_stocks');
    }
};
