<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
        ]);
        $this->call([
            EquipeSeeder::class,
            ProjetSeeder::class,
            FormationSeeder::class,
            ParticipantSeeder::class,
            MembreSeeder::class,
        ]);
    }
}
