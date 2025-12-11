<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Health Report</title>
    <style>
        /* Footer at the very edge: reduce bottom margin */
        @page { margin: 16mm 12mm 12mm 12mm; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#000; font-size:12px; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .brand { display:flex; align-items:center; gap:8px; }
        .brand img { height:16px; }
        .conf { letter-spacing:1.2px; font-size:10px; color:#000; opacity:1; }
        .rule { border-top:2px solid #000; margin-top:6px; }
        h1 { font-size:18px; margin:8px 0 2px 0; color:#000; }
        .dates { color:#000; font-weight:600; font-size:11px; }
        .section { margin-top:6px; }
        .card { border:1px solid #000; border-radius:0; padding:6px; page-break-inside: avoid; }
        .grid { display:grid; grid-template-columns: repeat(2, 1fr); gap:4px; }
        .table { width:100%; border-collapse:collapse; font-size:10px; }
        .table th, .table td { border:1px solid #000; padding:3px 5px; }
        .table thead { display: table-header-group; }
        .table tfoot { display: table-footer-group; }
        .table tr { page-break-inside: avoid; }
        .table th { background:#eee; text-align:left; color:#000; }
        .num { text-align:right; }
        .pill { display:inline-block; background:#fff; color:#000; border:1px solid #000; border-radius:999px; padding:2px 6px; font-size:10px; }
        .muted { color:#333; }
        .mb-6 { margin-bottom:4px; }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size:10px;
            color:#000;
            display:flex;
            justify-content:space-between;
            line-height:1.4;
            padding: 6px 12mm;
            border-top: 1px solid #000;
            background: #fff;
            z-index: 999;
        }
    </style>
</head>
<body>
    @php($hasGd = extension_loaded('gd'))
    <div class="header">
        <div class="brand">
            @if($hasGd)
                <img src="{{ asset('images/small_logo.png') }}" alt="NutriTrack" />
            @else
                <svg viewBox="0 0 120 32" width="120" height="32" aria-label="NutriTrack" role="img">
                    <rect x="0" y="0" width="120" height="32" fill="#000" rx="4"/>
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

    <div class="footer">
        <span>Generated on {{ isset($generatedAt) ? $generatedAt->format('M d, Y h:i A') : now()->format('M d, Y h:i A') }}</span>
        <span>NutriTrack</span>
    </div>
</body>
</html>
