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
        if (!Schema::hasTable('ad_analytics')) {
            Schema::create('ad_analytics', function (Blueprint $table) {
                $table->id();
                $table->enum('type', ['view','click'])->default('view');
                $table->unsignedBigInteger('user_id')->default(0);
                $table->unsignedBigInteger('ad_id')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
                 // Adding indexes
                $table->index('type');
                $table->index('user_id');
                $table->index('ad_id');
                $table->index('created_at');
                $table->index('updated_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_analytics');
    }
};
