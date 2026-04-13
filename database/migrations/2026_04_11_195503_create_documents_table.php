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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Relation avec l'événement (obligatoire)
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // Identification (Nullable car un étudiant n'est pas un "User" au sens Laravel)
            $table->string('identifier'); // Matricule (Strict) ou Email (Open)
            $table->string('tracking_code')->index(); // Le code unique pour revenir consulter/modifier

            // Infos Fichier
            $table->string('file_path');
            $table->string('file_type'); // pdf, png, etc.
            $table->integer('file_size'); // en Ko
            $table->string('category'); // ex: "CNI", "Relevé de notes"

            // État du document
            $table->enum('status', ['submitted', 'pending', 'validated', 'rejected', 'error'])->default('pending');

            // Trçabilité & Audit (Optionnel mais pro pour ta soutenance)
            $table->string('processed_by')->nullable(); // Nom de l'admin qui a validé/rejeté
            $table->dateTime('processed_at')->nullable();
            $table->text('rejection_reason')->nullable(); // Pourquoi le doc a été refusé

            // Metadata pour l'IA (Anomalies, scores de confiance)
            $table->json('metadata')->nullable();
            $table->longText('extracted_text')->nullable();

            $table->timestamps(); // Gère déjà created_at (date d'upload) et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
