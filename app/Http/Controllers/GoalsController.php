<?php

namespace App\Http\Controllers;

use App\Models\goals;
use Illuminate\Http\Request;
use App\Models\students;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
=======
>>>>>>> act2

class GoalsController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        return redirect()->route('dashboard');
=======
        $goals = goals::with('student')->get();
        return view('goals.index', compact('goals'));
>>>>>>> act2
    }

    public function create()
    {
<<<<<<< HEAD
        return redirect()->route('dashboard');
=======
        $students = students::all();
        return view('goals.create', compact('students'));
>>>>>>> act2
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'student_id' => 'nullable|exists:students,id',
=======
            'student_id' => 'required|exists:students,id',
>>>>>>> act2
            'goal_type' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'is_completed' => 'boolean',
        ]);

<<<<<<< HEAD
        if (empty($validated['student_id'])) {
            $student = students::firstOrCreate(
                ['user_id' => Auth::id()],
                ['student_id' => 'STU-' . Auth::id()]
            );
            $validated['student_id'] = $student->id;
        }

        goals::create($validated);
        return redirect()->route('dashboard')->with('success', 'Goal added successfully!');
=======
        goals::create($validated);
        return redirect()->route('goals.index')->with('success', 'Goal added successfully!');
>>>>>>> act2
    }

    public function edit(goals $goal)
    {
<<<<<<< HEAD
        return redirect()->route('dashboard');
=======
        $students = students::all();
        return view('goals.edit', compact('goal', 'students'));
>>>>>>> act2
    }

    public function update(Request $request, goals $goal)
    {
        $validated = $request->validate([
            'goal_type' => 'required|string|max:255',
            'target' => 'required|string|max:255',
            'is_completed' => 'boolean',
        ]);

        $goal->update($validated);
<<<<<<< HEAD
        return redirect()->route('dashboard')->with('success', 'Goal updated successfully!');
=======
        return redirect()->route('goals.index')->with('success', 'Goal updated successfully!');
>>>>>>> act2
    }

    public function destroy(goals $goal)
    {
        $goal->delete();
<<<<<<< HEAD
        return redirect()->route('dashboard')->with('success', 'Goal deleted successfully!');
=======
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully!');
>>>>>>> act2
    }
}
