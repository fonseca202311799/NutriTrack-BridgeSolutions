<x-dashboard-layout>
<!-- Complete Goal Modal -->
<div id="completeGoalModal" class="modal" style="display:none;">
    <div class="modal-content" style="max-width:400px; text-align:center;">
        <span class="close" onclick="closeCompleteGoalModal()" style="position:absolute;top:10px;right:15px;font-size:1.5rem;cursor:pointer;">&times;</span>
        <h2 style="margin-top:0; color:#2a7d2e;">Complete Goal</h2>
        <p class="text" style="margin:12px 0;">Are you sure you want to mark this goal as completed?</p>
        <form id="completeGoalForm" method="POST" style="margin-top:16px;">
            @csrf
            @method('PATCH')
            <input type="hidden" name="is_completed" value="1">
            <button type="submit" class="btn-card" style="background:#4caf50;">Confirm Complete</button>
        </form>
    </div>
</div>

<script>
    function openCompleteGoalModal(goalId) {
        var modal = document.getElementById('completeGoalModal');
        var form = document.getElementById('completeGoalForm');
        var actionTemplate = "{{ route('goals.update', ['goal' => 'GOAL_ID_PLACEHOLDER']) }}";
        form.action = actionTemplate.replace('GOAL_ID_PLACEHOLDER', goalId);
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeCompleteGoalModal() {
        var modal = document.getElementById('completeGoalModal');
            <ul style="list-style:none; padding:0; margin:0; display:grid; grid-template-columns:repeat(auto-fit,minmax(90px,1fr)); gap:6px; font-size:.75rem;">
        document.body.style.overflow = '';
    }
    // Close modal on ESC
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') closeCompleteGoalModal();
    });
    // Close modal on click outside
    document.getElementById('completeGoalModal').onclick = function(e){
        if (e.target === this) closeCompleteGoalModal();
    };
</script>

<!-- Delete Goal Modal -->
<div id="deleteGoalModal" class="modal" style="display:none;">
    <div class="modal-content" style="max-width:420px; text-align:center;">
        <span class="close" onclick="closeDeleteGoalModal()" style="position:absolute;top:10px;right:15px;font-size:1.5rem;cursor:pointer;">&times;</span>
        <h2 style="margin-top:0; color:#b71c1c;">Delete Goal</h2>
        <p class="text" style="margin:12px 0;">This action cannot be undone. Do you want to delete this goal?</p>
        <form id="deleteGoalForm" method="POST" style="margin-top:16px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-card" style="background:#b71c1c;">Confirm Delete</button>
        </form>
    </div>

</div>

<script>
    function openDeleteGoalModal(goalId) {
        var modal = document.getElementById('deleteGoalModal');
        var form = document.getElementById('deleteGoalForm');
        var actionTemplate = "{{ route('goals.destroy', ['goal' => 'GOAL_ID_PLACEHOLDER']) }}";
        form.action = actionTemplate.replace('GOAL_ID_PLACEHOLDER', goalId);
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeDeleteGoalModal() {
        var modal = document.getElementById('deleteGoalModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeDeleteGoalModal(); });
    document.getElementById('deleteGoalModal').onclick = function(e){ if(e.target===this) closeDeleteGoalModal(); };
</script>

    @if(session('login_success'))
        <div id="toast-login-success" style="position:fixed; top:20px; right:20px; z-index:2000; background:#2e7d32; color:#fff; padding:14px 18px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.2); font-weight:600; display:flex; align-items:center; gap:10px;">
            <span style="display:inline-block; background:#43b649; width:10px; height:10px; border-radius:50%;"></span>
            {{ session('login_success') }}
        </div>
        <script>
            setTimeout(function(){
                var t = document.getElementById('toast-login-success');
                if(t){ t.style.transition='opacity .5s'; t.style.opacity='0'; setTimeout(function(){ if(t && t.parentNode){ t.parentNode.removeChild(t);} }, 550); }
            }, 3000);
        </script>
    @endif

    @if(session('goal_added'))
        <div id="toast-goal-added" style="position:fixed; top:20px; right:20px; z-index:2000; background:#2e7d32; color:#fff; padding:14px 18px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.2); font-weight:600; display:flex; align-items:center; gap:10px;">
            <span style="display:inline-block; background:#43b649; width:10px; height:10px; border-radius:50%;"></span>
            {{ session('success') ?? 'Goal added successfully!' }}
        </div>
        <script>
            setTimeout(function(){
                var t = document.getElementById('toast-goal-added');
                if(t){ t.style.transition='opacity .5s'; t.style.opacity='0'; setTimeout(function(){ if(t && t.parentNode){ t.parentNode.removeChild(t);} }, 550); }
            }, 3000);
        </script>
    @endif

    <aside class="sidebar">
        <header class="sidebar-header">

            <img src="{{ asset('images/nutritrack(2).png') }}" alt="logo" class="image-logo" loading="lazy">
            <button class="toggler sidebar-toggler" aria-label="Toggle Sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
        </header>

        <nav class="sidebar-nav">
            <ul class="nav-list primary-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="dashboard" onclick="showSection('dashboard'); return false;">
                        <i class="fa-solid fa-table-columns" title="Dashboard"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>

                 <li class="nav-item">
                    <a href="#" class="nav-link" data-section="health" onclick="showSection('health'); return false;">
                        <i class="fa-regular fa-square-plus" title="Health"></i>
                        <span class="nav-label">Health</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="goals" onclick="showSection('goals'); return false;">
                        <i class="fa-solid fa-trophy" title="Goals"></i>
                        <span class="nav-label">Goals</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="tips" onclick="showSection('tips'); return false;">
                        <i class="fa-solid fa-chalkboard-user" title="Tips"></i>
                        <span class="nav-label">Tips</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="settings" onclick="showSection('settings'); return false;">
                        <i class="fa-solid fa-gear" title="Dashboard"></i>
                        <span class="nav-label">Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="terms" onclick="showSection('terms'); return false;">
                        <i class="fa-solid fa-file-contract" title="Terms"></i>
                        <span class="nav-label">Terms & Conditions</span>
                    </a>
                </li>
            </ul>

            <ul class="nav-list secondary-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-section="profile" onclick="showSection('profile'); return false;">
                        <i class="fa-solid fa-user" title="Profile"></i>
                        <span class="nav-label">Profile</span>
                    </a>
                </li>

                 <li class="nav-item">

                        <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                            @csrf
                            @if ($errors->any())
                                <div>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }} </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <button class="logout" type="button" title="Logout" onclick="openModal('logoutConfirmModal')"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button>
                        </form>

                </li>
            </ul>
        </nav>
    </aside>

    <div id="section-dashboard" class="dashboard-container offset" style="display:grid;">
        @if(session('ai_assessment'))
        <div class="card span-full" style="border-left:4px solid #2e7d32;">
            <h2 style="margin-top:0; color:#2e7d2e;">Welcome Insights</h2>
            <div class="text" style="white-space:pre-wrap; color:#333;">{{ session('ai_assessment') }}</div>
            <form method="POST" action="{{ route('assessment.regenerate') }}" style="margin-top:10px; display:flex; justify-content:flex-end;">
                @csrf
                <button type="submit" class="btn-card">Regenerate AI Insights</button>
            </form>
        </div>
        @endif
        <!-- Welcome Card -->
        <div class="card span-full welcome-card">
            <h2 style="margin-top:0;">Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text" style="margin:4px 0 0;">Glad to have you back. Track your progress and stay consistent today.</p>
            <div style="margin-top:10px; display:flex; gap:8px; flex-wrap:wrap;">
                <a class="btn-card" href="#" onclick="openModal('healthReportModal'); return false;">Health Report</a>
            </div>
        </div>
        <!-- Nutrition Today -->
        <div class="card nutrition-card" style="display:flex; flex-direction:column;">
            <h2 style="margin-bottom:6px;">Nutrition Today</h2>
            <p class="text" style="margin:0 0 6px; font-size:.8rem;">Aggregated intake recorded for {{ now()->format('M d, Y') }}</p>
            <ul style="list-style:none; padding:0; margin:0; display:grid; grid-template-columns:repeat(auto-fit,minmax(90px,1fr)); gap:6px;">
                <li style="background:#f8f9fa; padding:5px; border-radius:6px; text-align:center;">
                    <strong style="font-size:.95rem;">{{ $nutritionToday['calories'] }}</strong><br><small style="font-size:.7rem;">Calories</small>
                </li>
                <li style="background:#f8f9fa; padding:5px; border-radius:6px; text-align:center;">
                    <strong style="font-size:.95rem;">{{ $nutritionToday['protein'] }}</strong><br><small style="font-size:.7rem;">Protein (g)</small>
                </li>
                <li style="background:#f8f9fa; padding:5px; border-radius:6px; text-align:center;">
                    <strong style="font-size:.95rem;">{{ $nutritionToday['carbs'] }}</strong><br><small style="font-size:.7rem;">Carbs (g)</small>
                </li>
                <li style="background:#f8f9fa; padding:5px; border-radius:6px; text-align:center;">
                    <strong style="font-size:.95rem;">{{ $nutritionToday['fat'] }}</strong><br><small style="font-size:.7rem;">Fat (g)</small>
                </li>
            </ul>
            <!-- Macro Split Donut + Targets vs Actual -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(170px,1fr)); gap:8px; align-items:start; margin-top:8px;">
                <div style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                    <canvas id="macroChart" width="90" height="90"></canvas>
                    <div style="display:flex; gap:6px; font-size:.7rem; color:#555; flex-wrap:wrap; justify-content:center;">
                        <span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:7px;height:7px;background:#1e88e5;border-radius:2px;display:inline-block;"></span>Protein</span>
                        <span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:7px;height:7px;background:#43a047;border-radius:2px;display:inline-block;"></span>Carbs</span>
                        <span style="display:inline-flex; align-items:center; gap:4px;"><span style="width:7px;height:7px;background:#fb8c00;border-radius:2px;display:inline-block;"></span>Fat</span>
                    </div>
                </div>
                <div style="min-height:0;">
                    @php
                        $calTarget = (int)($dailyTargets['calories'] ?? 0);
                        $pTarget = (int)($dailyTargets['protein'] ?? 0);
                        $cTarget = (int)($dailyTargets['carbs'] ?? 0);
                        $fTarget = (int)($dailyTargets['fat'] ?? 0);
                        $pct = function($val, $target){ return $target > 0 ? min(100, round(($val/$target)*100)) : null; };
                        $bar = function($val, $target){
                            if ($target <= 0) return ['w'=>0,'bg'=>'#e0e0e0'];
                            $pct = ($val / $target) * 100;
                            $color = $pct <= 100 ? '#4caf50' : ($pct <= 120 ? '#f9a825' : '#c62828');
                            return ['w'=>min(100, round($pct)), 'bg'=>$color];
                        };
                        $calBar = $bar($nutritionToday['calories'], $calTarget);
                        $pBar = $bar($nutritionToday['protein'], $pTarget);
                        $cBar = $bar($nutritionToday['carbs'], $cTarget);
                        $fBar = $bar($nutritionToday['fat'], $fTarget);
                    @endphp
                    <div style="display:grid; gap:6px; padding-right:2px;">
                        <div>
                            <div style="display:flex; justify-content:space-between; font-size:.7rem; color:#555;">
                                <span>Calories</span>
                                <span>{{ $nutritionToday['calories'] }} / {{ $calTarget }} kcal</span>
                            </div>
                            <div style="background:#eee; height:7px; border-radius:6px; overflow:hidden;">
                                <div style="height:100%; width:{{ $calBar['w'] }}%; background:{{ $calBar['bg'] }};"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display:flex; justify-content:space-between; font-size:.7rem; color:#555;">
                                <span>Protein</span>
                                <span>{{ $nutritionToday['protein'] }} / {{ $pTarget }} g</span>
                            </div>
                            <div style="background:#eee; height:7px; border-radius:6px; overflow:hidden;">
                                <div style="height:100%; width:{{ $pBar['w'] }}%; background:{{ $pBar['bg'] }};"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display:flex; justify-content:space-between; font-size:.7rem; color:#555;">
                                <span>Carbs</span>
                                <span>{{ $nutritionToday['carbs'] }} / {{ $cTarget }} g</span>
                            </div>
                            <div style="background:#eee; height:7px; border-radius:6px; overflow:hidden;">
                                <div style="height:100%; width:{{ $cBar['w'] }}%; background:{{ $cBar['bg'] }};"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display:flex; justify-content:space-between; font-size:.7rem; color:#555;">
                                <span>Fat</span>
                                <span>{{ $nutritionToday['fat'] }} / {{ $fTarget }} g</span>
                            </div>
                            <div style="background:#eee; height:7px; border-radius:6px; overflow:hidden;">
                                <div style="height:100%; width:{{ $fBar['w'] }}%; background:{{ $fBar['bg'] }};"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-actions" style="margin-top:6px; display:flex; gap:6px; flex-wrap:wrap; padding-top:6px; border-top:1px solid #f1f1f1;">
                <button class="btn-card" type="button" style="flex:1 1 130px; min-width:110px; padding:6px 10px; font-size:.85rem;" onclick="openModal('addIntakeModal')">Add Intake</button>
                @if(isset($student))
                <form method="POST" action="{{ route('ai.suggest.apply') }}" style="display:inline-flex; flex:1 1 160px; min-width:130px;">
                    @csrf
                    <button class="btn-card" type="submit" style="width:100%; padding:6px 10px; font-size:.85rem;">Suggest Intake & Goal (AI)</button>
                </form>
                @endif
            </div>
        </div>

        <!-- Health Status -->
        <div class="card">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                <h2 style="margin:0;">Health Status</h2>
            </div>

            @if($latestRecord)
                @php
                    $bmi = $latestRecord->bmi;
                    $statusLabel = $latestRecord->status ?? null;
                    if (!$statusLabel && $bmi) {
                        if ($bmi < 18.5) $statusLabel = 'Underweight';
                        elseif ($bmi < 25) $statusLabel = 'Normal';
                        elseif ($bmi < 30) $statusLabel = 'Overweight';
                        else $statusLabel = 'Obese';
                    }
                    $color = '#9e9e9e';
                    if ($statusLabel === 'Underweight') $color = '#f57c00';
                    elseif ($statusLabel === 'Normal') $color = '#2e7d32';
                    elseif ($statusLabel === 'Overweight') $color = '#f9a825';
                    elseif ($statusLabel === 'Obese') $color = '#c62828';

                    // Percent positions for segments and marker based on BMI 16–40 range
                    $uwEnd = round(((18.5 - 16) / 24) * 100, 1);
                    $normalEnd = round(((25 - 16) / 24) * 100, 1);
                    $overEnd = round(((30 - 16) / 24) * 100, 1);
                    $marker = null;
                    if (!is_null($bmi)) {
                        $marker = max(0, min(100, round((($bmi - 16) / 24) * 100)));
                    }
                @endphp

                <div style="display:grid; grid-template-columns:1fr; gap:10px; margin-top:8px;">
                    <!-- BMI and Status Row -->
                    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div style="display:flex; align-items:baseline; gap:8px;">
                            <span style="font-size:1.8rem; font-weight:700; color:#2a2a2a;">{{ $bmi ?? '—' }}</span>
                            <small class="text" style="color:#666;">BMI</small>
                        </div>
                        <span class="badge" style="background:{{ $color }}; color:#fff; padding:4px 10px; border-radius:999px; font-size:.8rem;">{{ $statusLabel ?? 'No Status' }}</span>
                    </div>

                    <!-- BMI Scale -->
                    <div>
                        <div style="position:relative; height:12px; border-radius:8px; overflow:hidden; background: linear-gradient(to right,
                            #f57c00 0% {{ $uwEnd }}%,
                            #2e7d32 {{ $uwEnd }}% {{ $normalEnd }}%,
                            #f9a825 {{ $normalEnd }}% {{ $overEnd }}%,
                            #c62828 {{ $overEnd }}% 100%);">
                        </div>
                        @if(!is_null($marker))
                            <div style="position:relative; height:0;">
                                <div style="position:absolute; top:-9px; left:{{ $marker }}%; transform:translateX(-50%); width:0; height:0; border-left:6px solid transparent; border-right:6px solid transparent; border-top:10px solid {{ $color }};"></div>
                            </div>
                        @endif
                        <div style="display:flex; justify-content:space-between; font-size:.75rem; color:#777; margin-top:4px;">
                            <span>16</span>
                            <span>18.5</span>
                            <span>25</span>
                            <span>30</span>
                            <span>40</span>
                        </div>
                        <!-- BMI Legend -->
                        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:8px; font-size:.8rem; color:#555;">
                            <span style="display:inline-flex; align-items:center; gap:6px;">
                                <span aria-label="Underweight" title="Underweight" style="width:10px; height:10px; background:#f57c00; border-radius:2px; display:inline-block;"></span>
                                Underweight
                            </span>
                            <span style="display:inline-flex; align-items:center; gap:6px;">
                                <span aria-label="Normal" title="Normal" style="width:10px; height:10px; background:#2e7d32; border-radius:2px; display:inline-block;"></span>
                                Normal
                            </span>
                            <span style="display:inline-flex; align-items:center; gap:6px;">
                                <span aria-label="Overweight" title="Overweight" style="width:10px; height:10px; background:#f9a825; border-radius:2px; display:inline-block;"></span>
                                Overweight
                            </span>
                            <span style="display:inline-flex; align-items:center; gap:6px;">
                                <span aria-label="Obese" title="Obese" style="width:10px; height:10px; background:#c62828; border-radius:2px; display:inline-block;"></span>
                                Obese
                            </span>
                        </div>
                    </div>

                    <!-- Metrics Grid -->
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(140px,1fr)); gap:10px;">
                        <div style="background:#f8f9fa; padding:10px; border-radius:8px; display:flex; align-items:center; gap:8px;">
                            <i class="fa-solid fa-ruler" style="color:#607d8b;"></i>
                            <div>
                                <div style="font-size:.75rem; color:#607d8b;">Height</div>
                                <div style="font-weight:600;">{{ $latestRecord->height !== null ? $latestRecord->height.' cm' : '—' }}</div>
                            </div>
                        </div>
                        <div style="background:#f8f9fa; padding:10px; border-radius:8px; display:flex; align-items:center; gap:8px;">
                            <i class="fa-solid fa-weight-scale" style="color:#607d8b;"></i>
                            <div>
                                <div style="font-size:.75rem; color:#607d8b;">Weight</div>
                                <div style="font-weight:600;">{{ $latestRecord->weight !== null ? $latestRecord->weight.' kg' : '—' }}</div>
                            </div>
                        </div>
                        <div style="background:#f8f9fa; padding:10px; border-radius:8px; display:flex; align-items:center; gap:8px;">
                            <i class="fa-solid fa-calendar-day" style="color:#607d8b;"></i>
                            <div>
                                <div style="font-size:.75rem; color:#607d8b;">Last Update</div>
                                <div style="font-weight:600;">{{ optional($latestRecord->recorded_at)->format('M d, Y') ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text" style="margin:0;">No health records yet.</p>
            @endif
        </div>

        <!-- Goals Summary -->
        <div class="card goals-card">
            <h2>Goals Summary</h2>
            @php($percent = $goalStats['total'] ? round(($goalStats['completed'] / $goalStats['total']) * 100) : 0)
            <p class="text" style="margin:0;">Total Goals: <strong>{{ $goalStats['total'] }}</strong></p>
            <p class="text" style="margin:0;">Completed: <strong>{{ $goalStats['completed'] }}</strong></p>
            <div style="margin-top:8px; background:#eee; height:10px; border-radius:6px; overflow:hidden;">
                <div style="height:100%; width:{{ $percent }}%; background:#4caf50;"></div>
            </div>
            <p class="text" style="margin-top:6px;">Progress: <strong>{{ $percent }}%</strong></p>
            <div class="goals-chart-wrap" style="margin-top:8px; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px;">
                <div style="position:relative; width:80px; height:80px; margin:0 auto;">
                    <canvas id="goalsChart" width="80" height="80"></canvas>
                    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); font-weight:700; color:#2a7d2e; font-size:0.8rem;">{{ $percent }}%</div>
                </div>
                <div class="mini-legend" style="display:flex; align-items:center; gap:6px; flex-wrap:wrap; justify-content:center;">
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:0.75rem; color:#555;">
                        <span style="width:6px; height:6px; background:#4caf50; border-radius:50%; display:inline-block;"></span>
                    </span>
                    <span style="display:inline-flex; align-items:center; gap:4px; font-size:0.75rem; color:#555;">
                        <span style="width:6px; height:6px; background:#e0e0e0; border-radius:50%; display:inline-block;"></span>
                    </span>
                </div>
            </div>
        </div>



        <!-- Hydration -->
        <div class="card">
            <h2>Water</h2>
            <p class="text" style="margin:0;">Today: <strong>{{ ($waterToday ?? 0) }} ml</strong></p>
            @if(isset($recentWater) && $recentWater->isNotEmpty())
                <ul style="list-style:none; padding:0; margin-top:8px; text-align:left;">
                    @foreach($recentWater as $w)
                        <li style="padding:6px 0; border-bottom:1px solid #f1f1f1;">
                            {{ $w->recorded_at?->format('M d, H:i') }} — <strong>{{ $w->amount_ml }} ml</strong>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text" style="margin-top:8px;">No water logs yet.</p>
            @endif
            <form method="POST" action="{{ route('water-intakes.store') }}" class="quick-add" style="margin-top:12px; display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:8px;">
                @csrf
                <input type="number" name="amount_ml" class="form-control" placeholder="Amount (ml)" min="1">
                <input type="datetime-local" name="recorded_at" class="form-control">
                <input type="hidden" name="redirect_to" value="dashboard">
                <div class="form-actions" style="grid-column:1/-1; justify-content:flex-end;">
                    <button class="btn-card" type="submit">Add</button>
                </div>
            </form>
            @error('amount_ml')<p class="text" style="color:#b71c1c; margin-top:6px;">{{ $message }}</p>@enderror
        </div>

        <!-- Exercise -->
        <div class="card exercise-card">
            <h2>Exercise</h2>
            <p class="text" style="margin:0;">Today: <strong>{{ ($exerciseTodayMins ?? 0) }} min</strong></p>
            @if(isset($recentExercises) && $recentExercises->isNotEmpty())
                <ul style="list-style:none; padding:0; margin-top:8px; text-align:left;">
                    @foreach($recentExercises as $ex)
                        <li style="padding:6px 0; border-bottom:1px solid #f1f1f1;">
                            {{ $ex->recorded_at?->format('M d, H:i') }} — <strong>{{ ucfirst($ex->type) }}</strong> ({{ $ex->duration_min }} min)
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text" style="margin-top:8px;">No exercise logs yet.</p>
            @endif
            <form method="POST" action="{{ route('exercises.store') }}" class="quick-add" style="margin-top:12px; display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:8px;">
                @csrf
                <input type="text" name="type" class="form-control" placeholder="Type (e.g., Run)">
                <input type="number" name="duration_min" class="form-control" placeholder="Minutes" min="1">
                <input type="datetime-local" name="recorded_at" class="form-control">
                <input type="hidden" name="redirect_to" value="dashboard">
                <div class="form-actions" style="grid-column:1/-1; justify-content:flex-end;">
                    <button class="btn-card" type="submit">Add</button>
                </div>
            </form>
            @error('duration_min')<p class="text" style="color:#b71c1c; margin-top:6px;">{{ $message }}</p>@enderror
        </div>
    </div>

    <!-- Terms & Conditions Section -->
    <div id="section-terms" class="dashboard-container offset" style="display:none;">
        <div class="card span-full" style="width:100%; background:#fff;">
            @include('partials.terms_content')
        </div>
    </div>

        <!-- Health Section -->
        <div id="section-health" class="dashboard-container offset" style="display:none;">
            <div class="card span-full">
                <h2>Health</h2>
                <p class="text">Latest BMI:
                    @if(isset($latestRecord) && property_exists($latestRecord, 'bmi') && $latestRecord->bmi)
                        <strong>{{ $latestRecord->bmi }}</strong>
                    @else
                        —
                    @endif
                </p>

                <h3 style="margin-top:12px;">Add Daily Intake</h3>
                <form method="POST" action="{{ route('health-records.store') }}" class="daily-intake-form">
                    @csrf
                    <input type="hidden" name="redirect_to" value="dashboard">

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="calories">Calories (kcal)</label>
                            <input id="calories" type="number" name="calories" min="0" class="form-control" placeholder="e.g., 500" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="protein">Protein (g)</label>
                            <input id="protein" type="number" name="protein" min="0" class="form-control" placeholder="e.g., 25" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="carbs">Carbs (g)</label>
                            <input id="carbs" type="number" name="carbs" min="0" class="form-control" placeholder="e.g., 60" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="fat">Fat (g)</label>
                            <input id="fat" type="number" name="fat" min="0" class="form-control" placeholder="e.g., 15" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="recorded_at">Recorded at</label>
                            <input id="recorded_at" type="date" name="recorded_at" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top:12px;">
                        <button type="submit" class="btn-card">Save Intake</button>
                    </div>
                </form>
            </div>

            <!-- Water (Health Section) -->
            <div class="card health-tracker">
                <h2>Water</h2>
                <p class="text" style="margin:0;">Today: <strong>{{ ($waterToday ?? 0) }} ml</strong></p>
                @if(isset($recentWater) && $recentWater->isNotEmpty())
                    <ul style="list-style:none; padding:0; margin-top:8px; text-align:left;">
                        @foreach($recentWater as $w)
                            <li style="padding:6px 0; border-bottom:1px solid #f1f1f1;">
                                {{ $w->recorded_at?->format('M d, H:i') }} — <strong>{{ $w->amount_ml }} ml</strong>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text" style="margin-top:8px;">No water logs yet.</p>
                @endif
                <form method="POST" action="{{ route('water-intakes.store') }}" class="quick-add" style="margin-top:12px; display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:8px;">
                    @csrf
                    <input type="number" name="amount_ml" class="form-control" placeholder="Amount (ml)" min="1">
                    <input type="datetime-local" name="recorded_at" class="form-control">
                    <input type="hidden" name="redirect_to" value="dashboard">
                    <div class="form-actions" style="grid-column:1/-1; justify-content:flex-end;">
                        <button class="btn-card" type="submit">Add</button>
                    </div>
                </form>
                @error('amount_ml')<p class="text" style="color:#b71c1c; margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <!-- Exercise (Health Section) -->
            <div class="card exercise-card health-tracker">
                <h2>Exercise</h2>
                <p class="text" style="margin:0;">Today: <strong>{{ ($exerciseTodayMins ?? 0) }} min</strong></p>
                @if(isset($recentExercises) && $recentExercises->isNotEmpty())
                    <ul style="list-style:none; padding:0; margin-top:8px; text-align:left;">
                        @foreach($recentExercises as $ex)
                            <li style="padding:6px 0; border-bottom:1px solid #f1f1f1;">
                                {{ $ex->recorded_at?->format('M d, H:i') }} — <strong>{{ ucfirst($ex->type) }}</strong> ({{ $ex->duration_min }} min)
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text" style="margin-top:8px;">No exercise logs yet.</p>
                @endif
                <form method="POST" action="{{ route('exercises.store') }}" class="quick-add" style="margin-top:12px; display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:8px;">
                    @csrf
                    <input type="text" name="type" class="form-control" placeholder="Type (e.g., Run)">
                    <input type="number" name="duration_min" class="form-control" placeholder="Minutes" min="1">
                    <input type="datetime-local" name="recorded_at" class="form-control">
                    <input type="hidden" name="redirect_to" value="dashboard">
                    <div class="form-actions" style="grid-column:1/-1; justify-content:flex-end;">
                        <button class="btn-card" type="submit">Add</button>
                    </div>
                </form>
                @error('duration_min')<p class="text" style="color:#b71c1c; margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <!-- Recommendations (Health Section) -->
            <div class="card span-full">
                <h2>Smart Recommendations</h2>
                @if(!$student)
                    <p class="text">Create a student profile to get personalized suggestions.</p>
                @else
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:12px; margin-top:8px;">
                        @foreach(['breakfast','lunch','dinner','snack'] as $meal)
                            <div style="border:1px solid #eee; border-radius:8px; padding:12px;">
                                <h3 style="margin:0 0 6px 0; text-transform:capitalize;">{{ $meal }}</h3>
                                @php($items = $reco[$meal] ?? [])
                                @if(empty($items))
                                    <p class="text" style="margin:0; color:#666;">No suggestion available.</p>
                                @else
                                    @foreach($items as $r)
                                        <div style="margin-bottom:8px;">
                                            <strong>{{ $r['title'] ?? $r->title }}</strong>
                                            @php($desc = $r['description'] ?? $r->description)
                                            @if($desc)
                                                <p class="text" style="margin:4px 0; color:#555;">{{ $desc }}</p>
                                            @endif
                                            <small style="color:#666;">
                                                {{ ($r['calories'] ?? $r->calories) ? ($r['calories'] ?? $r->calories).' kcal' : '' }}
                                                @if(($r['protein'] ?? $r->protein) || ($r['carbs'] ?? $r->carbs) || ($r['fat'] ?? $r->fat))
                                                    • P:{{ $r['protein'] ?? $r->protein }}g C:{{ $r['carbs'] ?? $r->carbs }}g F:{{ $r['fat'] ?? $r->fat }}g
                                                @endif
                                            </small>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <p class="text" style="margin-top:8px; color:#666;">Based on BMI status, conditions and preferences (if set).</p>
                @endif
            </div>
        </div>

        <!-- Goals Section -->
        <div id="section-goals" class="dashboard-container offset" style="display:none;">
            <div class="card span-full">
                <h2>Goals</h2>
                @if(!$student)
                    <p class="text">Create a student profile first to set goals.</p>
                @else
                    <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end; margin-bottom:10px;">
                        <button type="button" class="btn-card" onclick="openModal('archivedGoalsModal')">Archived Goals</button>
                    </div>
                    @if($goals->isEmpty())
                        <p class="text" style="margin:0 0 12px 0;">No goals yet. Add one below.</p>
                    @else
                        <ul style="list-style:none; padding:0; margin:0; text-align:left;">
                            @foreach($goals as $goal)
                                @php($pct = $goal->percentage())
                                <li style="padding:12px 0; border-bottom:1px solid #f1f1f1; display:flex; flex-direction:column; gap:8px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                                        <span style="flex:1;">
                                            <strong>{{ ucfirst($goal->goal_type) }}</strong>
                                            <small style="color:#666">
                                                @if($goal->target_value)
                                                    — {{ $goal->current_value }} / {{ $goal->target_value }} {{ $goal->target_unit ?? '' }}
                                                @else
                                                    — target: {{ $goal->target }}
                                                @endif
                                            </small>
                                        </span>
                                        <span class="badge" style="background:{{ $goal->is_completed ? '#4caf50' : '#eee' }}; color:{{ $goal->is_completed ? '#fff' : '#333' }}; padding:4px 8px; border-radius:6px;">
                                            {{ $goal->is_completed ? 'Completed' : ($pct ? $pct.'%' : 'In progress') }}
                                        </span>
                                    </div>
                                    @if($goal->target_value)
                                        <div style="background:#eee; border-radius:6px; height:10px; overflow:hidden; position:relative;">
                                            <div style="background:#4caf50; width:{{ $pct }}%; height:100%; transition:width .4s;"></div>
                                        </div>
                                    @endif
                                    @if($goal->progress->isNotEmpty())
                                        <div style="display:flex; gap:6px; flex-wrap:wrap; font-size:0.75rem; color:#555;">
                                            @foreach($goal->progress as $p)
                                                <span style="background:#f5f5f5; padding:4px 6px; border-radius:4px;">+{{ $p->value }} {{ $goal->target_unit }} <small>{{ $p->recorded_at->format('m/d') }}</small></span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                        @if(!$goal->is_completed && $goal->target_value)
                                            <form method="POST" action="{{ route('goals.update', $goal) }}" style="display:flex; gap:6px; align-items:center;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="add_progress" min="1" class="form-control" placeholder="Progress" style="width:110px;">
                                                <button type="submit" class="btn-card">Log</button>
                                            </form>
                                        @endif
                                        @if(!$goal->is_completed)
                                            <button type="button" class="btn-card" style="background:#4caf50;" onclick="openCompleteGoalModal({{ $goal->id }})">Complete</button>
                                        @endif
                                        <button type="button" class="btn-card" style="background:#b71c1c;" onclick="openDeleteGoalModal({{ $goal->id }})">Delete</button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <!-- Inline Add Goal Form -->
                    <form method="POST" action="{{ route('goals.store') }}" style="margin-top:16px;">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:8px;">
                            <input type="text" name="goal_type" class="form-control" placeholder="Goal type (e.g., Water)" required>
                            <input type="text" name="target" class="form-control" placeholder="Target description" required>
                            <input type="number" name="target_value" class="form-control" min="1" placeholder="Target value (e.g., 2000)">
                            <input type="text" name="target_unit" class="form-control" placeholder="Unit (e.g., ml, min)">
                            <input type="date" name="due_date" class="form-control" placeholder="Due date">
                            <div class="form-actions" style="grid-column:1/-1; justify-content:flex-end; margin-top:4px;">
                                <button type="submit" class="btn-card">Add Goal</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- Tips Section -->
        <div id="section-tips" class="dashboard-container offset" style="display:none;">
            <div class="card span-full">
                <h2>Tips</h2>
                @if(isset($student))
                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-bottom:10px;">
                        <form method="POST" action="{{ route('ai.tips.generate') }}" style="display:inline;">
                            @csrf
                            <button class="btn-card" type="submit">Generate Tips (AI)</button>
                        </form>
                        <button class="btn-card" type="button" style="background:#b08900;" onclick="openModal('replaceTipsModal')">Replace Today’s Tips</button>
                    </div>
                @endif
                @if(isset($tips) && $tips->isNotEmpty())
                    <ul style="list-style:none; padding:0; margin:0;">
                        @foreach($tips as $tip)
                            <li style="padding:12px 0; border-top:1px solid #f1f1f1;">
                                <div style="display:flex;justify-content:space-between;align-items:start;gap:12px;">
                                    <div>
                                        <h3 style="margin:0 0 4px 0;">{{ $tip->title }}</h3>
                                        <p class="text" style="margin:0;color:#666;">
                                            @if($tip->category)
                                                <span class="badge" style="background:#eee;color:#333;padding:4px 8px;border-radius:6px;margin-right:8px;">{{ $tip->category }}</span>
                                            @endif
                                            @php($isAiTip = isset($student) && (int)($tip->student_id) === (int)($student->id) && optional($tip->user)->role !== 'admin')
                                            @if($isAiTip)
                                                <span class="badge" style="background:#2e7d32;color:#fff;padding:4px 8px;border-radius:6px;margin-right:8px;">AI</span>
                                            @endif
                                            @if($isAiTip)
                                                <small>AI • {{ $tip->created_at?->format('M d, Y') }}</small>
                                            @else
                                                <small>by {{ optional($tip->user)->name ?? 'Unknown' }} • {{ $tip->created_at?->format('M d, Y') }}</small>
                                            @endif
                                        </p>
                                    </div>
                                    <div style="display:flex;gap:8px;flex-shrink:0;">
                                        <button type="button" class="btn-card" onclick="openTipModal({
                                            id: '{{ $tip->id }}',
                                            title: `{{ addslashes($tip->title) }}`,
                                            category: `{{ addslashes($tip->category ?? '') }}`,
                                            author: `{{ addslashes(optional($tip->user)->name ?? 'Unknown') }}`,
                                            date: `{{ $tip->created_at?->format('M d, Y') }}`,
                                            content: `{{ addslashes($tip->content) }}`
                                        })">View</button>
                                        @if(auth()->user()->role === 'admin')
                                            <a class="btn-card" href="{{ route('tips.edit', $tip) }}">Edit</a>
                                            <form method="POST" action="{{ route('tips.destroy', $tip) }}" onsubmit="return confirm('Delete this tip?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-card" style="background:#b71c1c;">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <p class="text" style="margin-top:8px; white-space:pre-line;">{{ $tip->content }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text" style="margin:0;">No tips available yet. Please check back later.</p>
                @endif
            </div>
        </div>

        <!-- Settings Section -->
        <div id="section-settings" class="dashboard-container offset" style="display:none;">
            <div class="card span-full">
                <h2>Settings</h2>
                <p class="text">Customize your experience. More options coming soon.</p>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="section-profile" class="dashboard-container offset" style="display:none;">
            <div class="card span-full">
                <div style="display:flex; align-items:center; gap:18px; flex-wrap:wrap;">
                    <div style="width:70px; height:70px; border-radius:50%; background:#e8f5e9; display:flex; align-items:center; justify-content:center; font-size:1.8rem; font-weight:600; color:#2a7d2e; box-shadow:0 4px 8px rgba(0,0,0,.08);">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                    <div style="flex:1; min-width:240px;">
                        <h2 style="margin:0 0 4px 0;">Your Profile</h2>
                        <p class="text" style="margin:0; font-size:.85rem; color:#666;">Welcome back, <strong>{{ auth()->user()->name }}</strong>. Keep pushing toward your goals.</p>
                    </div>
                </div>
                <hr style="border:none; border-top:1px solid #f1f1f1; margin:18px 0;" />
                <div style="display:grid; grid-template-columns:1fr; gap:16px;">
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">NAME</strong>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px; word-break:break-all;">
                        <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">EMAIL</strong>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">ROLE</strong>
                        <span style="text-transform:capitalize;">{{ auth()->user()->role ?? 'student' }}</span>
                    </div>
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">JOINED</strong>
                        <span>{{ auth()->user()->created_at?->format('M d, Y') }}</span>
                    </div>
                    @if(isset($student))
                        <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">AGE</strong>
                            <span>{{ $student->age !== null ? (int)$student->age : '—' }}</span>
                        </div>
                        <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">SEX</strong>
                            <span>{{ $student->sex ?? '—' }}</span>
                        </div>
                        <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">GRADE LEVEL</strong>
                            <span>{{ $student->grade_level ?? '—' }}</span>
                        </div>
                        <div style="display:flex; gap:10px;">
                            <button type="button" class="btn-card" onclick="openModal('editStudentModal')">Edit Student Details</button>
                        </div>
                    @else
                        <form method="POST" action="{{ route('students.store') }}" style="display:flex; flex-direction:column; gap:12px; background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            @csrf
                            <input type="hidden" name="redirect_to" value="dashboard" />
                            <strong style="display:block; font-size:.85rem; letter-spacing:.5px; color:#2a7d2e;">CREATE STUDENT PROFILE</strong>
                            <div class="form-group">
                                <label class="form-label" for="new_birth_date">Birth Date</label>
                                <input id="new_birth_date" type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}" />
                                <small class="text" style="color:#666;">Age: <span id="new_age_preview">—</span></small>
                                @error('birth_date')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-grid" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:8px;">
                                <div class="form-group">
                                    <label class="form-label" for="new_height">Height (cm)</label>
                                    <input id="new_height" type="number" step="0.1" name="height" min="0" class="form-control" value="{{ old('height') }}" placeholder="e.g., 170" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="new_weight">Weight (kg)</label>
                                    <input id="new_weight" type="number" step="0.1" name="weight" min="0" class="form-control" value="{{ old('weight') }}" placeholder="e.g., 65" />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="new_bmi">BMI</label>
                                    <input id="new_bmi" type="number" step="0.1" class="form-control" placeholder="Auto-calculated" readonly />
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="new_status">Status</label>
                                    <input id="new_status" type="text" class="form-control" placeholder="Auto-calculated" readonly />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="new_sex">Sex</label>
                                <select id="new_sex" name="sex" class="form-control">
                                    <option value="" {{ old('sex') === null ? 'selected' : '' }}>Select...</option>
                                    <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('sex') === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('sex')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="new_grade">Grade Level</label>
                                <input id="new_grade" type="text" name="grade_level" class="form-control" value="{{ old('grade_level') }}" placeholder="e.g., Grade 10" />
                                @error('grade_level')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-actions" style="justify-content:flex-start;">
                                <button type="submit" class="btn-card">Create Profile</button>
                            </div>
                        </form>
                    @endif
                    @if(isset($latestRecord))
                        <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">LATEST BMI</strong>
                            <span>{{ $latestRecord->bmi ?? '—' }}</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    @if(isset($student))
    <div id="editStudentModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width:520px;">
            <span class="close" onclick="closeModal('editStudentModal')">&times;</span>
            <h2 style="margin-top:0; color:#2a7d2e;">Edit Student Details</h2>
            <form method="POST" action="{{ route('students.update', $student) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="redirect_to" value="dashboard" />
                <div class="form-group">
                    <label class="form-label" for="edit_birth_date">Birth Date</label>
                    <input id="edit_birth_date" type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($student->birth_date)->format('Y-m-d')) }}" />
                    <small class="text" style="color:#666;">Age: <span id="edit_age_preview">{{ $student->age ?? '—' }}</span></small>
                    @error('birth_date')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div class="form-grid" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:8px;">
                    <div class="form-group">
                        <label class="form-label" for="edit_height">Height (cm)</label>
                        <input id="edit_height" type="number" step="0.1" name="height" min="0" class="form-control" value="{{ old('height', optional($latestRecord)->height) }}" placeholder="e.g., 170" />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_weight">Weight (kg)</label>
                        <input id="edit_weight" type="number" step="0.1" name="weight" min="0" class="form-control" value="{{ old('weight', optional($latestRecord)->weight) }}" placeholder="e.g., 65" />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_bmi">BMI</label>
                        <input id="edit_bmi" type="number" step="0.1" class="form-control" value="{{ old('bmi', optional($latestRecord)->bmi) }}" placeholder="Auto-calculated" readonly />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_status">Status</label>
                        <input id="edit_status" type="text" class="form-control" value="{{ old('status', optional($latestRecord)->status) }}" placeholder="Auto-calculated" readonly />
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit_sex">Sex</label>
                    <select id="edit_sex" name="sex" class="form-control">
                        <option value="" {{ old('sex', $student->sex) === null ? 'selected' : '' }}>Select...</option>
                        <option value="male" {{ old('sex', strtolower((string)$student->sex)) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex', strtolower((string)$student->sex)) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('sex', strtolower((string)$student->sex)) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('sex')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit_grade">Grade Level</label>
                    <input id="edit_grade" type="text" name="grade_level" class="form-control" value="{{ old('grade_level', $student->grade_level) }}" placeholder="e.g., Grade 10" />
                    @error('grade_level')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div style="margin-top:16px; display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="btn-card" style="background:#6c757d;" onclick="closeModal('editStudentModal')">Cancel</button>
                    <button type="submit" class="btn-card">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Archived Goals Modal -->
    <div id="archivedGoalsModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width:720px; width:95%;">
            <span class="close" onclick="closeModal('archivedGoalsModal')">&times;</span>
            <h2 style="margin-top:0; color:#2a7d2e;">Archived Goals</h2>
            <p class="text" style="margin:6px 0 12px; color:#666;">Soft-deleted goals. Restore any item to bring it back.</p>

            <div style="background:#f9f9f9; border:1px solid #f1f1f1; border-radius:10px; overflow:hidden;">
                @isset($archivedGoals)
                    @if($archivedGoals->isEmpty())
                        <div style="padding:16px; text-align:center; color:#666;">No archived goals.</div>
                    @else
                        <div style="display:grid; grid-template-columns:1fr auto; gap:0;">
                            @foreach($archivedGoals as $g)
                                <div style="display:flex; flex-direction:column; gap:4px; padding:12px 14px; border-bottom:1px solid #f1f1f1;">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <strong style="color:#2a7d2e;">{{ ucfirst($g->goal_type) }}</strong>
                                        <span class="badge" style="background:#eee; color:#333; padding:2px 6px; border-radius:6px; font-size:.75rem;">Archived</span>
                                    </div>
                                    <div class="text" style="color:#555;">
                                        @if($g->target_value)
                                            {{ $g->current_value }} / {{ $g->target_value }} {{ $g->target_unit ?? '' }}
                                        @else
                                            target: {{ $g->target }}
                                        @endif
                                    </div>
                                    <small style="color:#888;">Archived: {{ optional($g->deleted_at)->format('M d, Y H:i') }}</small>
                                </div>
                                <div style="display:flex; align-items:center; justify-content:center; padding:12px 14px; border-bottom:1px solid #f1f1f1;">
                                    <form method="POST" action="{{ route('goals.restore', ['id' => $g->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn-card">Restore</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div style="padding:16px; text-align:center; color:#666;">No archive data available.</div>
                @endisset
            </div>

            <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" class="btn-card" style="background:#6c757d;" onclick="closeModal('archivedGoalsModal')">Close</button>
            </div>
        </div>
    </div>


    <!-- Add Intake Modal (moved outside list/condition so it always exists) -->
    <div id="addIntakeModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addIntakeModal')">&times;</span>
            <h2 style="margin-top:0;">Add Daily Intake</h2>
            <form method="POST" action="{{ route('health-records.store') }}" class="daily-intake-form">
                @csrf
                <input type="hidden" name="redirect_to" value="dashboard">

                <div class="form-grid">
                    <div>
                        <label class="form-label">Calories (kcal)</label>
                        <input type="number" name="calories" min="0" class="form-control" />
                        @error('calories')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Protein (g)</label>
                        <input type="number" name="protein" min="0" class="form-control" />
                    </div>
                    <div>
                        <label class="form-label">Carbs (g)</label>
                        <input type="number" name="carbs" min="0" class="form-control" />
                    </div>
                    <div>
                        <label class="form-label">Fat (g)</label>
                        <input type="number" name="fat" min="0" class="form-control" />
                    </div>
                    <div>
                        <label class="form-label">Recorded at</label>
                        <input id="modal_recorded_at" type="date" name="recorded_at" class="form-control" required />
                        @error('recorded_at')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="margin-top:16px;display:flex;gap:10px;justify-content:flex-end;">
                    <button type="button" class="btn-card" style="background:#6c757d;" onclick="closeModal('addIntakeModal')">Cancel</button>
                    <button type="submit" class="btn-card">Save Intake</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Health Report Modal -->
    <div id="healthReportModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width:1000px; width:95%; height:80vh; position:relative; display:flex; flex-direction:column;">
            <span class="close" onclick="closeModal('healthReportModal')">&times;</span>
            <div style="flex:1 1 auto; min-height:0;">
                <iframe id="healthReportFrame" src="{{ route('reports.health', ['embed' => 1, 'pdf' => 1]) }}" style="width:100%; height:100%; border:none; border-radius:8px; background:#fff;"></iframe>
            </div>
            <div style="margin-top:10px; display:flex; justify-content:flex-end; gap:8px;">
                <a class="btn-card" href="{{ route('reports.health.pdf') }}" target="_blank" rel="noopener">Download PDF</a>
                <button type="button" class="btn-card" onclick="printHealthReport()">Print PDF</button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutConfirmModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal('logoutConfirmModal')">&times;</span>
            <h2 style="margin-top:0;">Confirm Logout</h2>
            <p>Are you sure you want to log out?</p>
            <div style="margin-top:16px;display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" class="btn-card" style="background:#6c757d;" onclick="closeModal('logoutConfirmModal')">Cancel</button>
                <button type="button" class="btn-card" onclick="document.getElementById('logoutForm').submit();">Logout</button>
            </div>
        </div>
    </div>



    <script>
        // BMI helpers
        function getBMIStatus(bmi) {
            if (isNaN(bmi)) return '';
            if (bmi < 18.5) return 'Underweight';
            if (bmi < 25) return 'Normal';
            if (bmi < 30) return 'Overweight';
            return 'Obese';
        }

        function bindBMI(heightId, weightId, bmiId, statusId) {
            var h = document.getElementById(heightId);
            var w = document.getElementById(weightId);
            var b = document.getElementById(bmiId);
            var s = document.getElementById(statusId);
            if (!h || !w || !b || !s) return;

            function recalc() {
                var height = parseFloat(h.value);
                var weight = parseFloat(w.value);
                if (height > 0 && weight > 0) {
                    var m = height / 100;
                    var bmi = weight / (m * m);
                    var rounded = Math.round(bmi * 10) / 10;
                    b.value = rounded;
                    s.value = getBMIStatus(rounded);
                } else {
                    b.value = '';
                    s.value = '';
                }
            }

            h.addEventListener('input', recalc);
            w.addEventListener('input', recalc);
            // Initial calculation if values exist
            recalc();
        }

         function openModal(id) {
            var modal = document.getElementById(id);
            if (!modal) return;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            var modal = document.getElementById(id);
            if (!modal) return;
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        function printHealthReport(){
            try {
                var frame = document.getElementById('healthReportFrame');
                if (frame && frame.contentWindow) {
                    frame.contentWindow.focus();
                    frame.contentWindow.print();
                    return;
                }
            } catch(e) { /* fall through */ }
            // Fallback: open report in new window and trigger print
            var url = "{{ route('reports.health', ['embed' => 1, 'pdf' => 1]) }}";
            var w = window.open(url, '_blank');
            if (w) {
                var iv = setInterval(function(){
                    try {
                        if (w.document && w.document.readyState === 'complete') { w.focus(); w.print(); clearInterval(iv); }
                    } catch(e) {}
                }, 500);
            }
        }

        const sections = ['dashboard','health','goals','tips','settings','profile','terms'];
        function showSection(name) {
            sections.forEach(s => {
                const el = document.getElementById('section-' + s);
                if (el) el.style.display = (s === name) ? 'grid' : 'none';
            });
            document.querySelectorAll('.sidebar-nav .nav-link[data-section]').forEach(link => {
                if (link.dataset.section === name) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            showSection('dashboard');
            // Bind BMI auto-calc for profile forms
            bindBMI('new_height','new_weight','new_bmi','new_status');
            bindBMI('edit_height','edit_weight','edit_bmi','edit_status');
            // Default intake dates to today if empty
            try {
                var todayStr = new Date().toISOString().slice(0,10);
                var rec = document.getElementById('recorded_at');
                if (rec && !rec.value) rec.value = todayStr;
                var mrec = document.getElementById('modal_recorded_at');
                if (mrec && !mrec.value) mrec.value = todayStr;
            } catch(e) {}
            // Client-side intake validation: at least one macro > 0
            document.querySelectorAll('form.daily-intake-form').forEach(function(f){
                f.addEventListener('submit', function(ev){
                    var cal = parseInt(f.querySelector('[name="calories"]').value || '0', 10);
                    var p = parseInt(f.querySelector('[name="protein"]').value || '0', 10);
                    var c = parseInt(f.querySelector('[name="carbs"]').value || '0', 10);
                    var fat = parseInt(f.querySelector('[name="fat"]').value || '0', 10);
                    if ((cal + p + c + fat) === 0) {
                        ev.preventDefault();
                        alert('Provide at least one of calories, protein, carbs, or fat.');
                        var first = f.querySelector('[name="calories"]');
                        if (first) first.focus();
                    }
                });
            });
            // Macro donut chart
            (function(){
                var el = document.getElementById('macroChart');
                if (!el || !window.Chart) return;
                try {
                    var protein = {{ (int)$nutritionToday['protein'] }};
                    var carbs = {{ (int)$nutritionToday['carbs'] }};
                    var fat = {{ (int)$nutritionToday['fat'] }};
                    var total = Math.max(0, protein + carbs + fat);
                    if (total === 0) {
                        // render empty ring
                        new Chart(el, {
                            type: 'doughnut',
                            data: { datasets: [{ data: [1], backgroundColor:['#e0e0e0'], borderWidth:0 }]},
                            options: { plugins:{ legend:{display:false}}, cutout:'65%', responsive:false }
                        });
                        return;
                    }
                    new Chart(el, {
                        type: 'doughnut',
                        data: {
                            labels: ['Protein','Carbs','Fat'],
                            datasets: [{
                                data: [protein, carbs, fat],
                                backgroundColor: ['#1e88e5', '#43a047', '#fb8c00'],
                                borderWidth: 0
                            }]
                        },
                        options: { plugins:{ legend:{display:false}}, cutout:'65%', responsive:false }
                    });
                } catch(e) { /* noop */ }
            })();
            // Live age preview from DOB
            function computeAge(isoDate){
                if(!isoDate) return '';
                var dob = new Date(isoDate);
                if(isNaN(dob.getTime())) return '';
                var now = new Date();
                var diffMs = now - dob;
                var years = diffMs / (1000 * 60 * 60 * 24 * 365.2425);
                return Math.floor(years);
            }
            var newDob = document.getElementById('new_birth_date');
            var newAge = document.getElementById('new_age_preview');
            if(newDob && newAge){
                var updateNewAge = function(){ newAge.textContent = computeAge(newDob.value) || '—'; };
                newDob.addEventListener('input', updateNewAge);
                updateNewAge();
            }
            var editDob = document.getElementById('edit_birth_date');
            var editAge = document.getElementById('edit_age_preview');
            if(editDob && editAge){
                var updateEditAge = function(){ editAge.textContent = computeAge(editDob.value) || '—'; };
                editDob.addEventListener('input', updateEditAge);
                updateEditAge();
            }
            // Goals chart render
            var ctx = document.getElementById('goalsChart');
            if (ctx && window.Chart) {
                try {
                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Done', 'Left'],
                            datasets: [{
                                data: [{{ $goalStats['completed'] }}, {{ max(0, $goalStats['total'] - $goalStats['completed']) }}],
                                backgroundColor: ['#4caf50', '#e0e0e0'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function(ctx){
                                            const full = ctx.label === 'Done' ? 'Completed' : 'Remaining';
                                            return full + ': ' + ctx.parsed;
                                        }
                                    }
                                }
                            },
                            cutout: '65%'
                        }
                    });
                } catch (e) { /* noop */ }
            }
        });

        // Close modals with ESC
        document.addEventListener('keydown', function(e){
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal').forEach(function(modal){ modal.style.display = 'none'; });
                document.body.style.overflow = '';
            }
        });

        // Tip Modal logic
        function openTipModal(data) {
            var modal = document.getElementById('tipDetailModal');
            if(!modal) return;
            modal.querySelector('[data-tip-title]').textContent = data.title || 'Tip';
            var meta = [];
            if(data.category) meta.push(data.category);
            if(data.author) meta.push('by ' + data.author);
            if(data.date) meta.push(data.date);
            modal.querySelector('[data-tip-meta]').textContent = meta.join(' • ');
            modal.querySelector('[data-tip-content]').textContent = data.content || '';
            modal.style.display = 'flex';
        }
        function closeTipModal(){
            var modal = document.getElementById('tipDetailModal');
            if(modal) modal.style.display='none';
            document.body.style.overflow = '';
        }
    </script>



    <!-- Tip Detail Modal -->
    <div id="tipDetailModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width:700px; text-align:left;">
            <span class="close" onclick="closeTipModal()">&times;</span>
            <h2 data-tip-title style="margin-top:0; color:#2a7d2e;">Tip</h2>
            <p class="text" data-tip-meta style="margin:0 0 10px; font-size:0.85rem; color:#666;"></p>
            <div style="white-space:pre-line; color:#333;" data-tip-content></div>
            <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                <button class="btn-card" type="button" onclick="closeTipModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Replace Tips Confirmation Modal -->
    <div id="replaceTipsModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width:560px; text-align:left;">
            <span class="close" onclick="closeModal('replaceTipsModal')">&times;</span>
            <h2 style="margin-top:0; color:#2a7d2e;">Replace Today’s Tips</h2>
            <p class="text" style="margin:6px 0 0 0; color:#555;">
                This will delete the tips you generated today and create three new AI tips.
            </p>
            <p class="text" style="margin:6px 0 0 0; color:#777; font-size:.9rem;">
                Admin-sent tips are not affected.
            </p>
            <form method="POST" action="{{ route('ai.tips.replace') }}" style="margin-top:16px; display:flex; justify-content:flex-end; gap:10px;">
                @csrf
                <button type="button" class="btn-card" onclick="closeModal('replaceTipsModal')">Cancel</button>
                <button type="submit" class="btn-card" style="background:#b08900;">Replace Tips</button>
            </form>
        </div>
    </div>
</x-dashboard-layout>
