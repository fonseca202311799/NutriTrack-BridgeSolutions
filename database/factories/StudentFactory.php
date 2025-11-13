<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create([
                'role' => 'student',
            ])->id,


            'student_id' => 'GC-' . strtoupper(fake()->bothify('####??')),


            'age' => fake()->numberBetween(16, 25),
            'sex' => fake()->randomElement(['Male', 'Female']),
            'grade_level' => fake()->randomElement([
                '1st Year',
                '2nd Year',
                '3rd Year',
                '4th Year',
            ]),
        ];
    }
}
