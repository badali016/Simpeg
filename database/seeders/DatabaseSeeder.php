<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\PegawaiSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create some jabatans
        Jabatan::factory()->count(8)->create();

        // Sync PROFESI from SIMGOS into local jabatans (optional)
        if (class_exists(\Database\Seeders\ProfesiToJabatanSeeder::class)) {
            $this->call(\Database\Seeders\ProfesiToJabatanSeeder::class);
        }

        // Seed pegawai (creates admin pegawai + admin user and additional pegawai)
        $this->call(PegawaiSeeder::class);

        // Also keep a regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
