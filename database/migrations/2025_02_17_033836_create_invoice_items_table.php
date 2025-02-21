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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('q_invoices');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('q_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
