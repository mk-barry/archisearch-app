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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // Nullable pour permettre les liens de groupe (WhatsApp)
            $table->string('email')->nullable();

            // Le token qui sera dans l'URL (ex: ?token=abc123xyz)
            $table->string('token')->unique();

            $table->dateTime('expires_at');
            $table->dateTime('used_at')->nullable(); // Preuve que le dépôt est fait

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
