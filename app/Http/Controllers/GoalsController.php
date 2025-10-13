<?php

namespace App\Http\Controllers;

use App\Models\goals;
use Illuminate\Http\Request;
use App\Models\students;

class GoalsController extends Controller
{
    public function index()
    {
        $goals = goals::with('student')->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        $students = students::all();
        return view('goals.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'goal_type' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'is_completed' => 'boolean',
        ]);

        goals::create($validated);
        return redirect()->route('goals.index')->with('success', 'Goal added successfully!');
    }

    public function edit(goals $goal)
    {
        $students = students::all();
        return view('goals.edit', compact('goal', 'students'));
    }

    public function update(Request $request, goals $goal)
    {
        $validated = $request->validate([
            'goal_type' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'is_completed' => 'boolean',
        ]);

        $goal->update($validated);
        return redirect()->route('goals.index')->with('success', 'Goal updated successfully!');
    }

    public function destroy(goals $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully!');
    }
}
