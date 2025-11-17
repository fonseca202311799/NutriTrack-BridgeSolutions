<?php

namespace App\Http\Controllers;

use App\Models\dashboard;
use App\Models\health_records;
use Illuminate\Http\Request;
use App\Models\students;
use Illuminate\Support\Facades\Auth;
use App\Models\Tip;

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

        if ($student) {
            // All health records ordered latest first
            $healthRecords = $student->healthRecords()->latest('recorded_at')->get();
            $goals = $student->goals()->latest()->get();
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
        }

        // Tips: load full list with authors for dashboard Tips section
        $tips = Tip::with('user')->latest('created_at')->get();

        return view('dashboard', compact(
            'user',
            'student',
            'healthRecords',
            'goals',
            'tips',
            'nutritionToday',
            'latestRecord',
            'goalStats'
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
