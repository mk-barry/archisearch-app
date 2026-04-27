<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Barry Mbatswe',
            'email' => 'mk.barry@archisearch.com',
            'password' => Hash::make('password'),
            'role' => 'super-admin',
            'organisation' => 'Super-Administration',
        ]);

        User::factory(9)->create([
            'password' => Hash::make('admin123'),
            'organisation' => 'Administration',
        ]);
    }
}
