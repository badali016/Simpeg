<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jabatan>
 */
class JabatanFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->jobTitle();
        return [
            'nama_jabatan' => $name,
            'kode_jabatan' => strtoupper($this->faker->bothify('JB-###')),
            'eselon' => $this->faker->randomElement(['I', 'II', 'III', 'IV', 'V']),
            'unit_kerja' => $this->faker->company(),
            'status' => $this->faker->randomElement(['Aktif', 'Tidak Aktif']),
        ];
    }
}
