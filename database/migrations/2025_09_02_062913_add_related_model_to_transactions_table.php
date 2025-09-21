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
        Schema::table('transactions', function (Blueprint $table) {
            // Ajouter la colonne related_model si elle n'existe pas
            if (!Schema::hasColumn('transactions', 'related_model')) {
                $table->string('related_model')->nullable()->after('metadata');
            }
            
            // Ajouter la colonne related_id si elle n'existe pas
            if (!Schema::hasColumn('transactions', 'related_id')) {
                $table->unsignedBigInteger('related_id')->nullable()->after('related_model');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['related_model', 'related_id']);
        });
    }
};
