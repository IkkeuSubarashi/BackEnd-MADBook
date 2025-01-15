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
            $table->string('description');
            $table->integer('qty');
            $table->decimal('unit_price', 10,2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('q_items');
    }
};
