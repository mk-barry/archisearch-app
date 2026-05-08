<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Events;
use App\Models\AuthorizedStudent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EventsTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un Admin pour tester
        $admin = User::updateOrCreate(
            ['email' => 'admin@archisearch.com'],
            [
                'name' => 'Admin Test',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 2. Créer une liste d'étudiants autorisés
        $studentsData = [
            ['matricule' => '24G001', 'name' => 'Jean Dupont'],
            ['matricule' => '24G002', 'name' => 'Marie Songo'],
            ['matricule' => '24G003', 'name' => 'Paul Biya'],
            ['matricule' => '24G004', 'name' => 'Alice Wong'],
        ];

        $studentIds = [];
        foreach ($studentsData as $data) {
            $student = AuthorizedStudent::updateOrCreate(
                ['matricule' => $data['matricule']],
                [
                    'name' => $data['name'],
                    'email' => strtolower(str_replace(' ', '.', $data['name'])) . '@student.com',
                ]
            );
            $studentIds[] = $student->id;
        }

        // 3. Créer un événement en mode "TOUS"
        Events::create([
            'user_id' => $admin->id,
            'title' => 'Session de rattrapage DUT2',
            'description' => 'Dépôt des dossiers pour le rattrapage du semestre 1.',
            'start_date' => now(),
            'end_date' => now()->addDays(14),
            'uuid' => (string) Str::uuid(),
            'invite_type' => 'tous',
            'required_docs' => ['CNI', 'Relevé de notes'],
            'status' => 'actif',
        ]);

        // 4. Créer un événement en mode "PARTICULIERS" (seulement Jean et Marie)
        $eventP = Events::create([
            'user_id' => $admin->id,
            'title' => 'Concours Spécifique Master',
            'description' => 'Événement réservé aux étudiants sélectionnés.',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'uuid' => (string) Str::uuid(),
            'invite_type' => 'particuliers',
            'required_docs' => ['Passeport', 'Diplôme Licence'],
            'status' => 'actif',
        ]);

        // Lier les étudiants spécifiques via la table pivot
        // Assure-toi que la relation "AuthorizedStudent" est définie dans ton modèle Events
        $eventP->AuthorizedStudent()->attach([$studentIds[0], $studentIds[1]]);
    }
}
