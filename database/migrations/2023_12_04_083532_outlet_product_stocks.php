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
        Schema::create('outlet_product_stocks', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('barcode_id')->nullable()->default(0);
            $table->integer('order_number')->default(0);
            $table->integer('stocks');
            $table->string('remarks', 255);
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
        Schema::dropIfExists('outlet_product_stocks');
    }
};
