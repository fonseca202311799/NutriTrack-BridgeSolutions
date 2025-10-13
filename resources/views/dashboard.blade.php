<x-dashboard-layout>
    {{--
    <h1>Welcome {{ Auth::user()->name }} </h1>
    <form method="POST" action="{{ route('logout') }}">
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
        <button class="logout" type="submit">Logout</button>
    </form>

--}}
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
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-table-columns" title="Dashboard"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>

                 <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-regular fa-square-plus" title="Health"></i>
                        <span class="nav-label">Health</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-trophy" title="Goals"></i>
                        <span class="nav-label">Goals</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-chalkboard-user" title="Tips"></i>
                        <span class="nav-label">Tips</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-gear" title="Dashboard"></i>
                        <span class="nav-label">Settings</span>
                    </a>
                </li>
            </ul>

            <ul class="nav-list secondary-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-user" title="Profile"></i>
                        <span class="nav-label">Profile</span>
                    </a>
                </li>

                 <li class="nav-item">

                        <form method="POST" action="{{ route('logout') }}">
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

                            <button class="logout" type="submit" title="Logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button>
                        </form>

                </li>
            </ul>
        </nav>
    </aside>

    {{--
    <div class="dashboard-container">
        <div class="card">
            <h2>Health Record</h2>
            <p>View your BMI, height, and weight updates.</p>
            <button class="btn-card" onclick="openModal('healthRecordModal')">View</button>
        </div>

        <div class="card">
            <h2>Goals</h2>
            <p>Track your current nutrition or fitness goals.</p>
            <button class="btn-card" onclick="openModal('goalsModal')">Check Progress</button>
        </div>

        <div class="card">
            <h2>Tips</h2>
            <p>Read daily nutrition and health tips curated for you.</p>
            <button class="btn-card" onclick="openModal('tipsModal')">Read Tips</button>
        </div>

        <div class="card">
            <h2>Reports</h2>
            <p>View your monthly nutrition performance summary.</p>
            <button class="btn-card" onclick="openModal('reportsModal')">View Report</button>
        </div>
    </div>
    --}}



    {{-- Health Record Modal
    <div id="healthRecordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('healthRecordModal')">&times;</span>
            <h2>Your Health Records</h2>

            @if ($student && $healthRecords->count() > 0)
                <table class="health-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Height (cm)</th>
                            <th>Weight (kg)</th>
                            <th>BMI</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($healthRecords as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->recorded_at)->format('M d, Y') }}</td>
                                <td>{{ $record->height }}</td>
                                <td>{{ $record->weight }}</td>
                                <td>{{ number_format($record->bmi, 2) }}</td>
                                <td>{{ $record->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No health records found.</p>
            @endif
        </div>
    </div>
    --}}
    {{-- Goals Modal
    <div id="goalsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('goalsModal')">&times;</span>
            <h2>Goals</h2>
            @if ($student && $goals->count() > 0)
            <table class="goal-table">
                <thead>
                    <tr>
                        <th>Goal Type</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Target Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($goals as $goal)
                        <tr>
                            <td>{{ ucfirst($goal->goal_type) }}</td>
                            <td>{{ $goal->description }}</td>
                            <td>{{ ucfirst($goal->status) }}</td>
                            <td>{{ \Carbon\Carbon::parse($goal->target_date)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No goals found.</p>
        @endif
        </div>
    </div>
    --}}
    {{-- Tips Modal
    <div id="tipsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('tipsModal')">&times;</span>
            <h2>Health Tips</h2>

        @if ($tips->count() > 0)
            <ul class="tips-list">
                @foreach ($tips as $tip)
                    <li class="tip-item">
                        <h3>{{ $tip->title }}</h3>
                        <p>{{ $tip->content }}</p>
                        <small>Posted on: {{ $tip->created_at->format('M d, Y') }}</small>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No tips available right now. Check back later!</p>
        @endif
        </div>
    </div>
    --}}


    {{-- Reports Modal
    <div id="reportsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('reportsModal')">&times;</span>
            <h2>Reports</h2>
            <p>Under Development</p>
        </div>
    </div>
    --}}



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
    </script>





</x-dashboard-layout>
