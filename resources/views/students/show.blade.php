@php($title = 'Student Details')
<x-dashboard-layout>
    <div class="dashboard-container span-full" style="display:grid; gap:16px;">
        <div class="card span-full" style="max-width:960px;">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                <h2 style="margin:0;">Student Details</h2>
                <div style="display:flex; gap:8px;">
                    <a class="btn-card" href="{{ route('students.index') }}">Back</a>
                    <a class="btn-card" href="{{ route('students.edit', $student) }}">Edit</a>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:14px; margin-top:12px;">
                <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                    <strong style="display:block; font-size:.75rem; color:#2a7d2e;">NAME</strong>
                    <span>{{ $student->user->name ?? '—' }}</span>
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
                <div style="background:#f9f9f9; padding:12px 14px; border-radius:10px;">
                    <strong style="display:block; font-size:.75rem; color:#2a7d2e;">DATE OF BIRTH</strong>
                    @php
                        $__dobFormatted = null;
                        try {
                            if (!empty($student->birth_date)) {
                                $__dob = $student->birth_date instanceof \Carbon\Carbon ? $student->birth_date : \Carbon\Carbon::parse($student->birth_date);
                                $__dobFormatted = $__dob->format('M d, Y');
                            }
                        } catch (\Throwable $e) {
                            $__dobFormatted = null;
                        }
                    @endphp
                    <span>{{ $__dobFormatted ?? '—' }}</span>
                </div>
            </div>

            <hr style="border:none; border-top:1px solid #f1f1f1; margin:20px 0;" />

            <h3 style="margin:0 0 8px 0;">Health Records</h3>
            @forelse($student->healthRecords as $rec)
                <ul style="list-style:none; padding:0; margin:0;">
                    <li style="padding:10px 0; border-bottom:1px solid #f1f1f1; font-size:.85rem;">
                        {{ $rec->recorded_at?->format('M d, Y') }} —
                        Calories: <strong>{{ $rec->calories ?? '—' }}</strong>,
                        Protein: <strong>{{ $rec->protein ?? '—' }}g</strong>,
                        Carbs: <strong>{{ $rec->carbs ?? '—' }}g</strong>,
                        Fat: <strong>{{ $rec->fat ?? '—' }}g</strong>
                    </li>
                </ul>
            @empty
                <p class="text" style="margin:0;">No health records yet.</p>
            @endforelse

            <hr style="border:none; border-top:1px solid #f1f1f1; margin:20px 0;" />

            <h3 style="margin:0 0 8px 0;">Goals</h3>
            @forelse($student->goals as $goal)
                @php($pct = $goal->percentage())
                <ul style="list-style:none; padding:0; margin:0;">
                    <li style="padding:12px 0; border-bottom:1px solid #f1f1f1; display:flex; flex-direction:column; gap:8px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                            <span style="flex:1;">
                                <strong>{{ ucfirst($goal->goal_type) }}</strong>
                                <small style="color:#666">
                                    {{ $goal->target_value ? '— ' . $goal->current_value . ' / ' . $goal->target_value . ' ' . ($goal->target_unit ?? '') : '— target: ' . $goal->target }}
                                </small>
                            </span>
                            <span class="badge" style="background:{{ $goal->is_completed ? '#4caf50' : '#eee' }}; color:{{ $goal->is_completed ? '#fff' : '#333' }}; padding:4px 8px; border-radius:6px;">
                                {{ $goal->is_completed ? 'Completed' : ($pct ? $pct.'%' : 'In progress') }}
                            </span>
                        </div>
                        <div style="background:#eee; border-radius:6px; height:10px; overflow:hidden; position:relative; display:{{ $goal->target_value ? 'block' : 'none' }};">
                            <div style="background:#4caf50; width:{{ $pct }}%; height:100%;"></div>
                        </div>
                    </li>
                </ul>
            @empty
                <p class="text" style="margin:0;">No goals yet.</p>
            @endforelse
        </div>
    </div>
</x-dashboard-layout>
