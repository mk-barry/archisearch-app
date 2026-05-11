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
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Ex: CNI, BACC
            $table->string('label');           // Ex: Carte Nationale d'Identité
            $table->integer('max_size_kb');    // Ex: 2048
            $table->timestamps();
        });

        Schema::create('document_type_extension', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_type_id')->constrained();
            $table->foreignId('file_extension_id')->constrained();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
