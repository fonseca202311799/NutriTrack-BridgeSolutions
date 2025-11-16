<x-dashboard-layout>
    <div class="main" style="margin-left:306px; padding:20px;">
        <div class="card" style="text-align:left; display:flex; flex-direction:column; gap:14px;">
            <div style="display:flex;justify-content:space-between;align-items:start;gap:16px;flex-wrap:wrap;">
                <div>
                    <p class="text" style="margin:0 0 4px 0;font-size:13px;color:#666;">Nutrition & Wellness Tip</p>
                    <h2 style="margin:0;">{{ $tip->title }}</h2>
                    <p class="text" style="margin:6px 0 0 0;color:#555;font-size:13px;">
                        @if($tip->category)
                            <span class="badge" style="background:#eee;color:#333;padding:4px 8px;border-radius:6px;margin-right:8px;">{{ $tip->category }}</span>
                        @endif
                        <small>by {{ optional($tip->user)->name ?? 'Unknown' }} • {{ $tip->created_at->format('M d, Y') }}</small>
                    </p>
                </div>
                <div style="display:flex;gap:8px;align-items:center;">
                    <a class="btn-card" href="{{ route('dashboard') }}" style="white-space:nowrap;">Back to Dashboard</a>
                    @if(auth()->user()->role === 'admin')
                        <a class="btn-card" href="{{ route('tips.edit', $tip) }}" style="white-space:nowrap;">Edit</a>
                        <form method="POST" action="{{ route('tips.destroy', $tip) }}" onsubmit="return confirm('Delete this tip?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-card" style="background:#b71c1c;white-space:nowrap;">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
            <hr style="border:none;border-top:1px solid #f1f1f1;margin:0;" />
            <div style="font-size:14px; line-height:1.6; white-space:pre-line;">
                {{ $tip->content }}
            </div>
        </div>
        <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap;">
            <a class="btn-card" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="btn-card" href="{{ route('tips.index') }}">All Tips</a>
        </div>
    </div>
</x-dashboard-layout>
