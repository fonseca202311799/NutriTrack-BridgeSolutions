<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\students;
use App\Models\health_records;
use App\Models\WaterIntake;
use App\Models\Exercise;
use Dompdf\Dompdf;

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

        // Compute totals and averages for footer
        $daysCount = max(1, count($rows));
        $totals = [
            'calories' => array_sum(array_column($rows, 1)),
            'protein' => array_sum(array_column($rows, 2)),
            'carbs' => array_sum(array_column($rows, 3)),
            'fat' => array_sum(array_column($rows, 4)),
            'water_ml' => array_sum(array_column($rows, 5)),
            'exercise_min' => array_sum(array_column($rows, 6)),
        ];
        $averages = [
            'calories' => (int) round($totals['calories'] / $daysCount),
            'protein' => (int) round($totals['protein'] / $daysCount),
            'carbs' => (int) round($totals['carbs'] / $daysCount),
            'fat' => (int) round($totals['fat'] / $daysCount),
            'water_ml' => (int) round($totals['water_ml'] / $daysCount),
            'exercise_min' => (int) round($totals['exercise_min'] / $daysCount),
        ];

        $filename = 'health_report_' . now()->format('Ymd_His') . '.csv';
        return response()->streamDownload(function () use ($rows, $student, $start, $end, $totals, $averages) {
            $out = fopen('php://output', 'w');
            // Header block (metadata)
            fputcsv($out, ['NutriTrack Health Report']);
            fputcsv($out, ['Student', $student->name ?? (optional($student->user)->name ?? 'Unknown')]);
            fputcsv($out, ['Date Range', $start->toDateString().' to '.$end->toDateString()]);
            fputcsv($out, []);

            // Column headers
            fputcsv($out, ['date','calories','protein','carbs','fat','water_ml','exercise_min']);
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }

            // Footer block (totals and averages)
            fputcsv($out, []);
            fputcsv($out, ['Totals','', $totals['protein'], $totals['carbs'], $totals['fat'], $totals['water_ml'], $totals['exercise_min']]);
            // Place calories total under the calories column
            // Rewrite totals row ensuring correct positions
            fputcsv($out, ['Totals (corrected)', $totals['calories'], $totals['protein'], $totals['carbs'], $totals['fat'], $totals['water_ml'], $totals['exercise_min']]);
            fputcsv($out, ['Averages', $averages['calories'], $averages['protein'], $averages['carbs'], $averages['fat'], $averages['water_ml'], $averages['exercise_min']]);
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function healthPdf(Request $request)
    {
        $user = Auth::user();
        $student = students::where('user_id', $user->id)->first();
        abort_unless($student, 404);

        $tz = $request->query('tz', config('app.timezone'));
        try { \Carbon\CarbonTimeZone::create($tz); } catch (\Throwable $e) { $tz = config('app.timezone'); }
        $generatedAt = \Carbon\Carbon::now($tz);

        $end = now()->endOfDay();
        $start = now()->copy()->subDays(29)->startOfDay();

        // Build daily rows (reuse logic)
        $daily = collect();
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $day = $d->toDateString();
            $hr = health_records::where('student_id', $student->id)->whereDate('recorded_at', $day);
            $wi = WaterIntake::where('student_id', $student->id)->whereDate('recorded_at', $day);
            $ex = Exercise::where('student_id', $student->id)->whereDate('recorded_at', $day);
            $daily->push([
                'date' => $day,
                'calories' => (int)$hr->sum('calories'),
                'protein' => (int)$hr->sum('protein'),
                'carbs' => (int)$hr->sum('carbs'),
                'fat' => (int)$hr->sum('fat'),
                'water_ml' => (int)$wi->sum('amount_ml'),
                'exercise_min' => (int)$ex->sum('duration_min'),
            ]);
        }

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

        $viewData = [
            'student' => $student,
            'start' => $start,
            'end' => $end,
            'daily' => $daily,
            'totals' => $totals,
            'averages' => $averages,
            'latestRecord' => $latestRecord,
            'goalStats' => $goalStats,
            'generatedAt' => $generatedAt,
        ];
        $html = view('reports.health-pdf', $viewData)->render();
        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('chroot', public_path());
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $rawName = $user->name ?? 'User';
        $safeName = preg_replace('/[^A-Za-z0-9]+/', '', $rawName) ?: 'User';
        $filename = 'Health Report_' . $safeName . '.pdf';
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }
}
