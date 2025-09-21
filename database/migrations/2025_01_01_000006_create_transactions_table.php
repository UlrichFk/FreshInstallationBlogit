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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Peut être null pour les transactions anonymes
            $table->enum('type', ['subscription', 'donation', 'refund'])->default('subscription');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable(); // stripe, paypal
            $table->string('transaction_id')->nullable(); // ID externe (Stripe, PayPal)
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Détails supplémentaires du paiement
            $table->string('related_model')->nullable(); // UserSubscription, Donation
            $table->unsignedBigInteger('related_id')->nullable(); // ID du modèle lié
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            // Index pour les performances
            $table->index('user_id');
            $table->index('type');
            $table->index('status');
            $table->index('payment_method');
            $table->index('transaction_id');
            $table->index('related_model');
            $table->index('related_id');
            $table->index('created_at');
            $table->index('processed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}; 