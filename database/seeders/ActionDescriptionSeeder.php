<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            // Gestion des comptes
            [
                'slug' => 'user_activated',
                'title' => 'Activation de compte',
                'template' => "L'administrateur :admin a activé le compte de :target."
            ],
            [
                'slug' => 'user_deactivated',
                'title' => 'Désactivation de compte',
                'template' => "L'administrateur :admin a désactivé le compte de :target."
            ],
            // Gestion des documents (Cœur d'ArchiSearch)
            [
                'slug' => 'doc_archived',
                'title' => 'Archivage de diplôme',
                'template' => "Le diplôme n°:num (:owner) a été archivé avec succès."
            ],
            [
                'slug' => 'doc_verified',
                'title' => 'Vérification de document',
                'template' => "Authenticité vérifiée pour le document :doc."
            ],
            // Sécurité
            [
                'slug' => 'login_success',
                'title' => 'Connexion réussie',
                'template' => ":admin s'est connecté au système."
            ],
            [
                'slug' => 'login_failed',
                'title' => 'Échec de connexion',
                'template' => "Tentative de connexion échouée avec l'identifiant :login."
            ],
        ];

        foreach ($actions as $action) {
            \App\Models\ActionDescription::updateOrCreate(['slug' => $action['slug']], $action);
        }
    }
}
