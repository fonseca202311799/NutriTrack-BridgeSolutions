<?php

namespace App\Http\Controllers;

use App\Models\dashboard;
use App\Models\health_records;
use Illuminate\Http\Request;
use App\Models\students;
use Illuminate\Support\Facades\Auth;
use App\Models\Tip;
use App\Models\WaterIntake;
use App\Models\Exercise;
use App\Services\RecommendationService;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Student linked to user
        $student = students::where('user_id', $user->id)->first();

        // Collections / defaults when missing
        $healthRecords = collect();
        $goals = collect();
        $nutritionToday = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
        ];
        $latestRecord = null;
        $goalStats = [
            'total' => 0,
            'completed' => 0,
        ];

        // Ensure hydration/exercise variables always exist (avoid undefined when student missing)
        $waterToday = 0;
        $recentWater = collect();
        $exerciseTodayMins = 0;
        $recentExercises = collect();

        if ($student) {
            // All health records ordered latest first
            $healthRecords = $student->healthRecords()->latest('recorded_at')->get();
            $goals = $student->goals()->with(['progress' => function($q){ $q->latest('recorded_at')->take(5); }])->latest()->get();
            $latestRecord = $healthRecords->first();

            // Today's nutrition aggregates
            $todayRecords = $student->healthRecords()
                ->whereDate('recorded_at', now()->toDateString())
                ->get();
            if ($todayRecords->isNotEmpty()) {
                $nutritionToday['calories'] = (int) $todayRecords->sum('calories');
                $nutritionToday['protein'] = (int) $todayRecords->sum('protein');
                $nutritionToday['carbs'] = (int) $todayRecords->sum('carbs');
                $nutritionToday['fat'] = (int) $todayRecords->sum('fat');
            }

            // Goal stats
            $goalStats['total'] = $goals->count();
            $goalStats['completed'] = $goals->where('is_completed', true)->count();

            // Hydration and Exercise summaries
            $waterToday = WaterIntake::where('student_id', $student->id)
                ->whereDate('recorded_at', now()->toDateString())
                ->sum('amount_ml');
            $recentWater = WaterIntake::where('student_id', $student->id)->latest('recorded_at')->take(5)->get();

            $exerciseTodayMins = Exercise::where('student_id', $student->id)
                ->whereDate('recorded_at', now()->toDateString())
                ->sum('duration_min');
            $recentExercises = Exercise::where('student_id', $student->id)->latest('recorded_at')->take(5)->get();
        }

        // Tips: students see only admin-sent tips (optionally personalized to them); admins see all
        $adminTipsQuery = Tip::with('user')->whereHas('user', function ($q) { $q->where('role', 'admin'); });
        if ($user->role === 'admin') {
            $tips = (clone $adminTipsQuery)->latest('created_at')->get();
        } else {
            if ($student) {
                if (Schema::hasColumn('tips', 'student_id')) {
                    $tips = (clone $adminTipsQuery)
                        ->where('student_id', $student->id)
                        ->latest('created_at')
                        ->get();
                } else {
                    // Column not present yet (migration not run); avoid crashing and show none
                    $tips = collect();
                }
            } else {
                // No student profile: only personalized tips are allowed (none)
                $tips = collect();
            }
        }

        // Smart recommendations
        $reco = app(RecommendationService::class)->getForStudent($student, 1);

        return view('dashboard', compact(
            'user',
            'student',
            'healthRecords',
            'goals',
            'tips',
            'nutritionToday',
            'latestRecord',
            'goalStats',
            'waterToday',
            'recentWater',
            'exerciseTodayMins',
            'recentExercises',
            'reco'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $r)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $r)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $r)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $r)
    {
        //
    }
}
