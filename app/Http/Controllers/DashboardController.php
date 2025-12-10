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
use App\Models\goals;

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

        // Simple default daily targets (can be made user-configurable later)
        $dailyTargets = [
            'calories' => 2000,
            'protein' => 75,
            'carbs' => 250,
            'fat' => 70,
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

            // Archived goals (soft-deleted)
            $archivedGoals = goals::onlyTrashed()
                ->where('student_id', $student->id)
                ->latest('deleted_at')
                ->get();
        }

        // Tips: admins see all; students see personalized tips (student_id) plus admin-sent tips
        if ($user->role === 'admin') {
            $tips = Tip::with('user')->latest('created_at')->get();
        } else {
            if ($student) {
                $tips = Tip::with('user')
                    ->where(function ($q) use ($student) {
                        $q->where('student_id', $student->id)
                          ->orWhereHas('user', function ($u) { $u->where('role', 'admin'); });
                    })
                    ->latest('created_at')
                    ->get();
            } else {
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
            'reco',
            'archivedGoals',
            'dailyTargets'
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
