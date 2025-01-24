<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('q_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_order_id');
                $table->foreign('delivery_order_id')->references('id')->on('q_delivery_orders');
            $table->unsignedBigInteger('quote_id');
                $table->foreign('quote_id')->references('id')->on('quotations');
            $table->string('status');
            $table->decimal('total', 10, 2);
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('q_invoices');
    }
};
