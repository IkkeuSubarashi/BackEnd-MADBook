<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotations');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('q_items');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};
