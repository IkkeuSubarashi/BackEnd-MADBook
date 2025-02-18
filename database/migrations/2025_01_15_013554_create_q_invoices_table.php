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
            $table->foreignId('delivery_order_id')->constrained('q_delivery_orders')->onDelete('cascade');
            $table->foreignId('quote_id')->constrained('quotations')->onDelete('cascade');
            $table->string('status')->default('Pending');
            $table->decimal('i_total', 10, 2);
            $table->timestamp('issue_date');
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('q_invoices');
    }
};
