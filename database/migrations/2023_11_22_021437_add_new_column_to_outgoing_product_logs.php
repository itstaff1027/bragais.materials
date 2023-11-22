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
        Schema::table('outgoing_product_logs', function (Blueprint $table) {
            $table->string('closed_sale_date')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outgoing_product_logs', function (Blueprint $table) {
            $table->dropColumn('closed_sale_date');
        });
    }
};
