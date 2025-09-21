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
        Schema::create('watermark_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_enabled')->default(false);
            $table->enum('type', ['text', 'image'])->default('text');
            $table->string('text')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('position', ['top-left', 'top-right', 'bottom-left', 'bottom-right', 'center'])->default('bottom-right');
            $table->integer('opacity')->default(50); // 0-100
            $table->integer('size')->default(20); // Font size or image size percentage
            $table->string('color')->default('#ffffff');
            $table->string('font_family')->default('Arial');
            $table->boolean('apply_to_original')->default(false);
            $table->boolean('apply_to_768x428')->default(true);
            $table->boolean('apply_to_327x250')->default(true);
            $table->boolean('apply_to_80x45')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watermark_settings');
    }
}; 