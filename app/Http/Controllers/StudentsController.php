<?php

namespace App\Http\Controllers;

use App\Models\students;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $user = Auth::user();

    // Find the student record linked to this user
    $student = \App\Models\students::where('user_id', $user->id)->first();

    // Fetch all related health records for that student
    $healthRecords = $student ? $student->healthRecords()->latest()->get() : collect();

    return view('students.index', compact('user', 'student', 'healthRecords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'student')->doesntHave('student')->get();
        return view('students.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Self-service creation: only capture profile attributes; user & generated student_id are automatic
        $validated = $request->validate([
            'age' => 'nullable|integer|min:1',
            'sex' => 'nullable|string|max:10',
            'grade_level' => 'nullable|string|max:255',
        ]);

        // Generate a unique student identifier
        do {
            $generatedId = 'STU-' . Str::upper(Str::random(6));
        } while (students::where('student_id', $generatedId)->exists());

        $student = students::create([
            'user_id' => Auth::id(),
            'student_id' => $generatedId,
            'age' => $validated['age'] ?? null,
            'sex' => $validated['sex'] ?? null,
            'grade_level' => $validated['grade_level'] ?? null,
        ]);

        if ($request->filled('redirect_to') && $request->input('redirect_to') === 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Profile created successfully!');
        }

        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(students $student)
    {
        $student->load(['user', 'healthRecords', 'goals']);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(students $student)
    {
        $users = User::where('role', 'student')->get();
        return view('students.edit', compact('student', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, students $student)
    {
         $validated = $request->validate([
            'age' => 'nullable|integer|min:1',
            'sex' => 'nullable|string|max:10',
            'grade_level' => 'nullable|string|max:255',
        ]);

        $student->update($validated);
        if ($request->filled('redirect_to') && $request->input('redirect_to') === 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
        }
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(students $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
