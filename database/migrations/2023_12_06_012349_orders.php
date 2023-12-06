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
        Schema::create('orders', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('employee_id');
            $table->integer('customer_id');
            $table->integer('quantity');
            $table->integer('paid');
            $table->integer('balance');
            $table->integer('excess');
            $table->integer('shipping_fee');
            $table->integer('rush_fee');
            $table->string('payment_method', 255);
            $table->string('order_type', 255);
            $table->string('sold_from', 255);
            $table->string('remarks', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
