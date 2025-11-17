<?php

namespace App\Http\Controllers;

use App\Models\students;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    { $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'student_id' => 'required|string|unique:students,student_id',
            'age' => 'nullable|integer|min:1',
            'sex' => 'nullable|string|max:10',
            'grade_level' => 'nullable|string|max:255',
        ]);

        students::create($validated);
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(students $students)
    {
        $students->load(['user', 'healthRecords', 'goals']);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(students $students)
    {
        $users = User::where('role', 'student')->get();
        return view('students.edit', compact('student', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, students $students)
    {
         $validated = $request->validate([
            'age' => 'nullable|integer|min:1',
            'sex' => 'nullable|string|max:10',
            'grade_level' => 'nullable|string|max:255',
        ]);

        $students->update($validated);
        if ($request->filled('redirect_to') && $request->input('redirect_to') === 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
        }
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(students $students)
    {
        $students->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
