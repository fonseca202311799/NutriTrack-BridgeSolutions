<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = students::where('user_id', $user?->id)->first();
        $logs = $student ? Exercise::where('student_id', $student->id)->latest('recorded_at')->paginate(20) : collect();
        return view('exercises.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'duration_min' => 'required|integer|min:1',
            'recorded_at' => 'required|date',
        ]);
        $student = students::where('user_id', Auth::id())->first();
        if (!$student) {
            return back()->withErrors(['duration_min' => 'No student profile linked.'])->withInput();
        }
        $validated['student_id'] = $student->id;
        Exercise::create($validated);
        if ($request->input('redirect_to') === 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Exercise logged!');
        }
        return back()->with('success', 'Exercise logged!');
    }
}
