<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Oatmeal with Berries',
                'description' => 'High-fiber oats topped with fresh berries.',
                'meal_type' => 'breakfast',
                'calories' => 350, 'protein' => 12, 'carbs' => 55, 'fat' => 8,
                'tags' => ['high-fiber','vegetarian','low-fat'],
                'is_vegetarian' => true, 'is_vegan' => false, 'is_gluten_free' => false, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Greek Yogurt Parfait',
                'description' => 'Greek yogurt with granola and fruit.',
                'meal_type' => 'breakfast',
                'calories' => 300, 'protein' => 20, 'carbs' => 40, 'fat' => 6,
                'tags' => ['high-protein','vegetarian'],
                'is_vegetarian' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Grilled Chicken Salad',
                'description' => 'Lean chicken with mixed greens and vinaigrette.',
                'meal_type' => 'lunch',
                'calories' => 420, 'protein' => 35, 'carbs' => 22, 'fat' => 18,
                'tags' => ['high-protein','low-carb','gluten-free'],
                'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Quinoa Veggie Bowl',
                'description' => 'Quinoa, roasted veggies, chickpeas, tahini.',
                'meal_type' => 'lunch',
                'calories' => 500, 'protein' => 18, 'carbs' => 70, 'fat' => 15,
                'tags' => ['vegetarian','high-fiber'],
                'is_vegetarian' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Baked Salmon with Asparagus',
                'description' => 'Omega-3 rich salmon with greens.',
                'meal_type' => 'dinner',
                'calories' => 520, 'protein' => 40, 'carbs' => 10, 'fat' => 30,
                'tags' => ['keto','low-carb','gluten-free'],
                'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Turkey Chili',
                'description' => 'Lean turkey chili with beans.',
                'meal_type' => 'dinner',
                'calories' => 480, 'protein' => 35, 'carbs' => 45, 'fat' => 16,
                'tags' => ['high-protein','high-fiber','gluten-free'],
                'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Apple & Peanut Butter',
                'description' => 'Simple snack rich in fiber and protein.',
                'meal_type' => 'snack',
                'calories' => 220, 'protein' => 7, 'carbs' => 28, 'fat' => 9,
                'tags' => ['nuts'],
                'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Hummus with Veggies',
                'description' => 'Plant-based snack with fiber and protein.',
                'meal_type' => 'snack',
                'calories' => 200, 'protein' => 8, 'carbs' => 20, 'fat' => 10,
                'tags' => ['vegetarian','vegan','gluten-free'],
                'is_vegetarian' => true, 'is_vegan' => true, 'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
        ];

        foreach ($recipes as $r) {
            Recipe::create($r);
        }
    }
}
