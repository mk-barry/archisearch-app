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
                'slug' => 'user_created',
                'title' => 'Création de compte',
                'template' => "Le :role :admin a créé le compte de :target.",
            ],
            [
                'slug' => 'user_updated',
                'title' => 'Modification de compte',
                'template' => "Le :role :admin a modifié le compte de :target.",
            ],
            [
                'slug' => 'user_activated',
                'title' => 'Activation de compte',
                'template' => "Le :role :admin a activé le compte de :target.",
                'badge' => 'alerte'
            ],
            [
                'slug' => 'user_desactivated',
                'title' => 'Désactivation de compte',
                'template' => "Le :role :admin a désactivé le compte de :target.",
                'badge' => 'alerte'
            ],
            // Gestion des documents (Cœur d'ArchiSearch)
            [
                'slug' => 'doc_archived',
                'title' => 'Archivage de document',
                'template' => "Le document n°:num (:owner) a été archivé avec succès.",
            ],
            [
                'slug' => 'doc_verified',
                'title' => 'Vérification de document',
                'template' => "Authenticité vérifiée pour le document :doc.",
                'badge' => 'alerte'
            ],
            // Sécurité
            [
                'slug' => 'login_success',
                'title' => 'Connexion réussie',
                'template' => ":admin s'est connecté au système.",
                 
            ],
            [
                'slug' => 'login_failed',
                'title' => 'Échec de connexion',
                'template' => "Tentative de connexion échouée avec l'identifiant :login.",
                'badge' => 'erreur'
            ],
            [
                'slug' => 'logout',
                'title' => 'Déconnexion',
                'template' => ":admin s'est déconnecté du système.",
            ],
        ];

        foreach ($actions as $action) {
            \App\Models\ActionDescription::updateOrCreate(['slug' => $action['slug']], $action);
        }
    }
}
