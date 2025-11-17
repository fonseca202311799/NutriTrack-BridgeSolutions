<?php

namespace App\Http\Controllers;

use App\Models\WaterIntake;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaterIntakeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = students::where('user_id', $user?->id)->first();
        $logs = $student ? WaterIntake::where('student_id', $student->id)->latest('recorded_at')->paginate(20) : collect();
        return view('water_intakes.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount_ml' => 'required|integer|min:1',
            'recorded_at' => 'required|date',
        ]);
        $student = students::where('user_id', Auth::id())->first();
        if (!$student) {
            return back()->withErrors(['amount_ml' => 'No student profile linked.'])->withInput();
        }
        $validated['student_id'] = $student->id;
        WaterIntake::create($validated);
        if ($request->input('redirect_to') === 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Water log added!');
        }
        return back()->with('success', 'Water log added!');
    }
}
