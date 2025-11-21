<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReferensiSimgos;
use App\Models\Jabatan;

class ProfesiToJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!class_exists(ReferensiSimgos::class)) {
            $this->command->info('ReferensiSimgos model not available; skipping Profesi→Jabatan seeding.');
            return;
        }

        try {
            $profesi = ReferensiSimgos::where('JENIS', 36)->orderBy('DESKRIPSI')->get();
        } catch (\Exception $e) {
            $this->command->error('Failed to fetch PROFESI from SIMGOS: ' . $e->getMessage());
            return;
        }

        foreach ($profesi as $p) {
            $kode = 'PRF-' . ($p->ID ?? '0');
            Jabatan::firstOrCreate(
                ['kode_jabatan' => $kode],
                ['nama_jabatan' => $p->DESKRIPSI ?? ('Profesi ' . ($p->ID ?? '')), 'eselon' => null, 'unit_kerja' => null, 'status' => 'Aktif']
            );
        }

        $this->command->info('Profesi->Jabatan seeding complete (count: ' . $profesi->count() . ').');
    }
}
