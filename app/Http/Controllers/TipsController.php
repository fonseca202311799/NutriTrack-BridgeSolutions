<?php

namespace App\Http\Controllers;

use App\Models\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipsController extends Controller
{
    public function index()
    {
        $tips = Tip::with('user')->get();
        return view('tips.index', compact('tips'));
    }

    public function create()
    {
        return view('tips.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:255',
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
