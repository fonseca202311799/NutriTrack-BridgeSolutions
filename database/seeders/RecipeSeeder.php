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
                'title' => 'Banana Oat Pancakes',
                'description' => '3-ingredient pancakes (banana, egg, oats). Quick and kid-friendly.',
                'meal_type' => 'breakfast',
                'calories' => 320, 'protein' => 12, 'carbs' => 48, 'fat' => 8,
                'tags' => ['student-friendly','quick','vegetarian'],
                'is_vegetarian' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Greek Yogurt Parfait',
                'description' => 'Greek yogurt with fruit and a little granola. No-cook.',
                'meal_type' => 'breakfast',
                'calories' => 300, 'protein' => 20, 'carbs' => 40, 'fat' => 6,
                'tags' => ['high-protein','vegetarian','quick','student-friendly'],
                'is_vegetarian' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Chicken Rice Bowl',
                'description' => 'Steamed rice, grilled chicken, and veggies. Easy lunchbox.',
                'meal_type' => 'lunch',
                'calories' => 500, 'protein' => 32, 'carbs' => 65, 'fat' => 12,
                'tags' => ['high-protein','gluten-free','student-friendly','budget'],
                'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Egg Fried Rice (Veggie)',
                'description' => 'Leftover rice stir-fried with egg and mixed veggies.',
                'meal_type' => 'lunch',
                'calories' => 520, 'protein' => 20, 'carbs' => 70, 'fat' => 16,
                'tags' => ['student-friendly','quick','budget'],
                'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Baked Salmon & Rice',
                'description' => 'Simple oven-baked salmon with steamed rice and greens.',
                'meal_type' => 'dinner',
                'calories' => 520, 'protein' => 40, 'carbs' => 10, 'fat' => 30,
                'tags' => ['keto','low-carb','gluten-free','student-friendly'],
                'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'One-Pot Turkey Chili',
                'description' => 'Lean turkey & beans. Make ahead, reheat for dinner.',
                'meal_type' => 'dinner',
                'calories' => 480, 'protein' => 35, 'carbs' => 45, 'fat' => 16,
                'tags' => ['high-protein','high-fiber','gluten-free','budget','student-friendly'],
                'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Apple & Peanut Butter',
                'description' => 'Sliced apple with peanut butter. Quick study snack.',
                'meal_type' => 'snack',
                'calories' => 220, 'protein' => 7, 'carbs' => 28, 'fat' => 9,
                'tags' => ['nuts','quick','student-friendly'],
                'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Hummus with Veggies',
                'description' => 'Plant-based dip with sliced carrots/cucumbers.',
                'meal_type' => 'snack',
                'calories' => 200, 'protein' => 8, 'carbs' => 20, 'fat' => 10,
                'tags' => ['vegetarian','vegan','gluten-free','quick','student-friendly'],
                'is_vegetarian' => true, 'is_vegan' => true, 'is_gluten_free' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Tuna Sandwich (Whole Wheat)',
                'description' => 'Canned tuna with a little mayo, lettuce, whole-wheat bread.',
                'meal_type' => 'lunch',
                'calories' => 430, 'protein' => 28, 'carbs' => 45, 'fat' => 12,
                'tags' => ['quick','student-friendly','budget'],
                'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Fruit & Yogurt Smoothie',
                'description' => 'Blend yogurt + banana + berries. Sippable breakfast/snack.',
                'meal_type' => 'snack',
                'calories' => 250, 'protein' => 12, 'carbs' => 38, 'fat' => 4,
                'tags' => ['quick','vegetarian','student-friendly'],
                'is_vegetarian' => true, 'is_diabetic_friendly' => true,
            ],
            [
                'title' => 'Veggie Egg Muffins',
                'description' => 'Baked eggs with chopped veggies. Make once, eat all week.',
                'meal_type' => 'breakfast',
                'calories' => 280, 'protein' => 18, 'carbs' => 8, 'fat' => 18,
                'tags' => ['low-carb','quick','student-friendly'],
                'is_diabetic_friendly' => true,
            ],
        ];

        foreach ($recipes as $r) {
            // Update existing by title or create new to avoid duplicates
            Recipe::updateOrCreate(['title' => $r['title']], $r);
        }
    }
}
