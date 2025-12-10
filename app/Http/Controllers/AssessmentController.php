<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use App\Models\students;
use App\Models\health_records;
use App\Services\AiAssessmentService;

class AssessmentController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('assessment', compact('user'));
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'birth_date' => 'required|date',
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'activity_level' => 'nullable|string|max:32',
            'preferences' => 'nullable|string|max:1000',
        ]);

        $student = students::where('user_id', Auth::id())->first();
        if (!$student) {
            do { $sid = 'STU-' . Str::upper(Str::random(6)); } while (students::where('student_id', $sid)->exists());
            $student = students::create([
                'user_id' => Auth::id(),
                'student_id' => $sid,
                'birth_date' => $data['birth_date'],
            ]);
        } else {
            $student->update(['birth_date' => $data['birth_date']]);
        }

        if (isset($data['preferences']) && Schema::hasColumn('students', 'preferences')) {
            $student->update(['preferences' => $data['preferences']]);
        }

        $record = [
            'student_id' => $student->id,
            'height' => $data['height'],
            'weight' => $data['weight'],
            'recorded_at' => now(),
        ];
        $h = (float)$data['height']; $w = (float)$data['weight'];
        if ($h > 0) { $m = $h/100; $record['bmi'] = round($w/($m*$m), 1); }
        $record['status'] = null;
        health_records::create($record);

        // Generate AI (or heuristic) assessment summary for a welcome insight
        $summary = app(AiAssessmentService::class)->generateAssessmentSummary($student, [
            'activity_level' => $data['activity_level'] ?? null,
            'preferences' => $data['preferences'] ?? null,
        ], true);

        return redirect()->route('dashboard')
            ->with('success', 'Assessment completed. Welcome!')
            ->with('ai_assessment', $summary);
    }

    // Regenerate AI insights on demand from latest student + health data
    public function regenerateInsights(Request $request)
    {
        $student = students::where('user_id', Auth::id())->first();
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Create a student profile first.');
        }

        $latest = $student->healthRecords()->latest('recorded_at')->first();
        if (!$latest) {
            return redirect()->route('dashboard')->with('error', 'No health data to generate insights.');
        }

        $summary = app(AiAssessmentService::class)->generateAssessmentSummary($student, [
            'activity_level' => null,
            'preferences' => $student->preferences ?? null,
        ], true);

        return redirect()->route('dashboard')->with('ai_assessment', $summary)->with('success', 'AI insights refreshed.');
    }
}
