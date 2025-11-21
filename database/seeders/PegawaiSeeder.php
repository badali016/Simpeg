<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        // Create a deterministic admin pegawai first
        $admin = Pegawai::create([
            'nip' => '0000000001',
            'nama' => 'Admin Demo',
            'panggilan' => 'Admin',
            'gelas_depan' => null,
            'gelas_belakang' => null,
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'agama' => 'Islam',
            'jenis_kelamin' => 1,
            'profesi' => null,
            'smf' => null,
            'alamat' => 'Jl. Demo No.1',
            'rt' => '001',
            'rw' => '002',
            'kodepos' => '10110',
            'wilayah' => '3171',
            'tanggal' => Carbon::now(),
            'non_pegawai' => 0,
            'status' => 1,
            'email' => 'admin@example.com',
        ]);

        // Create an admin user linked to that pegawai
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'pegawai_id' => $admin->id,
        ]);

        // Create additional pegawai via factory
        Pegawai::factory()->count(29)->create();
    }
}
