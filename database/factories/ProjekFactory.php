<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Projek>
 */
class ProjekFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_id' => fake()->randomNumber(),
            'nama_projek' => fake()->name(),
            'kode_unik' => fake()->randomNumber(),
            'status' => fake()->name(),
        ];
    }
}
