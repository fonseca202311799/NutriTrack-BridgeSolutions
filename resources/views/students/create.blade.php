@php($title = 'Create Student Profile')
<x-dashboard-layout>
    <div class="dashboard-container span-full" style="display:grid; gap:16px;">
        <div class="card span-full" style="max-width:640px;">
            <h2 style="margin-top:0;">Create Student Profile</h2>
            <p class="text" style="margin:0 0 14px;">Fill in the details below to create your student profile.</p>

            @if($errors->any())
                <div style="background:#ffe6e6; border:1px solid #ffb3b3; padding:10px 14px; border-radius:8px; margin-bottom:14px;">
                    <ul style="margin:0; padding-left:18px; color:#b71c1c;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('students.store') }}" style="display:grid; gap:12px;">
                @csrf

                @if(isset($users) && $users->count() > 1)
                    <div class="form-group">
                        <label class="form-label" for="user_id">Select User</label>
                        <select id="user_id" name="user_id" class="form-control" required>
                            <option value="">-- choose --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="user_id" value="{{ $users->first()->id ?? auth()->id() }}" />
                @endif

                <div class="form-group">
                    <label class="form-label" for="student_id">Student Identifier</label>
                    <input id="student_id" type="text" name="student_id" class="form-control" value="{{ old('student_id') }}" placeholder="e.g., STU-2025-001" required />
                </div>

                <div class="form-group">
                    <label class="form-label" for="age">Age</label>
                    <input id="age" type="number" min="1" name="age" class="form-control" value="{{ old('age') }}" placeholder="e.g., 16" />
                </div>

                <div class="form-group">
                    <label class="form-label" for="sex">Sex</label>
                    <select id="sex" name="sex" class="form-control">
                        <option value="" {{ old('sex') === null ? 'selected' : '' }}>Select...</option>
                        <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('sex') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="grade_level">Grade Level</label>
                    <input id="grade_level" type="text" name="grade_level" class="form-control" value="{{ old('grade_level') }}" placeholder="e.g., Grade 10" />
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:6px;">
                    <a href="{{ route('dashboard') }}" class="btn-card" style="background:#6c757d;">Cancel</a>
                    <button type="submit" class="btn-card">Create Profile</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
