<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('q_delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
                $table->foreign('quote_id')->references('id')->on('quotations');
            $table->timestamp('created_at');
            $table->date('delivery_date');
            $table->date('due_date');
            $table->string('partner_by');
            $table->decimal('partner_cost', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('q_delivery_orders');
    }
};
