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
        Schema::create('mtos', function(Blueprint $table){
            $table->id();
            $table->integer('order_number');
            $table->integer('agent_number');
            $table->string('customer_details', 255)->default('');
            $table->string('model', 255)->default('');
            $table->string('color', 255)->default('');
            $table->string('size', 255)->default('');
            $table->string('heel_height', 255)->default('');
            $table->string('heel_type', 255)->default('');
            $table->string('round', 255)->default('');
            $table->string('packaging_type', 255)->default('');
            $table->string('sold_date', 255)->default('');
            $table->string('remarks', 255)->default('');
            $table->string('notes', 255)->default('');
            $table->integer('is_replacement')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mtos');
    }
};
