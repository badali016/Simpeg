<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // Demo admin: create a pegawai and a linked user first to reserve unique fields
        $adminPegawai = Pegawai::factory()->create([
            'nama_pegawai' => 'Admin Demo',
            'nip' => '0000000001',
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'pegawai_id' => $adminPegawai->id,
        ]);

        // Create pegawai (ensure jabatans exist) AFTER admin so faker unique() avoids collisions
        Pegawai::factory()->count(30)->create();

        // Also keep a regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
