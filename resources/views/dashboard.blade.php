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
        modal.style.display = 'none';
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
        <!-- Welcome Card -->
        <div class="card span-full welcome-card">
            <h2 style="margin-top:0;">Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text" style="margin:4px 0 0;">Glad to have you back. Track your progress and stay consistent today.</p>
            <div style="margin-top:10px; display:flex; gap:8px; flex-wrap:wrap;">
                <a class="btn-card" href="#" onclick="openModal('healthReportModal'); return false;">Health Report</a>
            </div>
        </div>
        <!-- Nutrition Today -->
        <div class="card nutrition-card">
            <h2>Nutrition Today</h2>
            <p class="text" style="margin:0 0 10px;">Aggregated intake recorded for {{ now()->format('M d, Y') }}</p>
            <ul style="list-style:none; padding:0; margin:0; display:grid; grid-template-columns:repeat(auto-fit,minmax(110px,1fr)); gap:8px;">
                <li style="background:#f8f9fa; padding:8px; border-radius:6px; text-align:center;">
                    <strong>{{ $nutritionToday['calories'] }}</strong><br><small>Calories</small>
                </li>
                <li style="background:#f8f9fa; padding:8px; border-radius:6px; text-align:center;">
                    <strong>{{ $nutritionToday['protein'] }}</strong><br><small>Protein (g)</small>
                </li>
                <li style="background:#f8f9fa; padding:8px; border-radius:6px; text-align:center;">
                    <strong>{{ $nutritionToday['carbs'] }}</strong><br><small>Carbs (g)</small>
                </li>
                <li style="background:#f8f9fa; padding:8px; border-radius:6px; text-align:center;">
                    <strong>{{ $nutritionToday['fat'] }}</strong><br><small>Fat (g)</small>
                </li>
            </ul>
            <div class="card-actions" style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
                <button class="btn-card" type="button" onclick="openModal('addIntakeModal')">Add Intake</button>
            </div>
        </div>

        <!-- Health Status -->
        <div class="card">
            <h2>Health Status</h2>
            @if($latestRecord)
                <p class="text" style="margin:0;">BMI: <strong>{{ $latestRecord->bmi ?? '—' }}</strong></p>
                <p class="text" style="margin:0;">Status: <strong>{{ $latestRecord->status ?? '—' }}</strong></p>
                <p class="text" style="margin:0;">Height: <strong>{{ $latestRecord->height ?? '—' }} cm</strong></p>
                <p class="text" style="margin:0;">Weight: <strong>{{ $latestRecord->weight ?? '—' }} kg</strong></p>
                <p class="text" style="margin:0;">Last Update: <strong>{{ optional($latestRecord->recorded_at)->format('M d, Y') }}</strong></p>
            @else
                <p class="text">No health records yet.</p>
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
                <form method="POST" action="{{ route('health-records.store') }}">
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
                            <input id="recorded_at" type="date" name="recorded_at" class="form-control" />
                        </div>
                    </div>

                    <div class="form-grid" style="margin-top:12px;">
                        <div class="form-group">
                            <label class="form-label" for="height">Height (cm)</label>
                            <input id="height" type="number" step="0.1" name="height" min="0" class="form-control" placeholder="e.g., 170" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="weight">Weight (kg)</label>
                            <input id="weight" type="number" step="0.1" name="weight" min="0" class="form-control" placeholder="e.g., 65" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="bmi">BMI</label>
                            <input id="bmi" type="number" step="0.1" name="bmi" min="0" class="form-control" placeholder="Auto-calculated" readonly />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="status">Status</label>
                            <input id="status" type="text" name="status" class="form-control" placeholder="Auto-calculated" readonly />
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
                                            <small>by {{ optional($tip->user)->name ?? 'Unknown' }} • {{ $tip->created_at?->format('M d, Y') }}</small>
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
                            <span>{{ $student->age ?? '—' }}</span>
                        </div>
                        <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">SEX</strong>
                            <span>{{ $student->sex ?? '—' }}</span>
                        </div>
                        <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            <strong style="display:block; font-size:.75rem; letter-spacing:.5px; color:#2a7d2e;">GRADE LEVEL</strong>
                            <span>{{ $student->grade_level ?? '—' }}</span>
                        </div>
                        <form method="POST" action="{{ route('students.update', $student) }}" style="display:flex; flex-direction:column; gap:12px; background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="redirect_to" value="dashboard" />
                            <strong style="display:block; font-size:.85rem; letter-spacing:.5px; color:#2a7d2e;">EDIT STUDENT DETAILS</strong>
                            <div class="form-group">
                                <label class="form-label" for="profile_age">Age</label>
                                <input id="profile_age" type="number" min="1" name="age" class="form-control" value="{{ old('age', $student->age) }}" placeholder="e.g., 17" />
                                @error('age')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="profile_sex">Sex</label>
                                <select id="profile_sex" name="sex" class="form-control">
                                    <option value="" {{ old('sex', $student->sex) === null ? 'selected' : '' }}>Select...</option>
                                    <option value="male" {{ old('sex', strtolower((string)$student->sex)) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex', strtolower((string)$student->sex)) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('sex', strtolower((string)$student->sex)) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('sex')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="profile_grade">Grade Level</label>
                                <input id="profile_grade" type="text" name="grade_level" class="form-control" value="{{ old('grade_level', $student->grade_level) }}" placeholder="e.g., Grade 10" />
                                @error('grade_level')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                            </div>
                            <div class="form-actions" style="justify-content:flex-start;">
                                <button type="submit" class="btn-card">Save Changes</button>
                            </div>
                        </form>
                    @else
                        <form method="POST" action="{{ route('students.store') }}" style="display:flex; flex-direction:column; gap:12px; background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            @csrf
                            <input type="hidden" name="redirect_to" value="dashboard" />
                            <strong style="display:block; font-size:.85rem; letter-spacing:.5px; color:#2a7d2e;">CREATE STUDENT PROFILE</strong>
                            <div class="form-group">
                                <label class="form-label" for="new_age">Age</label>
                                <input id="new_age" type="number" min="1" name="age" class="form-control" value="{{ old('age') }}" placeholder="e.g., 17" />
                                @error('age')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
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


    <!-- Add Intake Modal (moved outside list/condition so it always exists) -->
    <div id="addIntakeModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addIntakeModal')">&times;</span>
            <h2 style="margin-top:0;">Add Daily Intake</h2>
            <form method="POST" action="{{ route('health-records.store') }}">
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
                        <input type="date" name="recorded_at" class="form-control" required />
                        @error('recorded_at')<p class="text" style="color:#b71c1c; margin-top:4px;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-top:12px;">
                    <div>
                        <label class="form-label">Height (cm)</label>
                        <input id="modal_height" type="number" step="0.1" name="height" min="0" class="form-control" />
                    </div>
                    <div>
                        <label class="form-label">Weight (kg)</label>
                        <input id="modal_weight" type="number" step="0.1" name="weight" min="0" class="form-control" />
                    </div>
                    <div>
                        <label class="form-label">BMI</label>
                        <input id="modal_bmi" type="number" step="0.1" name="bmi" min="0" class="form-control" placeholder="Auto-calculated" readonly />
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <input id="modal_status" type="text" name="status" class="form-control" placeholder="Auto-calculated" readonly />
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
        <div class="modal-content" style="max-width:1000px; width:95%; height:80vh;">
            <span class="close" onclick="closeModal('healthReportModal')">&times;</span>
            <iframe src="{{ route('reports.health', ['embed' => 1]) }}" style="width:100%; height:100%; border:none; border-radius:8px; background:#fff;"></iframe>
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

        const sections = ['dashboard','health','goals','tips','settings','profile'];
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
            // Bind BMI auto-calc on both forms
            bindBMI('height','weight','bmi','status');
            bindBMI('modal_height','modal_weight','modal_bmi','modal_status');
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
</x-dashboard-layout>
