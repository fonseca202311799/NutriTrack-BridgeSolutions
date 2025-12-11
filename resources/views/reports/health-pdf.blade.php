<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Health Report</title>
    <style>
        @page { margin: 22mm 15mm 18mm 15mm; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#0b1320; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .brand { display:flex; align-items:center; gap:8px; }
        .brand img { height:18px; }
        .conf { letter-spacing:1.5px; font-size:11px; color:#111; opacity:.85; }
        .rule { border-top:2px solid #0f5132; margin-top:6px; }
        h1 { font-size:22px; margin:10px 0 2px 0; color:#0f5132; }
        .dates { color:#0f5132; font-weight:600; font-size:12px; }
        .section { margin-top:14px; }
        .card { border:1px solid #e5e7eb; border-radius:6px; padding:10px; }
        .grid { display:grid; grid-template-columns: repeat(2, 1fr); gap:8px; }
        .table { width:100%; border-collapse:collapse; font-size:12px; }
        .table th, .table td { border:1px solid #e5e7eb; padding:6px 8px; }
        .table th { background:#f1f5f9; text-align:left; }
        .num { text-align:right; }
        .pill { display:inline-block; background:#e8f5e9; color:#0f5132; border:1px solid #cde7d3; border-radius:999px; padding:2px 8px; font-size:11px; }
        .muted { color:#64748b; }
        .mb-6 { margin-bottom:6px; }
    </style>
</head>
<body>
    @php($hasGd = extension_loaded('gd'))
    <div class="header">
        <div class="brand">
            @if($hasGd)
                <img src="{{ public_path('images/nutritrack(2).png') }}" alt="NutriTrack" />
            @else
                <svg viewBox="0 0 120 32" width="120" height="32" aria-label="NutriTrack" role="img">
                    <rect x="0" y="0" width="120" height="32" fill="#0f5132" rx="4"/>
                    <text x="60" y="21" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="14" fill="#ffffff">NutriTrack</text>
                </svg>
            @endif
        </div>
        <div class="conf">CONFIDENTIAL</div>
    </div>
    <div class="rule"></div>

    <h1>Health Report</h1>
    <div class="dates">{{ $start->format('M d, Y') }} – {{ $end->format('M d, Y') }}</div>

    <div class="section card">
        <strong>Student</strong>
        <div class="grid" style="margin-top:6px;">
            <div><span class="muted">Name:</span> {{ auth()->user()->name }}</div>
            <div><span class="muted">Grade Level:</span> {{ $student->grade_level ?? '—' }}</div>
            <div><span class="muted">Age:</span> {{ isset($student->age) ? intval($student->age) : '—' }}</div>
        </div>
    </div>

    <div class="section card">
        <strong>Latest Metrics</strong>
        @if($latestRecord)
            <div class="grid" style="margin-top:6px;">
                <div><span class="muted">BMI:</span> <strong>{{ $latestRecord->bmi ?? '—' }}</strong></div>
                <div><span class="muted">Status:</span> <strong>{{ $latestRecord->status ?? '—' }}</strong></div>
                <div><span class="muted">Last Update:</span> <strong>{{ optional($latestRecord->recorded_at)->format('M d, Y') }}</strong></div>
            </div>
        @else
            <div class="muted">No health records yet.</div>
        @endif
    </div>

    <div class="section card">
        <strong>30-Day Summary</strong>
        <div class="grid" style="margin-top:6px;">
            <div class="card"><div class="muted mb-6">Total Calories</div><div><strong>{{ number_format($totals['calories']) }} kcal</strong></div></div>
            <div class="card"><div class="muted mb-6">Total Protein</div><div><strong>{{ number_format($totals['protein']) }} g</strong></div></div>
            <div class="card"><div class="muted mb-6">Total Carbs</div><div><strong>{{ number_format($totals['carbs']) }} g</strong></div></div>
            <div class="card"><div class="muted mb-6">Total Fat</div><div><strong>{{ number_format($totals['fat']) }} g</strong></div></div>
            <div class="card"><div class="muted mb-6">Total Water</div><div><strong>{{ number_format($totals['water_ml']) }} ml</strong></div></div>
            <div class="card"><div class="muted mb-6">Total Exercise</div><div><strong>{{ number_format($totals['exercise_min']) }} min</strong></div></div>
        </div>
        <div class="grid" style="margin-top:6px;">
            <div class="card"><div class="muted mb-6">Avg Calories</div><div><strong>{{ number_format($averages['calories']) }} kcal/day</strong></div></div>
            <div class="card"><div class="muted mb-6">Avg Protein</div><div><strong>{{ number_format($averages['protein']) }} g/day</strong></div></div>
            <div class="card"><div class="muted mb-6">Avg Carbs</div><div><strong>{{ number_format($averages['carbs']) }} g/day</strong></div></div>
            <div class="card"><div class="muted mb-6">Avg Fat</div><div><strong>{{ number_format($averages['fat']) }} g/day</strong></div></div>
            <div class="card"><div class="muted mb-6">Avg Water</div><div><strong>{{ number_format($averages['water_ml']) }} ml/day</strong></div></div>
            <div class="card"><div class="muted mb-6">Avg Exercise</div><div><strong>{{ number_format($averages['exercise_min']) }} min/day</strong></div></div>
        </div>
    </div>

    <div class="section card">
        <strong>Goals</strong>
        @php($percent = $goalStats['total'] ? round(($goalStats['completed'] / $goalStats['total']) * 100) : 0)
        <div style="margin-top:6px; display:flex; gap:8px; flex-wrap:wrap;">
            <span class="pill">Total: {{ $goalStats['total'] }}</span>
            <span class="pill">Completed: {{ $goalStats['completed'] }}</span>
            <span class="pill">Rate: {{ $percent }}%</span>
        </div>
    </div>

    <div class="section card">
        <strong>Daily Detail (Last 30 Days)</strong>
        <table class="table" style="margin-top:6px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="num">Calories</th>
                    <th class="num">Protein (g)</th>
                    <th class="num">Carbs (g)</th>
                    <th class="num">Fat (g)</th>
                    <th class="num">Water (ml)</th>
                    <th class="num">Exercise (min)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daily as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}</td>
                    <td class="num">{{ number_format($row['calories']) }}</td>
                    <td class="num">{{ number_format($row['protein']) }}</td>
                    <td class="num">{{ number_format($row['carbs']) }}</td>
                    <td class="num">{{ number_format($row['fat']) }}</td>
                    <td class="num">{{ number_format($row['water_ml']) }}</td>
                    <td class="num">{{ number_format($row['exercise_min']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px; font-size:11px; color:#64748b; display:flex; justify-content:space-between;">
        <span>Generated on {{ now()->format('M d, Y h:i A') }}</span>
        <span>NutriTrack</span>
    </div>
</body>
</html>
