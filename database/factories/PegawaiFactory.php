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
        return [
            'nip' => $this->faker->unique()->numerify('1987########'),
            'nama' => $this->faker->name(),
            'panggilan' => $this->faker->firstName(),
            'gelar_depan' => $this->faker->randomElement(['Ir.', 'Dr.', 'Prof.', 'Drs.', null]),
            'gelar_belakang' => $this->faker->optional()->suffix(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', null]),
            'jenis_kelamin' => $this->faker->randomElement([0, 1]),
            'profesi' => $this->faker->optional()->randomElement([1, 2, 3, 4, 5]),
            'smf' => $this->faker->optional()->randomElement([36, null]),
            'alamat' => $this->faker->address(),
            'rt' => str_pad($this->faker->randomDigit(), 3, '0', STR_PAD_LEFT),
            'rw' => str_pad($this->faker->randomDigit(), 3, '0', STR_PAD_LEFT),
            // Ensure kodepos fits the DB char(5) column: 5 digits only
            'kodepos' => (string) $this->faker->numberBetween(10000, 99999),
            'wilayah' => str_pad($this->faker->randomDigit(), 10, '0', STR_PAD_LEFT),
            'email' => $this->faker->unique()->safeEmail(),
            'tanggal' => now(),
            'non_pegawai' => $this->faker->randomElement([0, 1]),
            'status' => $this->faker->randomElement([1, 0]),
        ];
    }
}
