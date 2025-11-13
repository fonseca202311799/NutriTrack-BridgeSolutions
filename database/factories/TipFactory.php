<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Tip;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tip>
 */
class TipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Tip::class;
    public function definition(): array
    {

        $categories = ['Balanced Diet', 'Exercise', 'Hydration', 'Sleep', 'Mental Health', 'Hygiene', 'Regular Check-ups'];
        return [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->paragraph(3),
            'category' => $this->faker->randomElement($categories),
            'created_by' => null,
        ];

    }
}
