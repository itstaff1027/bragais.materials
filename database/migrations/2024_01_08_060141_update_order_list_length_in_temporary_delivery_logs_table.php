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
        Schema::table('temporary_delivery_logs', function (Blueprint $table) {
            // Change the length of the 'order_list' column to 3000
            $table->string('order_list', 3000)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('temporary_delivery_logs', function (Blueprint $table) {
            
        });
    }
};
