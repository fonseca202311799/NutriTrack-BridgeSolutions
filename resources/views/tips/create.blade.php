<x-dashboard-layout>
    <div class="main" style="margin-left:306px; padding:20px;">
        <div class="card" style="max-width:500px; margin:auto;">
            <h2 style="margin-bottom:12px;">Send Personalized Tip</h2>
            <form method="POST" action="{{ route('tips.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input id="title" type="text" name="title" class="form-control" required value="{{ old('title') }}">
                    @error('title')<p class="text" style="color:#b71c1c;">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="content" class="form-label">Content</label>
                    <textarea id="content" name="content" class="form-control" required>{{ old('content') }}</textarea>
                    @error('content')<p class="text" style="color:#b71c1c;">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <input id="category" type="text" name="category" class="form-control" value="{{ old('category') }}">
                </div>
                <div class="form-group">
                    <label for="student_id" class="form-label">Send to Student</label>
                    <select id="student_id" name="student_id" class="form-control">
                        <option value="">All Students</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->user->name }} ({{ $student->grade_level }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-actions" style="margin-top:16px;">
                    <button type="submit" class="btn-card">Send Tip</button>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-layout>
