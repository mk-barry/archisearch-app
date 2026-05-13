<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // 1. On crée la colonne pour stocker l'ID du type
            // constrained() crée automatiquement le lien vers la table document_types
            // onDelete('cascade') supprime les docs si le type est supprimé (optionnel)
            $table->foreignId('document_type_id')
                ->after('id')
                ->nullable() // Utile si tu as déjà des documents existants
                ->constrained()
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['document_type_id']);
            $table->dropColumn('document_type_id');
        });
    }
};
