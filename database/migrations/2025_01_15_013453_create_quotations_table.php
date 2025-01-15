<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->longText('logo');
            $table->string('subject');
            $table->date('valid_date');
            $table->boolean('status');
            $table->decimal('total', 10, 2);
            $table->timestamp('created_at');
            $table->string('c_name');
            $table->string('c_address');
            $table->string('c_no');
            $table->unsignedBigInteger('borrower_id');
                $table->foreign('borrower_id')->references('id')->on('borrowers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
