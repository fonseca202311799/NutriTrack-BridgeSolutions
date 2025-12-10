<?php

namespace App\Services;

use App\Models\students;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AiAssessmentService
{
    /**
     * Generate a brief assessment summary using AI when available,
     * otherwise fall back to a heuristic, human-readable summary.
     */
    public function generateAssessmentSummary(students $student, array $context = [], bool $force = false): string
    {
        // Daily cache per student
        $cacheKey = 'ai_assessment:' . ($student->id ?? 'unknown') . ':' . now()->format('Y-m-d');
        if (!$force && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_string($cached) && strlen($cached)) {
                return $cached;
            }
        }

        $latest = optional($student->healthRecords()->latest('recorded_at')->first());
        $height = $latest->height;
        $weight = $latest->weight;
        $bmi = $latest->bmi;
        $status = $latest->status;

        $activity = $context['activity_level'] ?? null;
        $prefs = trim((string)($context['preferences'] ?? ''));

        $prompt = "You are a helpful health assistant for students. Summarize the student's initial assessment in 3-5 concise bullet points. Mention BMI category in plain words, one actionable nutrition suggestion, and one lifestyle tip. Keep it supportive and positive.\n";
        $prompt .= "Data: height={$height}cm, weight={$weight}kg, bmi={$bmi}, status={$status}, activity={$activity}, preferences='{$prefs}'.";

        $apiKey = env('OPENAI_API_KEY');
        if ($apiKey) {
            try {
                $resp = Http::withToken($apiKey)
                    ->timeout(12)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4o-mini',
                        'messages' => [
                            ['role' => 'system', 'content' => 'You write supportive, practical, health summaries.'],
                            ['role' => 'user', 'content' => $prompt],
                        ],
                        'temperature' => 0.4,
                        'max_tokens' => 220,
                    ]);
                if ($resp->successful()) {
                    $text = data_get($resp->json(), 'choices.0.message.content');
                    if (is_string($text) && strlen(trim($text)) > 0) {
                        $summary = trim($text);
                        try { Cache::put($cacheKey, $summary, now()->endOfDay()); } catch (\Throwable $e) {}
                        return $summary;
                    }
                }
            } catch (\Throwable $e) {
                // fall back to heuristic below
            }
        }

        // Heuristic fallback
        $lines = [];
        if ($bmi) {
            $cat = 'Normal';
            if ($bmi < 18.5) $cat = 'Underweight';
            elseif ($bmi < 25) $cat = 'Normal';
            elseif ($bmi < 30) $cat = 'Overweight';
            else $cat = 'Obese';
            $lines[] = "BMI is $bmi ($cat) based on height and weight.";
        }
        if ($activity) {
            $lines[] = "Activity level: $activity — aim for consistent daily movement.";
        }
        if ($prefs) {
            $lines[] = "Preferences noted: $prefs.";
        }
        $lines[] = "Nutrition: focus on balanced meals with protein, veggies, and whole grains.";
        $lines[] = "Lifestyle: hydrate well and target 7–8 hours of sleep.";
        $fallback = '• '.implode("\n• ", $lines);
        try { Cache::put($cacheKey, $fallback, now()->endOfDay()); } catch (\Throwable $e) {}
        return $fallback;
    }

    /**
     * Suggest today's intake macros and a simple goal, using AI when available.
     * Returns an array: [ 'intake' => [...], 'goal' => [...], 'explanation' => string ]
     */
    public function suggestIntakeAndGoal(students $student, array $context = [], bool $force = false): array
    {
        $latest = optional($student->healthRecords()->latest('recorded_at')->first());
        $bmi = $latest->bmi; $status = $latest->status; $height = $latest->height; $weight = $latest->weight;
        $prefs = trim((string)($context['preferences'] ?? $student->preferences ?? ''));

        $cacheKey = 'ai_suggest:' . ($student->id ?? 'unknown') . ':' . now()->format('Y-m-d');
        if (!$force && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached)) return $cached;
        }

        $prompt = "Suggest a student's daily macro intake (calories, protein g, carbs g, fat g) and one simple health goal with target value and unit. Keep numbers realistic for a student. Return concise JSON only with keys intake(calories,protein,carbs,fat), goal(type,target_value,unit,target), and explanation. Context: BMI=$bmi, status=$status, height={$height}cm, weight={$weight}kg, preferences='$prefs'.";
        $apiKey = env('OPENAI_API_KEY');
        if ($apiKey) {
            try {
                $resp = Http::withToken($apiKey)->timeout(12)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Return ONLY valid JSON. No extra words.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 220,
                ]);
                if ($resp->successful()) {
                    $text = data_get($resp->json(), 'choices.0.message.content');
                    $parsed = json_decode((string)$text, true);
                    if (is_array($parsed) && isset($parsed['intake'], $parsed['goal'])) {
                        Cache::put($cacheKey, $parsed, now()->endOfDay());
                        return $parsed;
                    }
                }
            } catch (\Throwable $e) { /* fallback below */ }
        }

        // Fallback heuristic
        $cal = 1800; $p=80; $c=200; $f=60;
        if (is_numeric($bmi)) {
            if ($bmi < 18.5) { $cal = 2000; $p = 85; $c = 230; $f = 65; }
            elseif ($bmi < 25) { $cal = 1800; $p = 80; $c = 200; $f = 60; }
            elseif ($bmi < 30) { $cal = 1600; $p = 90; $c = 160; $f = 55; }
            else { $cal = 1500; $p = 95; $c = 140; $f = 50; }
        }
        $goal = [ 'type' => 'Water', 'target_value' => 2000, 'unit' => 'ml', 'target' => 'Drink water' ];
        $explanation = 'Set balanced macros for your status and add a hydration goal of 2000 ml.';
        $result = [ 'intake' => ['calories'=>$cal,'protein'=>$p,'carbs'=>$c,'fat'=>$f], 'goal' => $goal, 'explanation' => $explanation ];
        Cache::put($cacheKey, $result, now()->endOfDay());
        return $result;
    }

    /**
     * Generate AI-powered tips: returns an array of tip items with title, content, category.
     */
    public function generateTips(students $student, int $count = 4, bool $force = false): array
    {
        $latest = optional($student->healthRecords()->latest('recorded_at')->first());
        $bmi = $latest->bmi; $status = $latest->status; $height = $latest->height; $weight = $latest->weight;
        $prefs = trim((string)($student->preferences ?? ''));
        $cacheKey = 'ai_tips:' . ($student->id ?? 'unknown') . ':' . now()->format('Y-m-d') . ':' . $count;
        if (!$force && Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached)) return $cached;
        }

        $prompt = "Create ${count} concise health tips tailored to a student. Use their BMI/status and preferences. Each tip: title (<=50 chars), content (<=180 chars), category (Nutrition/Lifestyle/Mental/Exercise). Return ONLY JSON array of objects with keys title, content, category. Context: BMI=$bmi, status=$status, height=${height}cm, weight=${weight}kg, preferences='$prefs'.";
        $apiKey = env('OPENAI_API_KEY');
        if ($apiKey) {
            try {
                $resp = Http::withToken($apiKey)->timeout(12)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Return ONLY valid JSON. No preface or commentary.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.5,
                    'max_tokens' => 300,
                ]);
                if ($resp->successful()) {
                    $text = data_get($resp->json(), 'choices.0.message.content');
                    $parsed = json_decode((string)$text, true);
                    if (is_array($parsed) && count($parsed)) {
                        Cache::put($cacheKey, $parsed, now()->endOfDay());
                        return $parsed;
                    }
                }
            } catch (\Throwable $e) { /* fallback below */ }
        }

        // Fallback: simple tips based on status
        $tips = [];
        $cat = 'Nutrition';
        if (is_numeric($bmi)) {
            if ($bmi < 18.5) {
                $tips[] = ['title'=>'Boost Calories Smartly','content'=>'Add healthy snacks like nuts, yogurt, and whole-grain toast.','category'=>$cat];
            } elseif ($bmi < 25) {
                $tips[] = ['title'=>'Balance Your Plate','content'=>'Include protein, veggies, and whole grains in each meal.','category'=>$cat];
            } elseif ($bmi < 30) {
                $tips[] = ['title'=>'Cut Sugary Drinks','content'=>'Swap soda for water; try infused water with lemon or mint.','category'=>'Lifestyle'];
            } else {
                $tips[] = ['title'=>'Focus on Fiber','content'=>'Choose high-fiber foods to feel full longer and support weight goals.','category'=>$cat];
            }
        }
        $tips[] = ['title'=>'Move Daily','content'=>'Aim for 20–30 minutes of light exercise like walking or stretching.','category'=>'Exercise'];
        $tips[] = ['title'=>'Hydrate Well','content'=>'Keep a water bottle with you and sip regularly through the day.','category'=>'Lifestyle'];
        $tips[] = ['title'=>'Sleep Matters','content'=>'Target 7–8 hours nightly to recharge and support health.','category'=>'Mental'];

        Cache::put($cacheKey, $tips, now()->endOfDay());
        return $tips;
    }
}
