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

        Schema::create('q_bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id');
            $table->foreign('delivery_order_id')->references('id')->on('q_delivery_orders')->onDelete('cascade');
            $table->string('bank_name');
            $table->string('acc_holder');
            $table->string('acc_num');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_bank_details');
    }
};
