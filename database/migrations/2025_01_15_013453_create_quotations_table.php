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
            $table->longText('logo')->nullable();
            $table->string('subject');
            $table->text('address');
            $table->string('email');
            $table->date('issue_date');
            $table->date('valid_date');
            $table->boolean('status')->default(false);
            $table->decimal('q_total', 10, 2)->default(0.00);
            $table->string('c_name');
            $table->string('c_address');
            $table->string('c_no');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('borrower_id');
            $table->foreign('borrower_id')->references('id')->on('borrowers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
