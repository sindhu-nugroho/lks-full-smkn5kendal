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
        Schema::create('book_transaction', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel transactions
        $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
        // Menghubungkan ke tabel books
        $table->foreignId('book_id')->constrained()->onDelete('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_transaction');
    }
};
