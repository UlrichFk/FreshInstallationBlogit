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
        Schema::table('membership_plans', function (Blueprint $table) {
            $table->string('stripe_price_id')->nullable()->after('features');
            $table->string('paypal_plan_id')->nullable()->after('stripe_price_id');
            $table->index('stripe_price_id');
            $table->index('paypal_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_plans', function (Blueprint $table) {
            $table->dropIndex(['stripe_price_id']);
            $table->dropIndex(['paypal_plan_id']);
            $table->dropColumn(['stripe_price_id', 'paypal_plan_id']);
        });
    }
}; 