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
        Schema::create('temporary_delivery_logs', function(Blueprint $table){
            $table->id();
            $table->integer('order_number');
            $table->string('order_list', 255);
            $table->string('customer_name', 255);
            $table->string('courier', 255);
            $table->integer('rush_fee');
            $table->string('sold_from', 255);
            $table->string('order_type', 255);
            $table->string('remarks', 255);
            $table->string('delivery_notes', 255);
            $table->string('status', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
