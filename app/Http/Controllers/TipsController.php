<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AiAssessmentService;

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

    public function generate()
    {
        $user = Auth::user();
        $student = \App\Models\students::where('user_id', $user->id)->first();
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Create a student profile first to get AI tips.');
        }
        // Daily guard: one click per day that generates 3 tips
        $today = now()->toDateString();
        $alreadyToday = Tip::where('student_id', $student->id)
            ->where('created_by', $user->id)
            ->whereDate('created_at', $today)
            ->count();
        if ($alreadyToday >= 3) {
            return redirect()->route('dashboard')->with('error', 'You already generated today\'s tips. Try again tomorrow or ask to replace today\'s tips.');
        }
        $tips = app(AiAssessmentService::class)->generateTips($student, 3, true);

        // Normalize categories and lengths; avoid duplicates for today
        $allowed = ['Nutrition','Lifestyle','Mental','Exercise'];
        $today = now()->toDateString();
        foreach ($tips as $t) {
            $title = trim((string)($t['title'] ?? 'Tip'));
            $content = trim((string)($t['content'] ?? ''));
            $category = trim((string)($t['category'] ?? ''));

            if (strlen($title) > 50) { $title = mb_substr($title, 0, 50); }
            if (strlen($content) > 180) { $content = mb_substr($content, 0, 180); }
            if (!in_array($category, $allowed, true)) { $category = 'Lifestyle'; }

            $duplicate = Tip::where('student_id', $student->id)
                ->where('created_by', $user->id)
                ->whereDate('created_at', $today)
                ->where('title', $title)
                ->exists();
            if ($duplicate) { continue; }

            Tip::create([
                'title' => $title,
                'content' => $content,
                'category' => $category,
                'student_id' => $student->id,
                'created_by' => $user->id,
            ]);
        }
        return redirect()->route('dashboard')->with('success', 'AI tips generated for you!');
    }

    public function replaceToday()
    {
        $user = Auth::user();
        $student = \App\Models\students::where('user_id', $user->id)->first();
        if (!$student) {
            return redirect()->route('dashboard')->with('error', 'Create a student profile first to get AI tips.');
        }
        $today = now()->toDateString();
        // Delete today’s tips created by this user for this student
        Tip::where('student_id', $student->id)
            ->where('created_by', $user->id)
            ->whereDate('created_at', $today)
            ->delete();

        // After deletion, run the same generation flow
        return $this->generate();
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
