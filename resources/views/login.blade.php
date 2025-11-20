<x-layout>
    <div class="login">

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="logo">
               <a href="{{ route('welcome') }}"> <img src="{{ asset('images/nutritrack(2).png') }}" alt="logo" class="image-logo"></a>

            </div>


            <h1>Sign In</h1>
            <p>Start tracking your nutrition.</p>



            @if ($errors->any())
                <div id="toast-login-error" style="position:fixed; top:20px; right:20px; z-index:2000; background:#c62828; color:#fff; padding:14px 18px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.2); font-weight:600; display:flex; align-items:center; gap:10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><circle cx="12" cy="12" r="10" stroke="#fff" stroke-width="2" fill="#c62828"/><path stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M12 8v8"/></svg>
                    <ul style="margin:0; padding:0; list-style:none;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        var t = document.getElementById('toast-login-error');
                        if (t) {
                            setTimeout(function(){ t.style.display = 'none'; }, 3000);
                        }
                    });
                </script>
            @endif

            <label for="email">Email:</label>
            <input id="email" type="email" name="email" placeholder="name@email.com" />
            {{--
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
             --}}

            <label for="password">Password:</label>
            <div style="position:relative; width:100%;">
                <input id="password" type="password" name="password" placeholder="********" style="padding-right:48px; display:block; width:100%;" />
                <span id="togglePassword" role="button" tabindex="0"
                      aria-label="Show password" aria-pressed="false"
                      style="position:absolute; right:8px; top:50%; transform:translateY(-50%); width:32px; height:32px; background:transparent; color:#666; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:2;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </span>
            </div>
            {{--
             @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
            --}}
            <button type="submit">Login </button>

            <script>
                document.addEventListener('DOMContentLoaded', function(){
                    var pwd = document.getElementById('password');
                    var btn = document.getElementById('togglePassword');
                    if (!pwd || !btn) return;

                    const svgEye = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>`;
                    const svgEyeOff = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M3 3l18 18" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.58 10.58a3 3 0 104.24 4.24" />
                            <path d="M9.88 4.24A10.94 10.94 0 0121 12s-4 7-9 7a10.94 10.94 0 01-7.12-2.88" />
                        </svg>`;

                    btn.innerHTML = svgEye;
                    function toggle(){
                        var isHidden = pwd.type === 'password';
                        pwd.type = isHidden ? 'text' : 'password';
                        btn.innerHTML = isHidden ? svgEyeOff : svgEye;
                        btn.setAttribute('aria-pressed', String(isHidden));
                        btn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                    }
                    btn.addEventListener('click', toggle);
                    btn.addEventListener('keydown', function(e){
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            toggle();
                        }
                    });
                });
            </script>

        </form>

    </div>
</x-layout>
