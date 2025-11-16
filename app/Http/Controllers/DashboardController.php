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
        $user = auth::user();

        // Get student data linked to logged-in user
        $student = students::where('user_id', $user->id)->first();


        // Get health records if student exists
        $healthRecords = $student ? $student->healthRecords()->latest()->get() : collect();
        $goals = $student ? $student->goals()->latest()->get() : collect();
        // Latest tips (with author) for inline dashboard display
        $tips = Tip::with('user')->latest()->take(5)->get();

        // Aggregate stats for profile section
        $tipsAuthoredCount = Tip::where('created_by', $user->id)->count();
        $goalsCount = $goals->count();
        $completedGoalsCount = $goals->where('is_completed', true)->count();
        $latestHealth = $healthRecords->first();

        return view('dashboard', compact(
            'user',
            'student',
            'healthRecords',
            'goals',
            'tips',
            'tipsAuthoredCount',
            'goalsCount',
            'completedGoalsCount',
            'latestHealth'
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
