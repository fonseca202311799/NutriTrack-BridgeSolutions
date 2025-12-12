<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Health Report</title>
    <style>
        /* Page setup */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            color:#000;
            font-size:12px;
            margin: 0;
            padding: 0;
        }

        /* Header - appears on every page */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 24mm;
            padding: 8mm 12mm 0 12mm;
            background: #fff;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand img {
            height: 16px;
        }

        .conf {
            letter-spacing: 1.2px;
            font-size: 10px;
            color: #000;
            opacity: 1;
        }

        .rule {
            border-top: 2px solid #000;
            margin-top: 6px;
        }

        /* Footer - appears on every page */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20mm;
            padding: 4mm 12mm;
            font-size: 10px;
            color: #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #000;
            background: #fff;
            z-index: 1000;
        }

        .page-number:after {
            content: counter(page) " of " counter(pages);
        }

        /* Content area - accounts for header and footer */
        .content {
            margin-top: 32mm;
            margin-bottom: 24mm;
            padding: 0 12mm;
        }

        h1 {
            font-size: 18px;
            margin: 8px 0 2px 0;
            color: #000;
        }

        .dates {
            color: #000;
            font-weight: 600;
            font-size: 11px;
        }

        .section {
            margin-top: 6px;
        }

        .card {
            border: 1px solid #000;
            border-radius: 0;
            padding: 6px;
            page-break-inside: avoid;
            margin-bottom: 6px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 3px 5px;
        }

        .table thead {
            display: table-header-group;
        }

        .table tr {
            page-break-inside: avoid;
        }

        .table th {
            background: #eee;
            text-align: left;
            color: #000;
        }

        .num {
            text-align: right;
        }

        .muted {
            color: #333;
        }
    </style>
</head>
<body>
    @php($hasGd = extension_loaded('gd'))

    <!-- Header - Fixed on all pages -->
    <div class="header">
        <div class="header-content">
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
    </div>

    <!-- Footer - Fixed on all pages -->
    <div class="footer">
        <span>Generated on {{ isset($generatedAt) ? $generatedAt->format('M d, Y h:i A') : now()->format('M d, Y h:i A') }}</span>
        <span class="page-number"></span>
        <span>NutriTrack</span>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1>Health Report</h1>
        <div class="dates">{{ $start->format('M d, Y') }} – {{ $end->format('M d, Y') }}</div>

        <div class="section card">
            <strong>Student</strong>
            <table class="table" style="margin-top:6px;">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ auth()->user()->name }}</td>
                    </tr>
                    <tr>
                        <td>Grade Level</td>
                        <td>{{ $student->grade_level ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td>{{ isset($student->age) ? intval($student->age) : '—' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section card">
            <strong>Latest Metrics</strong>
            @if($latestRecord)
                <table class="table" style="margin-top:6px;">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BMI</td>
                            <td class="num"><strong>{{ $latestRecord->bmi ?? '—' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><strong>{{ $latestRecord->status ?? '—' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Last Update</td>
                            <td><strong>{{ optional($latestRecord->recorded_at)->format('M d, Y') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="muted">No health records yet.</div>
            @endif
        </div>

        <div class="section card">
            <strong>30-Day Summary</strong>
            <table class="table" style="margin-top:6px;">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th class="num">Calories (kcal)</th>
                        <th class="num">Protein (g)</th>
                        <th class="num">Carbs (g)</th>
                        <th class="num">Fat (g)</th>
                        <th class="num">Water (ml)</th>
                        <th class="num">Exercise (min)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="num">{{ number_format($totals['calories']) }}</td>
                        <td class="num">{{ number_format($totals['protein']) }}</td>
                        <td class="num">{{ number_format($totals['carbs']) }}</td>
                        <td class="num">{{ number_format($totals['fat']) }}</td>
                        <td class="num">{{ number_format($totals['water_ml']) }}</td>
                        <td class="num">{{ number_format($totals['exercise_min']) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Average per day</strong></td>
                        <td class="num">{{ number_format($averages['calories']) }}</td>
                        <td class="num">{{ number_format($averages['protein']) }}</td>
                        <td class="num">{{ number_format($averages['carbs']) }}</td>
                        <td class="num">{{ number_format($averages['fat']) }}</td>
                        <td class="num">{{ number_format($averages['water_ml']) }}</td>
                        <td class="num">{{ number_format($averages['exercise_min']) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section card">
            <strong>Goals</strong>
            @php($percent = $goalStats['total'] ? round(($goalStats['completed'] / $goalStats['total']) * 100) : 0)
            <table class="table" style="margin-top:6px;">
                <thead>
                    <tr>
                        <th>Metric</th>
                        <th class="num">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total</td>
                        <td class="num">{{ $goalStats['total'] }}</td>
                    </tr>
                    <tr>
                        <td>Completed</td>
                        <td class="num">{{ $goalStats['completed'] }}</td>
                    </tr>
                    <tr>
                        <td>Completion Rate</td>
                        <td class="num">{{ $percent }}%</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section card" style="page-break-before: always; margin-top: 40mm;">
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
    </div>
</body>
</html>
