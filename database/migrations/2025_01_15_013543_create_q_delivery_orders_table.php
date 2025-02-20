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
            $table->foreignId('quote_id')->constrained('quotations')->onDelete('cascade');
            $table->date('issue_date');
            $table->date('delivery_date');
            $table->date('due_date');
            $table->string('ship_by');
            $table->decimal('ship_fee', 10, 2);
            $table->string('c_name');
            $table->string('c_no');
            $table->text('c_address');
            $table->decimal('do_total', 10, 2)->default(0);
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('q_delivery_orders');
    }
};
