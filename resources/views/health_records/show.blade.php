<x-dashboard-layout>
  <div style="margin-left:306px; padding:20px;">
    <a href="{{ route('health-records.index') }}" class="btn-card" style="background:#6c757d;">Back</a>

    <div class="card" style="background:#fff;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(0,0,0,0.08); margin-top:12px;">
      <h2 style="margin-top:0;">Record Details</h2>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
        <div><strong>Date:</strong> {{ optional($healthRecord->recorded_at)->format('Y-m-d') ?? \Illuminate\Support\Carbon::parse($healthRecord->recorded_at)->format('Y-m-d') }}</div>
        <div><strong>Student ID:</strong> {{ $healthRecord->student_id }}</div>
        <div><strong>Calories:</strong> {{ $healthRecord->calories ?? '—' }} kcal</div>
        <div><strong>Protein:</strong> {{ $healthRecord->protein ?? '—' }} g</div>
        <div><strong>Carbs:</strong> {{ $healthRecord->carbs ?? '—' }} g</div>
        <div><strong>Fat:</strong> {{ $healthRecord->fat ?? '—' }} g</div>
        <div><strong>Height:</strong> {{ $healthRecord->height ?? '—' }} cm</div>
        <div><strong>Weight:</strong> {{ $healthRecord->weight ?? '—' }} kg</div>
        <div><strong>BMI:</strong> {{ $healthRecord->bmi ?? '—' }}</div>
        <div><strong>Status:</strong> {{ $healthRecord->status ?? '—' }}</div>
      </div>
      <div style="margin-top:16px;">
        <a class="btn-card" href="{{ route('health-records.edit', $healthRecord) }}">Edit</a>
      </div>
    </div>
  </div>
</x-dashboard-layout>
