<?php

namespace App\Http\Controllers;

use App\Models\goals;
use App\Models\GoalProgress;
use Illuminate\Http\Request;
use App\Models\students;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;

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

        // If marking as completed, snap current_value to target_value (when defined)
        if (array_key_exists('is_completed', $validated) && (bool)$validated['is_completed'] === true) {
            if ($goal->target_value) {
                $goal->current_value = $goal->target_value;
            }
            $goal->is_completed = true;
            $goal->save();
            return back()->with('success', 'Goal marked as completed!');
        }

        $goal->update($validated);
        return back()->with('success', 'Goal updated successfully!');
    }

    public function destroy(goals $goal)
    {
        $goal->delete();
        return back()->with('success', 'Goal deleted successfully!');
    }

    public function restore($id)
    {
        $goal = goals::withTrashed()->findOrFail($id);
        $goal->restore();
        return Redirect::back()->with('success', 'Goal restored successfully!');
    }

    // Admin: list all students' goals for admin dashboard (JSON)
    public function adminList(): JsonResponse
    {
        $user = Auth::user();
        if (!$user || ($user->role ?? null) !== 'admin') {
            abort(403);
        }

        $items = goals::with(['student.user'])->latest('updated_at')->limit(200)->get()->map(function ($g) {
            return [
                'id' => $g->id,
                'student_id' => $g->student_id,
                'student_name' => optional(optional($g->student)->user)->name ?? 'Unknown',
                'goal_type' => $g->goal_type,
                'target' => $g->target,
                'target_value' => $g->target_value,
                'target_unit' => $g->target_unit,
                'current_value' => $g->current_value,
                'is_completed' => (bool)$g->is_completed,
                'due_date' => $g->due_date,
                'updated_at' => $g->updated_at,
            ];
        })->values();

        return response()->json([
            'data' => $items,
            'meta' => [
                'count' => $items->count(),
                'active' => $items->where('is_completed', false)->count(),
                'completed' => $items->where('is_completed', true)->count(),
            ],
        ]);
    }
}
