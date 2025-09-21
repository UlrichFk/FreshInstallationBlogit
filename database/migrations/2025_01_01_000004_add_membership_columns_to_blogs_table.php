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
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('is_premium')->default(false)->after('is_featured');
            $table->text('premium_content')->nullable()->after('is_premium');
            $table->unsignedBigInteger('required_plan_id')->nullable()->after('premium_content');
            
            $table->foreign('required_plan_id')->references('id')->on('membership_plans')->onDelete('set null');
            $table->index('is_premium');
            $table->index('required_plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['required_plan_id']);
            $table->dropIndex(['is_premium']);
            $table->dropIndex(['required_plan_id']);
            $table->dropColumn(['is_premium', 'premium_content', 'required_plan_id']);
        });
    }
}; 