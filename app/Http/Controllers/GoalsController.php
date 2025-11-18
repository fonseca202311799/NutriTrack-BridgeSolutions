<?php

namespace App\Http\Controllers;

use App\Models\goals;
use App\Models\GoalProgress;
use Illuminate\Http\Request;
use App\Models\students;

class GoalsController extends Controller
{
    public function index()
    {
        // No standalone goals index view in this app; return users to dashboard
        return redirect()->route('dashboard');
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
            'target_value' => 'nullable|integer|min:1',
            'target_unit' => 'nullable|string|max:32',
            'due_date' => 'nullable|date',
        ]);

        $goal = goals::create($validated);
        return back()
            ->with('success', 'Goal added successfully!')
            ->with('goal_added', true);
    }

    public function edit(goals $goal)
    {
        $students = students::all();
        return view('goals.edit', compact('goal', 'students'));
    }

    public function update(Request $request, goals $goal)
    {
        $validated = $request->validate([
            'goal_type' => 'sometimes|required|string|max:255',
            'target' => 'sometimes|required|string|max:255',
            'target_value' => 'nullable|integer|min:1',
            'target_unit' => 'nullable|string|max:32',
            'due_date' => 'nullable|date',
            'is_completed' => 'nullable|boolean',
            'add_progress' => 'nullable|integer|min:1',
        ]);

        // Increment progress if provided
        if (isset($validated['add_progress'])) {
            $increment = (int)$validated['add_progress'];
            $goal->current_value += $increment;
            // Auto complete if target reached
            if ($goal->target_value && $goal->current_value >= $goal->target_value) {
                $goal->is_completed = true;
            }
            $goal->save();
            GoalProgress::create([
                'goal_id' => $goal->id,
                'value' => $increment,
                'recorded_at' => now(),
            ]);
            return back()->with('success', 'Progress updated!');
        }

        $goal->update($validated);
        return back()->with('success', 'Goal updated successfully!');
    }

    public function destroy(goals $goal)
    {
        $goal->delete();
        return back()->with('success', 'Goal deleted successfully!');
    }
}
