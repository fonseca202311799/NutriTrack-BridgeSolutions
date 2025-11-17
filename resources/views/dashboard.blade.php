<x-dashboard-layout>

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

    <div id="section-dashboard" class="dashboard-container" style="display:grid; margin-left:306px; padding:20px; gap:20px; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
        <!-- Welcome Card -->
        <div class="card" style="grid-column:1/-1; text-align:left;">
            <h2 style="margin-top:0;">Welcome, {{ auth()->user()->name }}!</h2>
            <p class="text" style="margin:4px 0 0;">Glad to have you back. Track your progress and stay consistent today.</p>
        </div>
        <!-- Nutrition Today -->
        <div class="card">
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
            <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
                <button class="btn-card" type="button" onclick="openModal('addIntakeModal')">Add Intake</button>
                <a class="btn-card" href="{{ route('health-records.index') }}">View Records</a>
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
        <div class="card">
            <h2>Goals Summary</h2>
            @php($percent = $goalStats['total'] ? round(($goalStats['completed'] / $goalStats['total']) * 100) : 0)
            <p class="text" style="margin:0;">Total Goals: <strong>{{ $goalStats['total'] }}</strong></p>
            <p class="text" style="margin:0;">Completed: <strong>{{ $goalStats['completed'] }}</strong></p>
            <div style="margin-top:8px; background:#eee; height:10px; border-radius:6px; overflow:hidden;">
                <div style="height:100%; width:{{ $percent }}%; background:#4caf50;"></div>
            </div>
            <p class="text" style="margin-top:6px;">Progress: <strong>{{ $percent }}%</strong></p>
            <a class="btn-card" href="{{ route('goals.index') }}" style="margin-top:12px;">Manage Goals</a>
        </div>

        <!-- Detailed Goals List -->
        <div class="card" style="grid-column:1/-1;">
            <h2>Health Goals</h2>
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
            <a class="btn-card" href="{{ route('goals.index') }}" style="margin-top:12px;">Manage Goals</a>
        </div>
    </div>

        <!-- Health Section -->
        <div id="section-health" class="dashboard-container" style="display:none; margin-left:306px; padding:20px; gap:20px; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
            <div class="card">
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

                    <details class="form-details" style="margin-top:12px;">
                        <summary>Optional: body metrics</summary>
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
                                <input id="bmi" type="number" step="0.1" name="bmi" min="0" class="form-control" placeholder="e.g., 22.5" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="status">Status</label>
                                <input id="status" type="text" name="status" class="form-control" placeholder="e.g., Normal" />
                            </div>
                        </div>
                    </details>

                    <div class="form-actions">
                        <button type="submit" class="btn-card">Save Intake</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Goals Section -->
        <div id="section-goals" class="dashboard-container" style="display:none; margin-left:306px; padding:20px; gap:20px; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
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
                <a class="btn-card" href="{{ route('goals.index') }}" style="margin-top:12px;">Manage Goals</a>
            </div>
        </div>

        <!-- Tips Section -->
        <div id="section-tips" class="dashboard-container" style="display:none; margin-left:306px; padding:20px; gap:20px; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
            <div class="card" style="grid-column:1/-1; text-align:left;">
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
        <div id="section-settings" class="dashboard-container" style="display:none; margin-left:306px; padding:20px; gap:20px; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
            <div class="card">
                <h2>Settings</h2>
                <p class="text">Customize your experience. More options coming soon.</p>
            </div>
        </div>

        <!-- Profile Section -->
        <div id="section-profile" class="dashboard-container" style="display:none; margin-left:306px; padding:20px; gap:20px; grid-template-columns:repeat(auto-fit,minmax(280px,1fr));">
            <div class="card" style="grid-column:1/-1; text-align:left;">
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
                        <form method="POST" action="{{ route('students.update', $student) }}" style="display:flex; flex-direction:column; gap:12px; background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="redirect_to" value="dashboard" />
                            <strong style="display:block; font-size:.85rem; letter-spacing:.5px; color:#2a7d2e;">EDIT STUDENT DETAILS</strong>
                            <div class="form-group">
                                <label class="form-label" for="profile_age">Age</label>
                                <input id="profile_age" type="number" min="1" name="age" class="form-control" value="{{ old('age', $student->age) }}" placeholder="e.g., 17" />
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="profile_sex">Sex</label>
                                <select id="profile_sex" name="sex" class="form-control">
                                    <option value="" {{ old('sex', $student->sex) === null ? 'selected' : '' }}>Select...</option>
                                    <option value="male" {{ old('sex', strtolower((string)$student->sex)) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('sex', strtolower((string)$student->sex)) === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('sex', strtolower((string)$student->sex)) === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="profile_grade">Grade Level</label>
                                <input id="profile_grade" type="text" name="grade_level" class="form-control" value="{{ old('grade_level', $student->grade_level) }}" placeholder="e.g., Grade 10" />
                            </div>
                            <div class="form-actions" style="justify-content:flex-start;">
                                <button type="submit" class="btn-card">Save Changes</button>
                            </div>
                        </form>
                    @else
                        <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                            <p class="text" style="margin:0 0 10px;">No student profile yet.</p>
                            <a class="btn-card" href="{{ route('students.create') }}">Create Profile</a>
                        </div>
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
