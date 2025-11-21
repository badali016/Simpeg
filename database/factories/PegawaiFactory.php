<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jabatan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    public function definition(): array
    {
        $jabatan = Jabatan::inRandomOrder()->first();

        return [
            'nama_pegawai' => $this->faker->name(),
            'nip' => $this->faker->unique()->numerify('1987########'),
            'jabatan_id' => $jabatan?->id ?? null,
            'email' => $this->faker->unique()->safeEmail(),
            'no_telepon' => $this->faker->phoneNumber(),
        ];
    }
}
