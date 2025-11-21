<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $tips = Tip::with(['user', 'student'])->get();
        } else {
            $student = \App\Models\students::where('user_id', $user->id)->first();
            $tips = Tip::with(['user', 'student'])
                ->where(function($q) use ($student) {
                    $q->whereNull('student_id');
                    if ($student) $q->orWhere('student_id', $student->id);
                })->get();
        }
        return view('tips.index', compact('tips'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $students = \App\Models\students::with('user')->get();
        return view('tips.create', compact('students'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
            'student_id' => 'nullable|exists:students,id',
        ]);
        $validated['created_by'] = Auth::id();
        Tip::create($validated);
        return redirect()->route('tips.index')->with('success', 'Tip added successfully!');
    }

    public function show(Tip $tip)
    {
        $tip->load('user');
        return view('tips.show', compact('tip'));
    }

    public function edit(Tip $tip)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('tips.edit', compact('tip'));
    }

    public function update(Request $request, Tip $tip)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
        ]);

        $tip->update($validated);
        return redirect()->route('tips.index')->with('success', 'Tip updated successfully!');
    }

    public function destroy(Tip $tip)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403);
        }
        $tip->delete();
        return redirect()->route('tips.index')->with('success', 'Tip deleted successfully!');
    }
}
