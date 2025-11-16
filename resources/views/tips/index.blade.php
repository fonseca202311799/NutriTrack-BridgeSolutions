<x-dashboard-layout>
    <div class="main" style="margin-left: 306px; padding: 20px;">
        <div class="card" style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px;">
            <div>
                <h2 style="margin:0;">Tips</h2>
                <p class="text" style="margin:6px 0 0 0;">Nutrition and wellness tips curated for students.</p>
            </div>
            <div style="display:flex;gap:8px;">
                <a class="btn-card" href="{{ route('dashboard') }}">Back to Dashboard</a>
                @if(auth()->user()->role === 'admin')
                    <a class="btn-card" href="{{ route('tips.create') }}">Add Tip</a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div id="toast-success" style="position:fixed; top:20px; right:20px; z-index:9999; background:#2e7d32; color:#fff; padding:12px 16px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function(){
                    var t = document.getElementById('toast-success');
                    if (t) { t.style.transition = 'opacity .4s'; t.style.opacity = '0'; setTimeout(function(){ if(t && t.parentNode) t.parentNode.removeChild(t); }, 400); }
                }, 2500);
            </script>
        @endif

        <div class="dashboard-container">
            @forelse($tips as $tip)
                <div class="card" style="text-align:left;">
                    <div style="display:flex;justify-content:space-between;align-items:start;gap:12px;">
                        <div>
                            <h3 style="margin:0 0 4px 0;">{{ $tip->title }}</h3>
                            <p class="text" style="margin:0;color:#666;">
                                @if($tip->category)
                                    <span class="badge" style="background:#eee;color:#333;padding:4px 8px;border-radius:6px;margin-right:8px;">{{ $tip->category }}</span>
                                @endif
                                <small>by {{ optional($tip->user)->name ?? 'Unknown' }}</small>
                            </p>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <a class="btn-card" href="{{ route('tips.show', $tip) }}">View</a>
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
                    <p class="text" style="margin-top:10px; white-space:pre-line;">{{ $tip->content }}</p>
                </div>
            @empty
                <div class="card">
                    @if(auth()->user()->role === 'admin')
                        <p class="text">No tips available yet. Add the first one!</p>
                        <a class="btn-card" href="{{ route('tips.create') }}">Create Tip</a>
                    @else
                        <p class="text">No tips available yet.</p>
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard-layout>
