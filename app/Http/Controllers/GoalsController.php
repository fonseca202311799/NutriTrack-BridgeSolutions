<?php

namespace App\Http\Controllers;

use App\Models\goals;
use Illuminate\Http\Request;
use App\Models\students;
use Illuminate\Support\Facades\Auth;

class GoalsController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function create()
    {
        return redirect()->route('dashboard');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'goal_type' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'is_completed' => 'boolean',
        ]);

        if (empty($validated['student_id'])) {
            $student = students::firstOrCreate(
                ['user_id' => Auth::id()],
                ['student_id' => 'STU-' . Auth::id()]
            );
            $validated['student_id'] = $student->id;
        }

        goals::create($validated);
        return redirect()->route('dashboard')->with('success', 'Goal added successfully!');
    }

    public function edit(goals $goal)
    {
        return redirect()->route('dashboard');
    }

    public function update(Request $request, goals $goal)
    {
        $validated = $request->validate([
            'goal_type' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'is_completed' => 'boolean',
        ]);

        $goal->update($validated);
        return redirect()->route('dashboard')->with('success', 'Goal updated successfully!');
    }

    public function destroy(goals $goal)
    {
        $goal->delete();
        return redirect()->route('dashboard')->with('success', 'Goal deleted successfully!');
    }
}
