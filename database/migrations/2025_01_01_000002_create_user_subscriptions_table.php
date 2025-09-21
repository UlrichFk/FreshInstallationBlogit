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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('membership_plan_id');
            $table->string('subscription_id')->nullable(); // External subscription ID (Stripe, PayPal)
            $table->enum('status', ['active', 'cancelled', 'expired', 'pending', 'failed'])->default('pending');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('cancelled_at')->nullable();
            $table->decimal('amount_paid', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method')->nullable(); // stripe, paypal
            $table->json('payment_details')->nullable();
            $table->boolean('auto_renew')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('membership_plan_id')->references('id')->on('membership_plans')->onDelete('cascade');
            
            $table->index('user_id');
            $table->index('membership_plan_id');
            $table->index('subscription_id');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
}; 