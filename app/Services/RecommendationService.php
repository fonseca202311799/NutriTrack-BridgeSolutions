<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\students;

class RecommendationService
{
    public function getForStudent(?students $student, int $perMeal = 1): array
    {
        $result = [
            'breakfast' => [], 'lunch' => [], 'dinner' => [], 'snack' => []
        ];

        if (!$student) {
            return $result;
        }

        $prefs = collect((array) ($student->dietary_preferences ?? []))
            ->map(fn($v) => strtolower((string)$v));
        $allergies = collect(explode(',', strtolower((string)($student->allergies ?? ''))))
            ->map(fn($s) => trim($s))->filter();
        $conditions = collect(explode(',', strtolower((string)($student->conditions ?? ''))))
            ->map(fn($s) => trim($s))->filter();

        $query = Recipe::query();

        // Conditions
        if ($conditions->contains(fn($c) => str_contains($c, 'diab'))) {
            $query->where(function($q){
                $q->where('is_diabetic_friendly', true)
                  ->orWhereJsonContains('tags', 'low-carb');
            });
        }

        // Preferences
        if ($prefs->contains('vegetarian')) { $query->where('is_vegetarian', true); }
        if ($prefs->contains('vegan')) { $query->where('is_vegan', true); }
        if ($prefs->contains('gluten-free')) { $query->where('is_gluten_free', true); }

        // Allergies exclusions
        if ($allergies->contains('nuts')) {
            $query->where(function($q){
                $q->whereNull('tags')->orWhereJsonDoesntContain('tags', 'nuts');
            });
        }

        // Simple BMI-based bias using latest status (if available)
        $status = optional($student->healthRecords()->latest('recorded_at')->first())->status;
        $recipes = $query->get();

        // Rank by heuristic
        $ranked = $recipes->sortByDesc(function($r) use ($status) {
            $score = 0;
            if ($status) {
                if (stripos($status, 'under') !== false) { // underweight
                    $score += ($r->calories >= 450 ? 2 : 0) + ($r->protein >= 20 ? 1 : 0);
                } elseif (stripos($status, 'over') !== false || stripos($status, 'obese') !== false) {
                    $score += ($r->calories <= 500 ? 2 : 0) + (in_array('low-carb', (array)$r->tags ?? []) ? 1 : 0);
                } else { // normal
                    $score += 1;
                }
            }
            // Student-friendly boosts based on tags
            $tags = array_map('strtolower', (array)($r->tags ?? []));
            if (in_array('student-friendly', $tags)) { $score += 3; }
            if (in_array('quick', $tags)) { $score += 2; }
            if (in_array('budget', $tags)) { $score += 2; }
            return $score;
        });

        foreach (['breakfast','lunch','dinner','snack'] as $meal) {
            $result[$meal] = $ranked->where('meal_type', $meal)->take($perMeal)->values()->all();
        }

        return $result;
    }
}
