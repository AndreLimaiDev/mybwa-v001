<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Branch;
use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karyawan>
 */
class KaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        

        return [
            'user_id' => fake()->randomNumber(),
            'nama_karyawan' => fake()->name(),
            'jabatan_id' => fake()->randomNumber(),
            'hp' => fake()->phoneNumber(),
            'is_active' => fake()->boolean(),
            'branch_id' => fake()->randomNumber(),
        ];
    }
}
