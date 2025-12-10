<x-dashboard-layout>
    <div class="dashboard-container offset" style="display:grid;">
        <div class="card span-full report-header">
            <div class="report-header-row">
                <div>
                    <h2 class="report-title">Health Report</h2>
                    <p class="report-dates"><span class="date-pill">{{ $start->format('M d, Y') }} – {{ $end->format('M d, Y') }}</span></p>
                </div>
                <div class="report-actions">
                    <a class="btn-card" href="{{ route('reports.health.csv') }}">Download CSV</a>
                    <button class="btn-card" onclick="window.print()">Print / Save as PDF</button>
                </div>
            </div>
        </div>

        <div class="card span-full">
            <h3 style="margin-top:0;">Student</h3>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:10px;">
                <div><strong>Name:</strong> {{ auth()->user()->name }}</div>
                <div><strong>Grade Level:</strong> {{ $student->grade_level ?? '' }}</div>
                <div><strong>Age:</strong> {{ isset($student->age) ? intval($student->age) : '' }}</div>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top:0;">Latest Metrics</h3>
            @if($latestRecord)
                <p class="text" style="margin:0;">BMI: <strong>{{ $latestRecord->bmi ?? '—' }}</strong></p>
                <p class="text" style="margin:0;">Status: <strong>{{ $latestRecord->status ?? '—' }}</strong></p>
                <p class="text" style="margin:0;">Last Update: <strong>{{ optional($latestRecord->recorded_at)->format('M d, Y') }}</strong></p>
            @else
                <p class="text">No health records yet.</p>
            @endif
        </div>

        <div class="card">
            <h3 style="margin-top:0;">30-Day Summary</h3>
            <ul class="stat-grid">
                <li class="stat-card">
                    <span class="stat-label">Total Calories</span>
                    <span class="stat-value">{{ number_format($totals['calories']) }} kcal</span>
                </li>
                <li class="stat-card">
                    <span class="stat-label">Total Protein</span>
                    <span class="stat-value">{{ number_format($totals['protein']) }} g</span>
                </li>
                <li class="stat-card">
                    <span class="stat-label">Total Carbs</span>
                    <span class="stat-value">{{ number_format($totals['carbs']) }} g</span>
                </li>
                <li class="stat-card">
                    <span class="stat-label">Total Fat</span>
                    <span class="stat-value">{{ number_format($totals['fat']) }} g</span>
                </li>
                <li class="stat-card">
                    <span class="stat-label">Total Water</span>
                    <span class="stat-value">{{ number_format($totals['water_ml']) }} ml</span>
                </li>
                <li class="stat-card">
                    <span class="stat-label">Total Exercise</span>
                    <span class="stat-value">{{ number_format($totals['exercise_min']) }} min</span>
                </li>
            </ul>
            <h4 class="section-subtitle">Daily Averages</h4>
            <ul class="stat-grid alt">
                <li class="stat-card alt">
                    <span class="stat-label">Avg Calories</span>
                    <span class="stat-value">{{ number_format($averages['calories']) }} kcal/day</span>
                </li>
                <li class="stat-card alt">
                    <span class="stat-label">Avg Protein</span>
                    <span class="stat-value">{{ number_format($averages['protein']) }} g/day</span>
                </li>
                <li class="stat-card alt">
                    <span class="stat-label">Avg Carbs</span>
                    <span class="stat-value">{{ number_format($averages['carbs']) }} g/day</span>
                </li>
                <li class="stat-card alt">
                    <span class="stat-label">Avg Fat</span>
                    <span class="stat-value">{{ number_format($averages['fat']) }} g/day</span>
                </li>
                <li class="stat-card alt">
                    <span class="stat-label">Avg Water</span>
                    <span class="stat-value">{{ number_format($averages['water_ml']) }} ml/day</span>
                </li>
                <li class="stat-card alt">
                    <span class="stat-label">Avg Exercise</span>
                    <span class="stat-value">{{ number_format($averages['exercise_min']) }} min/day</span>
                </li>
            </ul>
        </div>

        <div class="card">
            <h3 style="margin-top:0;">Goals</h3>
            @php($percent = $goalStats['total'] ? round(($goalStats['completed'] / $goalStats['total']) * 100) : 0)
            <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                <span class="badge-pill">Total: {{ $goalStats['total'] }}</span>
                <span class="badge-pill success">Completed: {{ $goalStats['completed'] }}</span>
                <span class="badge-pill muted">Rate: {{ $percent }}%</span>
            </div>
            <div class="progress-wrap" aria-label="Goal completion">
                <div class="progress-bar" style="width: {{ $percent }}%"></div>
            </div>
        </div>

        <div class="card span-full">
            <h3 style="margin-top:0;">Daily Detail (Last 30 Days)</h3>
            <div class="table-wrap">
                <table class="report-table">
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
        </div>
    </div>

    <style>
        .report-header { padding:18px; background: linear-gradient(180deg, #f0fdf4 0%, #fff 100%); border:1px solid #e6f4ea; }
        .report-header-row { display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; }
        .report-title { margin:0; color:#1b5e20; letter-spacing:.2px; }
        .report-dates { margin:6px 0 0; color:#2e7d32; font-weight:600; }
        .date-pill { background:#e8f5e9; border:1px solid #cde7d3; padding:4px 8px; border-radius:999px; }
        .report-actions { display:flex; gap:8px; }

        .section-subtitle { margin:12px 0 6px; color:#275d2a; }
        .stat-grid { list-style:none; padding:0; margin:0; display:grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap:10px; }
        .stat-grid.alt { grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); }
        .stat-card { background:#f8fafc; border:1px solid #eef2f7; padding:12px; border-radius:10px; display:flex; flex-direction:column; gap:6px; }
        .stat-card.alt { background:#f1f5f9; }
        .stat-label { color:#475569; font-size:.85rem; }
        .stat-value { font-weight:700; color:#0f172a; }

        .badge-pill { display:inline-block; background:#eef2f7; color:#334155; border:1px solid #e2e8f0; padding:4px 10px; border-radius:999px; font-size:.85rem; }
        .badge-pill.success { background:#e8f5e9; color:#1b5e20; border-color:#cde7d3; }
        .badge-pill.muted { background:#f6f6f6; color:#424242; border-color:#eee; }
        .progress-wrap { margin-top:10px; background:#eef2f7; border-radius:999px; height:10px; overflow:hidden; border:1px solid #e2e8f0; }
        .progress-bar { height:100%; background:#4caf50; }

        .table-wrap { overflow:auto; }
        .report-table { width:100%; border-collapse:separate; border-spacing:0; font-size:.92rem; border:1px solid #e5e7eb; border-radius:8px; overflow:hidden; }
        .report-table thead th { position:sticky; top:0; background:#f8f9fa; color:#334155; font-weight:700; text-align:left; padding:10px; border-bottom:1px solid #e5e7eb; }
        .report-table th.num, .report-table td.num { text-align:right; }
        .report-table tbody td { padding:10px; border-bottom:1px solid #f1f5f9; }
        .report-table tbody tr:nth-child(odd) { background:#fcfcfd; }
        .report-table tbody tr:hover { background:#f6fbf7; }

        @media print {
            .sidebar, .sidebar-header, .sidebar-nav, .toggler, .nav-list, .nav-item, .btn-card { display: none !important; }
            .dashboard-container { padding: 0 !important; }
            .card { box-shadow: none !important; border: 1px solid #dfe7e3; }
            .offset { margin-left: 0 !important; }
            .report-header { background:#fff !important; }
            .report-table thead th { position:static; }
        }
    </style>
</x-dashboard-layout>
