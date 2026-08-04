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
        Schema::create('mpesa_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('newusers')->cascadeOnDelete();
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->string('phone_number', 15); // e.g., 254712345678
            $table->decimal('amount', 15, 2);
            $table->string('reference')->unique(); // e.g., "KargoPay-12345"

            $table->string('merchant_request_id')->nullable();
            $table->string('checkout_request_id')->nullable();

            $table->string('status')->default('pending'); // pending, completed, failed, canceled
            $table->string('mpesa_receipt_number')->nullable(); // e.g., "QKH123456"
            $table->text('response_description')->nullable(); // e.g., "Success. Request accepted
            $table->timestamps();

            $table->index('checkout_request_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpesa_transactions');
    }
};
