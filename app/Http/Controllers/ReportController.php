<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\students;
use App\Models\health_records;
use App\Models\WaterIntake;
use App\Models\Exercise;

class ReportController extends Controller
{
    public function health(Request $request)
    {
        $user = Auth::user();
        $student = students::where('user_id', $user->id)->first();
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Create a student profile to generate a report.');
        }

        $end = now()->endOfDay();
        $start = now()->copy()->subDays(29)->startOfDay();

        $datePeriod = collect();
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $datePeriod->push($d->copy());
        }

        $daily = $datePeriod->map(function ($date) use ($student) {
            $day = $date->toDateString();
            $hr = health_records::where('student_id', $student->id)
                ->whereDate('recorded_at', $day);
            $wi = WaterIntake::where('student_id', $student->id)
                ->whereDate('recorded_at', $day);
            $ex = Exercise::where('student_id', $student->id)
                ->whereDate('recorded_at', $day);
            return [
                'date' => $day,
                'calories' => (int) $hr->sum('calories'),
                'protein' => (int) $hr->sum('protein'),
                'carbs' => (int) $hr->sum('carbs'),
                'fat' => (int) $hr->sum('fat'),
                'water_ml' => (int) $wi->sum('amount_ml'),
                'exercise_min' => (int) $ex->sum('duration_min'),
            ];
        });

        $totals = [
            'calories' => (int) $daily->sum('calories'),
            'protein' => (int) $daily->sum('protein'),
            'carbs' => (int) $daily->sum('carbs'),
            'fat' => (int) $daily->sum('fat'),
            'water_ml' => (int) $daily->sum('water_ml'),
            'exercise_min' => (int) $daily->sum('exercise_min'),
        ];
        $daysCount = max(1, $daily->count());
        $averages = [
            'calories' => (int) round($totals['calories'] / $daysCount),
            'protein' => (int) round($totals['protein'] / $daysCount),
            'carbs' => (int) round($totals['carbs'] / $daysCount),
            'fat' => (int) round($totals['fat'] / $daysCount),
            'water_ml' => (int) round($totals['water_ml'] / $daysCount),
            'exercise_min' => (int) round($totals['exercise_min'] / $daysCount),
        ];

        $latestRecord = $student->healthRecords()->latest('recorded_at')->first();
        $goals = $student->goals()->get();
        $goalStats = [
            'total' => $goals->count(),
            'completed' => $goals->where('is_completed', true)->count(),
        ];

        $view = $request->boolean('embed') ? 'reports.health-embed' : 'reports.health';
        return view($view, [
            'student' => $student,
            'start' => $start,
            'end' => $end,
            'daily' => $daily,
            'totals' => $totals,
            'averages' => $averages,
            'latestRecord' => $latestRecord,
            'goalStats' => $goalStats,
        ]);
    }

    public function healthCsv(Request $request): StreamedResponse
    {
        $user = Auth::user();
        $student = students::where('user_id', $user->id)->first();
        abort_unless($student, 404);

        $end = now()->endOfDay();
        $start = now()->copy()->subDays(29)->startOfDay();

        $rows = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $day = $d->toDateString();
            $hr = health_records::where('student_id', $student->id)
                ->whereDate('recorded_at', $day);
            $wi = WaterIntake::where('student_id', $student->id)
                ->whereDate('recorded_at', $day);
            $ex = Exercise::where('student_id', $student->id)
                ->whereDate('recorded_at', $day);
            $rows[] = [
                $day,
                (int) $hr->sum('calories'),
                (int) $hr->sum('protein'),
                (int) $hr->sum('carbs'),
                (int) $hr->sum('fat'),
                (int) $wi->sum('amount_ml'),
                (int) $ex->sum('duration_min'),
            ];
        }

        $filename = 'health_report_' . now()->format('Ymd_His') . '.csv';
        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['date','calories','protein','carbs','fat','water_ml','exercise_min']);
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
