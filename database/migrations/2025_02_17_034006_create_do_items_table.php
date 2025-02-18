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
        Schema::create('do_items', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_order_id');
            $table->foreign('delivery_order_id')->references('id')->on('q_delivery_orders');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('q_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('do_items');
    }
};
