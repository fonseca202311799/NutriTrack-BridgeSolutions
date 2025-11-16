<x-dashboard-layout>

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

    <div class="main" style="margin-left: 306px; padding: 20px;">
        <div id="welcome-banner" class="card" style="text-align:left; display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px;">
            <div>
                <h2 style="margin:0;">Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text" style="margin:6px 0 0 0;">Here’s your health summary for today.</p>
            </div>
        </div>
        @if (session('success'))
            <div id="toast-success" style="position:fixed; top:20px; right:20px; z-index:9999; background:#2e7d32; color:#fff; padding:12px 16px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function(){
                    var t = document.getElementById('toast-success');
                    if (t) { t.style.transition = 'opacity .4s'; t.style.opacity = '0'; setTimeout(function(){ if(t && t.parentNode) t.parentNode.removeChild(t); }, 400); }
                }, 2500);
            </script>
        @endif
        @if (session('error'))
            <div class="alert" style="background:#fdecea;color:#b71c1c;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                {{ session('error') }}
            </div>
        @endif

        @php
            $latestRecord = $healthRecords->first();
        @endphp

        <div id="section-dashboard" class="dashboard-container">
            <!-- Daily Calorie Intake -->
            <div class="card">
                <h2>Daily Calorie Intake</h2>
                @if(isset($latestRecord) && property_exists($latestRecord, 'calories'))
                    <p class="display">{{ number_format($latestRecord->calories) }} kcal</p>
                @else
                    <p class="display">— kcal</p>
                    <p class="text">No intake logged today.</p>
                @endif
                <button class="btn-card" type="button" onclick="openModal('addIntakeModal')">Add Intake</button>
            </div>

            <!-- Nutrient Breakdown -->
            <div class="card">
                <h2>Nutrient Breakdown</h2>
                @php
                    $protein = isset($latestRecord) && property_exists($latestRecord, 'protein') ? (int)$latestRecord->protein : 0;
                    $carbs = isset($latestRecord) && property_exists($latestRecord, 'carbs') ? (int)$latestRecord->carbs : 0;
                    $fat = isset($latestRecord) && property_exists($latestRecord, 'fat') ? (int)$latestRecord->fat : 0;
                    $total = max($protein + $carbs + $fat, 1);
                    $pPct = (int)round($protein / $total * 100);
                    $cPct = (int)round($carbs / $total * 100);
                    $fPct = 100 - $pPct - $cPct;
                @endphp
                <div class="progress" style="height: 10px; width: 100%; background: #eee; border-radius: 6px; overflow: hidden; display:flex;">
                    <div style="width: {{ $pPct }}%; background:#4caf50" title="Protein {{ $pPct }}%"></div>
                    <div style="width: {{ $cPct }}%; background:#ffc107" title="Carbs {{ $cPct }}%"></div>
                    <div style="width: {{ $fPct }}%; background:#ff7043" title="Fat {{ $fPct }}%"></div>
                </div>
                <p class="text" style="margin-top:8px;">
                    Protein {{ $pPct }}% • Carbs {{ $cPct }}% • Fat {{ $fPct }}%
                </p>
            </div>

            <!-- Health Goals (button opens modal) -->
            <div class="card">
                <h2>Health Goals</h2>
                <p class="text">View and update your health goals.</p>
                <button class="btn-card" type="button" onclick="openModal('manageGoalsModal')">Open Health Goals</button>
            </div>
        </div>

        <!-- Health Section -->
        <div id="section-health" class="dashboard-container" style="display:none;">
            <div class="card">
                <h2>Health</h2>
                <p class="text">Latest BMI:
                    @if(isset($latestRecord) && property_exists($latestRecord, 'bmi') && $latestRecord->bmi)
                        <strong>{{ $latestRecord->bmi }}</strong>
                    @else
                        —
                    @endif
                </p>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    <button class="btn-card" type="button" onclick="openModal('addIntakeModal')">Add Intake</button>
                </div>
            </div>
        </div>

        <!-- Goals Section -->
        <div id="section-goals" class="dashboard-container" style="display:none;">
            <div class="card">
                <h2>Goals</h2>
                @if($goals->isEmpty())
                    <p class="text">No goals yet. Set your first goal!</p>
                @else
                    <ul style="list-style:none; padding:0; margin:0; text-align:left;">
                        @foreach($goals as $goal)
                            <li style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #f1f1f1;">
                                <span>
                                    <strong>{{ ucfirst($goal->goal_type) }}</strong>
                                    <small style="color:#666"> — target: {{ $goal->target }}</small>
                                </span>
                                @if($goal->is_completed)
                                    <span class="badge" style="background:#4caf50; color:#fff; padding:4px 8px; border-radius:6px;">Completed</span>
                                @else
                                    <span class="badge" style="background:#eee; color:#333; padding:4px 8px; border-radius:6px;">In progress</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('goals.store') }}" style="margin-top:12px;">
                    @csrf
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:10px;align-items:end;">
                        <div>
                            <label class="form-label">Goal Type</label>
                            <input type="text" name="goal_type" class="form-control" placeholder="e.g., weight, calories" required />
                        </div>
                        <div>
                            <label class="form-label">Target</label>
                            <input type="text" name="target" class="form-control" placeholder="e.g., 70kg or 2000 kcal" required />
                        </div>
                        <div>
                            <button type="submit" class="btn-card" style="width:100%">Add Goal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tips Section (single parent card with description + diagram + list) -->
        <div id="section-tips" class="dashboard-container" style="display:none;">
            <div class="card" style="text-align:left;">
                <div style="margin-bottom:16px;">
                    <p class="text" style="margin:0 0 8px 0;font-size:15px;font-weight:500;">Nutrition and wellness tips curated for students.</p>
                    <h2 style="margin:0 0 12px 0;">Tips</h2>
                    @if(auth()->user()->role === 'admin')
                        <a class="btn-card" href="{{ route('tips.create') }}">Add Tip</a>
                    @endif
                </div>

                <div style="display:grid;gap:16px;">
                    @forelse($tips as $tip)
                        <div style="border:1px solid #f1f1f1;padding:12px 14px;border-radius:10px;display:flex;flex-direction:column;gap:6px;">
                            <div style="display:flex;justify-content:space-between;align-items:start;gap:12px;">
                                <div>
                                    <h3 style="margin:0 0 4px 0;font-size:16px;">{{ $tip->title }}</h3>
                                    <p class="text" style="margin:0;color:#666;font-size:12px;">
                                        @if($tip->category)
                                            <span class="badge" style="background:#eee;color:#333;padding:4px 8px;border-radius:6px;margin-right:8px;">{{ $tip->category }}</span>
                                        @endif
                                        <small>by {{ optional($tip->user)->name ?? 'Unknown' }}</small>
                                    </p>
                                </div>
                                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                    <button type="button" class="btn-card" style="padding:6px 10px;" onclick="openModal('tipModal-{{ $tip->id }}')">View</button>
                                    @if(auth()->user()->role === 'admin')
                                        <a class="btn-card" href="{{ route('tips.edit', $tip) }}" style="padding:6px 10px;">Edit</a>
                                        <form method="POST" action="{{ route('tips.destroy', $tip) }}" onsubmit="return confirm('Delete this tip?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-card" style="background:#b71c1c;padding:6px 10px;">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <p class="text" style="margin:0; white-space:pre-line;font-size:13px;">{{ \Illuminate\Support\Str::limit($tip->content, 300) }}</p>
                        </div>
                    @empty
                        <div style="border:1px solid #f1f1f1;padding:12px 14px;border-radius:10px;">
                            <p class="text" style="margin:0;">No tips available yet.</p>
                            @if(auth()->user()->role === 'admin')
                                <a class="btn-card" style="margin-top:10px;" href="{{ route('tips.create') }}">Create Tip</a>
                            @endif
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Settings Section -->
        <div id="section-settings" class="dashboard-container" style="display:none;">
            <div class="card">
                <h2>Settings</h2>
                <p class="text">Customize your experience. More options coming soon.</p>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="section-profile" class="dashboard-container" style="display:none;">
            <div class="card">
                <h2 style="margin-top:0;">Profile</h2>
                @if($student)
                <form method="POST" action="{{ route('students.update', $student) }}" style="display:flex;flex-direction:column;gap:10px;text-align:left;">
                    @csrf
                    @method('PUT')
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Name:</span>
                        <span style="font-weight:600;">{{ auth()->user()->name }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Email:</span>
                        <span style="font-weight:600;word-break:break-word;">{{ auth()->user()->email }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Role:</span>
                        <span style="font-weight:600;text-transform:capitalize;">{{ auth()->user()->role ?? '—' }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Student ID:</span>
                        <span style="font-weight:600;">{{ $student->student_id }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <label for="age" style="color:#666;font-size:12px;min-width:110px;margin:0;">Age:</label>
                        <input id="age" name="age" type="number" min="1" class="form-control" value="{{ old('age', $student->age) }}" style="max-width:160px;" />
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <label for="sex" style="color:#666;font-size:12px;min-width:110px;margin:0;">Sex:</label>
                        <input id="sex" name="sex" type="text" class="form-control" value="{{ old('sex', $student->sex) }}" placeholder="e.g., Male / Female" style="max-width:200px;" />
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <label for="grade_level" style="color:#666;font-size:12px;min-width:110px;margin:0;">Grade Level:</label>
                        <input id="grade_level" name="grade_level" type="text" class="form-control" value="{{ old('grade_level', $student->grade_level) }}" placeholder="e.g., Grade 10" style="max-width:220px;" />
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Tips Authored:</span>
                        <span style="font-weight:600;">{{ $tipsAuthoredCount ?? 0 }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Goals (C/T):</span>
                        <span style="font-weight:600;">{{ $completedGoalsCount ?? 0 }} / {{ $goalsCount ?? 0 }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Latest BMI:</span>
                        <span style="font-weight:600;">{{ optional($latestHealth)->bmi ?? '—' }}</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;padding:10px 12px;border:1px solid #eee;border-radius:8px;background:#fafafa;">
                        <span style="color:#666;font-size:12px;min-width:110px;">Latest Calories:</span>
                        <span style="font-weight:600;">{{ optional($latestHealth)->calories ?? '—' }}</span>
                    </div>
                    <div style="margin-top:8px;display:flex;gap:10px;justify-content:flex-end;">
                        <button type="submit" class="btn-card">Save Changes</button>
                    </div>
                </form>
                @else
                    <div class="alert" style="background:#fff3cd;color:#8a6d3b;border:1px solid #ffeeba;padding:10px 12px;border-radius:8px;">No student profile found yet.</div>
                    <div style="margin-top:12px;display:flex;gap:10px;">
                        <a class="btn-card" href="{{ route('students.index') }}">Manage Profile</a>
                    </div>
                @endif
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

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;">
                    <div>
                        <label class="form-label">Calories (kcal)</label>
                        <input type="number" name="calories" min="0" class="form-control" />
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
                        <input type="date" name="recorded_at" class="form-control" />
                    </div>
                </div>

                <details style="margin-top:12px;">
                    <summary style="cursor:pointer;">Optional: body metrics</summary>
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-top:12px;">
                        <div>
                            <label class="form-label">Height (cm)</label>
                            <input type="number" step="0.1" name="height" min="0" class="form-control" />
                        </div>
                        <div>
                            <label class="form-label">Weight (kg)</label>
                            <input type="number" step="0.1" name="weight" min="0" class="form-control" />
                        </div>
                        <div>
                            <label class="form-label">BMI</label>
                            <input type="number" step="0.1" name="bmi" min="0" class="form-control" />
                        </div>
                        <div>
                            <label class="form-label">Status</label>
                            <input type="text" name="status" class="form-control" placeholder="e.g., Normal" />
                        </div>
                    </div>
                </details>

                <div style="margin-top:16px;display:flex;gap:10px;justify-content:flex-end;">
                    <button type="button" class="btn-card" style="background:#6c757d;" onclick="closeModal('addIntakeModal')">Cancel</button>
                    <button type="submit" class="btn-card">Save Intake</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Manage Goals Modal -->
    <div id="manageGoalsModal" class="modal" style="display:none;">
        <div class="modal-content" style="max-width:840px;width:90%;">
            <span class="close" onclick="closeModal('manageGoalsModal')">&times;</span>
            <h2 style="margin-top:0;">Health Goals</h2>

            <div style="display:grid;grid-template-columns:1fr;gap:16px;">
                <!-- Goals List with actions -->
                <div class="card" style="margin:0;">
                    <h3 style="margin-top:0;">Your Goals</h3>
                    @if($goals->isEmpty())
                        <p class="text">No goals yet. Create one below.</p>
                    @else
                        <ul style="list-style:none;padding:0;margin:0;">
                            @foreach($goals as $goal)
                                <li style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f1f1f1;">
                                    <div>
                                        <strong>{{ ucfirst($goal->goal_type) }}</strong>
                                        <small style="color:#666"> — target: {{ $goal->target }}</small>
                                        @if($goal->is_completed)
                                            <span class="badge" style="background:#4caf50;color:#fff;padding:4px 8px;border-radius:6px;margin-left:8px;">Completed</span>
                                        @else
                                            <span class="badge" style="background:#eee;color:#333;padding:4px 8px;border-radius:6px;margin-left:8px;">In progress</span>
                                        @endif
                                    </div>
                                    <div style="display:flex;gap:8px;align-items:center;">
                                        @if(!$goal->is_completed)
                                            <form method="POST" action="{{ route('goals.update', $goal) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="goal_type" value="{{ $goal->goal_type }}" />
                                                <input type="hidden" name="target" value="{{ $goal->target }}" />
                                                <input type="hidden" name="is_completed" value="1" />
                                                <button type="submit" class="btn-card" title="Mark as complete">Mark Complete</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('goals.destroy', $goal) }}" onsubmit="return confirm('Delete this goal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-card" style="background:#b71c1c;">Delete</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Create Goal -->
                <div class="card" style="margin:0;">
                    <h3 style="margin-top:0;">Add New Goal</h3>
                    <form method="POST" action="{{ route('goals.store') }}">
                        @csrf
                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;">
                            <div>
                                <label class="form-label">Goal Type</label>
                                <input type="text" name="goal_type" class="form-control" placeholder="e.g., weight, calories" required />
                            </div>
                            <div>
                                <label class="form-label">Target</label>
                                <input type="text" name="target" class="form-control" placeholder="e.g., 70kg or 2000 kcal" required />
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:12px;">
                            <button type="button" class="btn-card" style="background:#6c757d;" onclick="closeModal('manageGoalsModal')">Close</button>
                            <button type="submit" class="btn-card">Save Goal</button>
                        </div>
                    </form>
                </div>
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

    <!-- Tip Detail Modals (moved outside manageGoalsModal for proper overlay) -->
    @if(isset($tips))
        @foreach($tips as $tip)
            <div id="tipModal-{{ $tip->id }}" class="modal" style="display:none;">
                <div class="modal-content" style="max-width:700px;width:90%;text-align:left;">
                    <span class="close" onclick="closeModal('tipModal-{{ $tip->id }}')">&times;</span>
                    <h2 style="margin:0 0 6px 0;">{{ $tip->title }}</h2>
                    <p style="margin:0 0 12px 0;color:#555;font-size:13px;">
                        @if($tip->category)
                            <span style="background:#eee;color:#333;padding:4px 8px;border-radius:6px;margin-right:8px;font-size:11px;">{{ $tip->category }}</span>
                        @endif
                        <small>by {{ optional($tip->user)->name ?? 'Unknown' }} • {{ $tip->created_at->format('M d, Y') }}</small>
                    </p>
                    <div style="font-size:14px; line-height:1.6; white-space:pre-line; margin-bottom:16px;">{{ $tip->content }}</div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;flex-wrap:wrap;">
                        @if(auth()->user()->role === 'admin')
                            <a class="btn-card" href="{{ route('tips.edit', $tip) }}" style="padding:6px 12px;">Edit</a>
                            <form method="POST" action="{{ route('tips.destroy', $tip) }}" onsubmit="return confirm('Delete this tip?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-card" style="background:#b71c1c;padding:6px 12px;">Delete</button>
                            </form>
                        @endif
                        <button type="button" class="btn-card" style="background:#6c757d;padding:6px 12px;" onclick="closeModal('tipModal-{{ $tip->id }}')">Close</button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif



    <script>
         function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        const sections = ['dashboard','health','goals','tips','settings','profile'];
        function showSection(name) {
            sections.forEach(s => {
                const el = document.getElementById('section-' + s);
                if (el) el.style.display = (s === name) ? 'grid' : 'none';
            });
            const wb = document.getElementById('welcome-banner');
            if (wb) wb.style.display = (name === 'dashboard') ? 'flex' : 'none';
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
        });
    </script>





</x-dashboard-layout>
