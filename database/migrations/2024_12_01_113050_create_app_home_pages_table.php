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
        if (!Schema::hasTable('app_home_pages')) {
            Schema::create('app_home_pages', function (Blueprint $table) {
                $table->id();
                $table->string('title', 255)->nullable();
                $table->string('type', 255)->nullable();
                $table->string('category_id')->default(0);
                $table->string('sub_category_id')->default(0);
                $table->integer('visibility_id')->default(0);
                $table->integer('order')->default(1);
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
                 // Adding indexes
                $table->index('title');
                $table->index('type');
                $table->index('order');
                $table->index('category_id');
                $table->index('sub_category_id');
                $table->index('visibility_id');
                $table->index('created_at');
                $table->index('updated_at');
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_home_pages');
    }
};
