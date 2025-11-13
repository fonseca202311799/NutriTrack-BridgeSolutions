<x-dashboard-layout>
<div style="margin-left:306px; padding:20px;">
    <div class="card" style="background:#fff;border-radius:12px;padding:20px;box-shadow:0 4px 12px rgba(0,0,0,0.08);">
        <h2 style="margin:0 0 12px 0;">Edit Record</h2>
        @if ($errors->any())
            <div style="background:#fdecea;color:#b71c1c;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('health-records.update', $healthRecord) }}">
            @csrf
            @method('PUT')
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
                <div>
                    <label class="form-label">Calories (kcal)</label>
                    <input type="number" name="calories" min="0" class="form-control" value="{{ old('calories', $healthRecord->calories) }}"/>
                </div>
                <div>
                    <label class="form-label">Protein (g)</label>
                    <input type="number" name="protein" min="0" class="form-control" value="{{ old('protein', $healthRecord->protein) }}"/>
                </div>
                <div>
                    <label class="form-label">Carbs (g)</label>
                    <input type="number" name="carbs" min="0" class="form-control" value="{{ old('carbs', $healthRecord->carbs) }}"/>
                </div>
                <div>
                    <label class="form-label">Fat (g)</label>
                    <input type="number" name="fat" min="0" class="form-control" value="{{ old('fat', $healthRecord->fat) }}"/>
                </div>
                <div>
                    <label class="form-label">Recorded at</label>
                    <input type="date" name="recorded_at" class="form-control" value="{{ old('recorded_at', optional($healthRecord->recorded_at)->format('Y-m-d')) }}"/>
                </div>
            </div>

            <hr style="margin:20px 0;" />
            <details>
                <summary style="cursor:pointer;">Optional: body metrics</summary>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-top:12px;">
                    <div>
                        <label class="form-label">Height (cm)</label>
                        <input type="number" step="0.1" name="height" min="0" class="form-control" value="{{ old('height', $healthRecord->height) }}"/>
                    </div>
                    <div>
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" min="0" class="form-control" value="{{ old('weight', $healthRecord->weight) }}"/>
                    </div>
                    <div>
                        <label class="form-label">BMI</label>
                        <input type="number" step="0.1" name="bmi" min="0" class="form-control" value="{{ old('bmi', $healthRecord->bmi) }}"/>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <input type="text" name="status" class="form-control" value="{{ old('status', $healthRecord->status) }}"/>
                    </div>
                </div>
            </details>

            <div style="margin-top:20px;display:flex;gap:12px;">
                <button type="submit" class="btn-card">Update</button>
                <a href="{{ route('health-records.index') }}" class="btn-card" style="background:#6c757d;">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-dashboard-layout>
