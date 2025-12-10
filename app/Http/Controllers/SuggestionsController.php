<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\students;
use App\Models\health_records;
use App\Models\goals;
use App\Services\AiAssessmentService;

class SuggestionsController extends Controller
{
    public function apply(Request $request)
    {
        $student = students::where('user_id', Auth::id())->first();
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Create a student profile first.');
        }

        $svc = app(AiAssessmentService::class);
        $data = $svc->suggestIntakeAndGoal($student, [], true);
        $intake = $data['intake'] ?? [];
        $goal = $data['goal'] ?? [];

        // Save intake, including height/weight from latest record to satisfy non-null constraints
        $latest = $student->healthRecords()->latest('recorded_at')->first();
        $height = optional($latest)->height;
        $weight = optional($latest)->weight;
        $bmi = optional($latest)->bmi;
        $status = optional($latest)->status;
        health_records::create([
            'student_id' => $student->id,
            'height' => $height,
            'weight' => $weight,
            'bmi' => $bmi,
            'status' => $status,
            'calories' => $intake['calories'] ?? null,
            'protein' => $intake['protein'] ?? null,
            'carbs' => $intake['carbs'] ?? null,
            'fat' => $intake['fat'] ?? null,
            'recorded_at' => now(),
        ]);

        // Save goal if provided
        if (!empty($goal)) {
            goals::create([
                'student_id' => $student->id,
                'goal_type' => $goal['type'] ?? 'Water',
                'target' => $goal['target'] ?? null,
                'target_value' => $goal['target_value'] ?? null,
                'target_unit' => $goal['unit'] ?? null,
                'current_value' => 0,
                'is_completed' => 0,
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'AI suggestions applied: intake logged and goal added.')
            ->with('ai_assessment', $data['explanation'] ?? null);
    }
}
