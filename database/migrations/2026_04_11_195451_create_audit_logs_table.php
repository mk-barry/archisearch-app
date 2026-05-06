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
        // Table des modèles d'actions
        Schema::create('action_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // ex: 'user_disabled'
            $table->string('title');          // ex: 'Désactivation'
            $table->text('template');         // ex: 'Le compte de :name a été désactivé.'
            $table->timestamps();
        });

        // Table des logs réels
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'auteur
            $table->foreignId('action_description_id')->constrained();      // Le modèle
            $table->json('dynamic_data')->nullable(); // Les variables (ex: {"name": "Jean"})
            $table->ipAddress('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('action_descriptions');
    }
};
