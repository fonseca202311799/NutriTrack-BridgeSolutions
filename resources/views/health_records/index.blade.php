<x-dashboard-layout>
  <div style="margin-left:306px; padding:20px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
      <h2 style="margin:0;">Health Records</h2>
      <a href="{{ route('health-records.create') }}" class="btn-card">Add Record</a>
    </div>

    @if (session('success'))
      <div style="background:#e8f5e9;color:#1b5e20;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
        {{ session('success') }}
      </div>
    @endif

    <div class="card" style="background:#fff;border-radius:12px;padding:0;box-shadow:0 4px 12px rgba(0,0,0,0.08);overflow:hidden;">
      <table class="health-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Student</th>
            <th>Calories</th>
            <th>Protein</th>
            <th>Carbs</th>
            <th>Fat</th>
            <th>Height</th>
            <th>Weight</th>
            <th>BMI</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($records as $rec)
            <tr>
              <td>{{ optional($rec->recorded_at)->format('Y-m-d') ?? \Illuminate\Support\Carbon::parse($rec->recorded_at)->format('Y-m-d') }}</td>
              <td>{{ $rec->student_id }}</td>
              <td>{{ $rec->calories ?? '—' }}</td>
              <td>{{ $rec->protein ?? '—' }} g</td>
              <td>{{ $rec->carbs ?? '—' }} g</td>
              <td>{{ $rec->fat ?? '—' }} g</td>
              <td>{{ $rec->height ?? '—' }} cm</td>
              <td>{{ $rec->weight ?? '—' }} kg</td>
              <td>{{ $rec->bmi ?? '—' }}</td>
              <td>{{ $rec->status ?? '—' }}</td>
              <td>
                <a class="btn-card" href="{{ route('health-records.show', $rec) }}" style="padding:6px 10px;">View</a>
                <a class="btn-card" href="{{ route('health-records.edit', $rec) }}" style="padding:6px 10px;background:#ffc107;color:#000;">Edit</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="11" style="text-align:center;padding:16px;">No records yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-dashboard-layout>
