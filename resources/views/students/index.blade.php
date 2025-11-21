@php($title = 'Student Profile')
<x-dashboard-layout>
    <div class="dashboard-container span-full" style="display:grid; gap:16px;">
        <div class="card span-full" style="max-width:860px;">
            <h2 style="margin-top:0;">Student Profile</h2>
            @if(session('success'))
                <div style="background:#e8f5e9; border:1px solid #c8e6c9; padding:10px 14px; border-radius:8px; margin-bottom:12px; color:#2e7d32; font-weight:600;">
                    {{ session('success') }}
                </div>
            @endif

            @if(!$student)
                <p class="text" style="margin:0 0 12px;">No profile found yet. Create one to enable personalized tracking.</p>
                <a class="btn-card" href="{{ route('students.create') }}">Create Profile</a>
            @else
                <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px; margin-top:8px;">
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; color:#2a7d2e;">NAME</strong>
                        <span>{{ $student->user->name }}</span>
                    </div>
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; color:#2a7d2e;">STUDENT ID</strong>
                        <span>{{ $student->student_id }}</span>
                    </div>
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; color:#2a7d2e;">AGE</strong>
                        <span>{{ $student->age ?? '—' }}</span>
                    </div>
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; color:#2a7d2e;">SEX</strong>
                        <span>{{ ucfirst($student->sex ?? '—') }}</span>
                    </div>
                    <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                        <strong style="display:block; font-size:.75rem; color:#2a7d2e;">GRADE LEVEL</strong>
                        <span>{{ $student->grade_level ?? '—' }}</span>
                    </div>
                </div>

                <hr style="border:none; border-top:1px solid #f1f1f1; margin:20px 0;" />
                <h3 style="margin:0 0 8px 0;">Health Records</h3>
                @if($healthRecords->isEmpty())
                    <p class="text" style="margin:0;">No health records yet.</p>
                @else
                    <ul style="list-style:none; padding:0; margin:0;">
                        @foreach($healthRecords as $rec)
                            <li style="padding:10px 0; border-bottom:1px solid #f1f1f1; font-size:.85rem;">
                                {{ $rec->recorded_at?->format('M d, Y') }} — Calories: <strong>{{ $rec->calories ?? '—' }}</strong>, Protein: <strong>{{ $rec->protein ?? '—' }}g</strong>, Carbs: <strong>{{ $rec->carbs ?? '—' }}g</strong>, Fat: <strong>{{ $rec->fat ?? '—' }}g</strong>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div style="margin-top:16px; display:flex; gap:10px; flex-wrap:wrap;">
                    <a class="btn-card" href="{{ route('students.edit', $student) }}">Edit Profile</a>
                    <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete profile? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-card" style="background:#b71c1c;">Delete Profile</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-dashboard-layout>
