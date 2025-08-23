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
        if (!Schema::hasTable('short_videos')) {
            Schema::create('short_videos', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->text('slug')->nullable();
                $table->string('video_type')->nullable();
                $table->string('video_url')->nullable();
                $table->string('video_file')->nullable();
                $table->unsignedBigInteger('created_by')->default(0);
                $table->string('background_image')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->dateTime('schedule_date')->nullable();
                $table->timestamps();
                $table->softDeletes();
                // Adding indexes
                $table->index('video_type');
                $table->index('title');
                $table->index('slug');
                $table->index('created_by');
                $table->index('schedule_date');
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_videos');
    }
};