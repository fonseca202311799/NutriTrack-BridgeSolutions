<?php

namespace App\Http\Controllers;

use App\Models\health_records;
use Illuminate\Http\Request;
use App\Models\students;
use Illuminate\Support\Facades\Auth;

class HealthRecordsController extends Controller
{
    public function index()
    {
        $records = health_records::with('student')->get();
        return view('health_records.index', compact('records'));
    }

    public function create()
    {
        // Optional: you can still show a dropdown for admins
        $students = students::all();
        return view('health_records.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'bmi' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'recorded_at' => 'nullable|date',
            'calories' => 'nullable|integer|min:0',
            'protein' => 'nullable|integer|min:0',
            'carbs' => 'nullable|integer|min:0',
            'fat' => 'nullable|integer|min:0',
        ]);

        // If student_id not provided (student self-logging), use the logged-in user's student record
        if (empty($validated['student_id'])) {
            $student = students::where('user_id', Auth::id())->first();
            if ($student) {
                $validated['student_id'] = $student->id;
            } else {
                // Cannot proceed without a valid student_id due to DB constraint
                if ($request->input('redirect_to') === 'dashboard') {
                    return redirect()->route('dashboard')->with('error', 'Your account is not linked to a student profile yet. Please contact the administrator.');
                }
                return back()->withErrors(['student_id' => 'Your account is not linked to a student profile.'])->withInput();
            }
        }

        // Default recorded_at to today if not set
        if (empty($validated['recorded_at'])) {
            $validated['recorded_at'] = now();
        }

        // Auto-calc BMI if height/weight present and bmi missing
        if (empty($validated['bmi']) && !empty($validated['height']) && !empty($validated['weight'])) {
            $h = (float) $validated['height']; // cm
            $w = (float) $validated['weight']; // kg
            if ($h > 0) {
                $m = $h / 100;
                $validated['bmi'] = round($w / ($m * $m), 1);
            }
        }

        health_records::create($validated);
        if ($request->input('redirect_to') === 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Intake saved successfully!');
        }
        return redirect()->route('health-records.index')->with('success', 'Health record added successfully!');
    }

    public function show(health_records $healthRecord)
    {
        $healthRecord->load('student');
        return view('health_records.show', compact('healthRecord'));
    }

    public function edit(health_records $healthRecord)
    {
        $students = students::all();
        return view('health_records.edit', compact('healthRecord', 'students'));
    }

    public function update(Request $request, health_records $healthRecord)
    {
        $validated = $request->validate([
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'bmi' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'recorded_at' => 'nullable|date',
            'calories' => 'nullable|integer|min:0',
            'protein' => 'nullable|integer|min:0',
            'carbs' => 'nullable|integer|min:0',
            'fat' => 'nullable|integer|min:0',
        ]);

        // Default recorded_at to today if not set
        if (empty($validated['recorded_at'])) {
            $validated['recorded_at'] = $healthRecord->recorded_at ?: now();
        }

        // Auto-calc BMI if height/weight present and bmi missing
        if (empty($validated['bmi']) && !empty($validated['height']) && !empty($validated['weight'])) {
            $h = (float) $validated['height']; // cm
            $w = (float) $validated['weight']; // kg
            if ($h > 0) {
                $m = $h / 100;
                $validated['bmi'] = round($w / ($m * $m), 1);
            }
        }

        $healthRecord->update($validated);
        return redirect()->route('health-records.index')->with('success', 'Health record updated successfully!');
    }

    public function destroy(health_records $healthRecord)
    {
        $healthRecord->delete();
        return redirect()->route('health-records.index')->with('success', 'Health record deleted successfully!');
    }
}
