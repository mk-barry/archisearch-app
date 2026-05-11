<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Events;
use App\Models\AuthorizedStudent;
use App\Models\DocumentType;
use App\Models\FileExtension;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EventsTestSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. CONFIGURATION DES FORMATS (La Nomenclature) ---
        $extensions = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png'
        ];

        $extModels = [];
        foreach ($extensions as $name => $mime) {
            $extModels[$name] = FileExtension::updateOrCreate(
                ['name' => $name],
                ['mime_type' => $mime]
            );
        }

        // --- 2. CRÉATION DES TYPES DE DOCUMENTS PROFESSIONNELS ---
        // On crée la CNI
        $cni = DocumentType::updateOrCreate(
            ['code' => 'CNI'],
            [
                'label' => 'Carte Nationale d\'Identité',
                'max_size_kb' => 2048, // 2MB
            ]
        );
        $cni->allowedExtensions()->sync([$extModels['pdf']->id, $extModels['jpg']->id, $extModels['png']->id]);

        // On crée le Diplôme
        $diplome = DocumentType::updateOrCreate(
            ['code' => 'BACC'],
            [
                'label' => 'Baccalauréat ou Équivalent',
                'max_size_kb' => 5120, // 5MB
            ]
        );
        $diplome->allowedExtensions()->sync([$extModels['pdf']->id]);

        // --- 3. UTILISATEURS & ÉTUDIANTS ---
        $admin = User::updateOrCreate(
            ['email' => 'admin@archisearch.com'],
            [
                'name' => 'Admin Test',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $studentsData = [
            ['matricule' => '24G001', 'name' => 'Jean Dupont'],
            ['matricule' => '24G002', 'name' => 'Marie Songo'],
            ['matricule' => '24G003', 'name' => 'Paul Biya'],
            ['matricule' => '24G004', 'name' => 'Alice Wong'],
        ];

        $studentIds = [];
        foreach ($studentsData as $data) {
            $s = AuthorizedStudent::updateOrCreate(
                ['matricule' => $data['matricule']],
                [
                    'name' => $data['name'],
                    'email' => strtolower(str_replace(' ', '.', $data['name'])) . '@student.com',
                ]
            );
            $studentIds[] = $s->id;
        }

        // --- 4. ÉVÉNEMENT "TOUS" ---
        $eventTous = Events::create([
            'user_id' => $admin->id,
            'title' => 'Session de rattrapage DUT2',
            'description' => 'Dépôt ouvert à tous les étudiants.',
            'start_date' => now(),
            'end_date' => now()->addDays(14),
            'uuid' => (string) Str::uuid(),
            'invite_type' => 'tous',
            'status' => 'actif',
        ]);
        // On lie les types de documents nécessaires à cet événement
        $eventTous->documentTypes()->attach([$cni->id, $diplome->id]);

        // --- 5. ÉVÉNEMENT "PARTICULIERS" ---
        $eventP = Events::create([
            'user_id' => $admin->id,
            'title' => 'Concours Spécifique Master',
            'description' => 'Seulement pour Jean et Marie.',
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'uuid' => (string) Str::uuid(),
            'invite_type' => 'particuliers',
            'status' => 'actif',
        ]);
        $eventP->documentTypes()->attach([$cni->id]);

        // Liaison des étudiants autorisés
        $eventP->authorizedStudent()->attach($studentIds);
    }
}