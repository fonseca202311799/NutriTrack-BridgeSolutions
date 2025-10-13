<?php

namespace App\Http\Controllers;

use App\Models\health_records;
use Illuminate\Http\Request;
use App\Models\students;

class HealthRecordsController extends Controller
{
    public function index()
    {
        $records = health_records::with('student')->get();
        return view('health_records.index', compact('records'));
    }

    public function create()
    {
        $students = students::all();
        return view('health_records.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'height' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1',
            'bmi' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'recorded_at' => 'nullable|date',
        ]);

        health_records::create($validated);
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
            'height' => 'required|numeric|min:1',
            'weight' => 'required|numeric|min:1',
            'bmi' => 'nullable|numeric',
            'status' => 'nullable|string|max:255',
            'recorded_at' => 'nullable|date',
        ]);

        $healthRecord->update($validated);
        return redirect()->route('health-records.index')->with('success', 'Health record updated successfully!');
    }

    public function destroy(health_records $healthRecord)
    {
        $healthRecord->delete();
        return redirect()->route('health-records.index')->with('success', 'Health record deleted successfully!');
    }
}
