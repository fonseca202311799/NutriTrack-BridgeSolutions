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
        @if (session('success'))
            <div class="alert" style="background:#e8f5e9;color:#1b5e20;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                {{ session('success') }}
            </div>
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

            <!-- Health Goals -->
            <div class="card">
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
                    <a class="btn-card" href="{{ route('health-records.index') }}">View Records</a>
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
                <a class="btn-card" href="{{ route('goals.index') }}" style="margin-top:12px;">Manage Goals</a>
            </div>
        </div>

        <!-- Tips Section -->
        <div id="section-tips" class="dashboard-container" style="display:none;">
            <div class="card">
                <h2>Tips</h2>
                <p class="text">Browse nutrition and wellness tips curated for students.</p>
                <a class="btn-card" href="{{ route('tips.index') }}">View Tips</a>
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
                <h2>Profile</h2>
                <p class="text">Name: <strong>{{ auth()->user()->name }}</strong></p>
                <p class="text">Email: <strong>{{ auth()->user()->email }}</strong></p>
                <a class="btn-card" href="{{ route('students.index') }}">Manage Profile</a>
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
    </script>
</x-dashboard-layout>
