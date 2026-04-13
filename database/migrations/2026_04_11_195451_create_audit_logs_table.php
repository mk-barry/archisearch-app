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
        Schema::create('action_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // ex: "Création d'événement"
            $table->text('description'); // ex: "L'utilisateur a initialisé une nouvelle collecte de documents."
            $table->timestamps();
        });
        
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            
            // Rendu nullable pour les actions des étudiants/candidats
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Relation optionnelle vers tes descriptions d'actions
            $table->foreignId('action_description_id')->nullable()->constrained('action_descriptions');
        
            $table->enum('action', ['delete', 'create', 'search', 'close', 'open', 'activate', 'disable', 'upload', 'modify']);
            
            $table->string('target_name'); // ex: "Nom du fichier" ou "ID de l'event"
            $table->text('details'); // Pour les infos spécifiques à l'instant T (ex: "IP: 192.168.1.1")
            
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
