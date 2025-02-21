<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('q_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2)->default(0.00);
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('delivery_order_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('q_items');
    }
};
