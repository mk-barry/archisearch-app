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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // On lie l'événement à l'admin qui l'a créé
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();

            $table->date('start_date');
            $table->date('end_date');

            // Le jeton unique pour l'URL (ex: /depot/550e8400-e29b...)
            $table->uuid('uuid')->unique();

            // Le coeur de ta logique : Strict (école) ou Open (concours)
            $table->enum('invite_type', ['tous', 'particuliers'])->default('tous');
            $table->integer('max_file_size')->default(2048);

            // Gestion de l'état du lien
            $table->enum('status', ['brouillon', 'actif', 'cloture', 'archive'])->default('actif');
            // $table->timestamp('expires_at')->nullable();

            // Génère automatiquement created_at et updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
