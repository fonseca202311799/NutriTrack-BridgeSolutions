<x-layout>
    <div class="login">

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="logo">
               <a href="{{ route('welcome') }}"> <img src="{{ asset('images/nutritrack(2).png') }}" alt="logo" class="image-logo"></a>

            </div>


            <h1>Sign In</h1>
            <p>Start tracking your nutrition.</p>



            @error('email')
                <div id="toast-login-error" style="position:fixed; top:20px; right:20px; z-index:2000; background:#b71c1c; color:#fff; padding:16px 20px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.2); font-weight:700; display:flex; align-items:center; gap:12px; min-width:280px; border:2px solid #c62828;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><circle cx="12" cy="12" r="10" stroke="#fff" stroke-width="2" fill="#c62828"/><path stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M12 8v8"/></svg>
                    <span>{{ $message }}</span>
                    <button id="close-login-error" type="button" style="background:none; border:none; color:#fff; font-size:1.5rem; margin-left:12px; cursor:pointer;">&times;</button>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        var t = document.getElementById('toast-login-error');
                        var c = document.getElementById('close-login-error');
                        if (c && t) {
                            c.onclick = function(){ t.style.display = 'none'; };
                        }
                    });
                </script>
            @enderror
            @error('password')
                <div id="toast-login-error-pw" style="position:fixed; top:60px; right:20px; z-index:2000; background:#b71c1c; color:#fff; padding:16px 20px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.2); font-weight:700; display:flex; align-items:center; gap:12px; min-width:280px; border:2px solid #c62828;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><circle cx="12" cy="12" r="10" stroke="#fff" stroke-width="2" fill="#c62828"/><path stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M12 8v8"/></svg>
                    <span>{{ $message }}</span>
                    <button id="close-login-error-pw" type="button" style="background:none; border:none; color:#fff; font-size:1.5rem; margin-left:12px; cursor:pointer;">&times;</button>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function(){
                        var t = document.getElementById('toast-login-error-pw');
                        var c = document.getElementById('close-login-error-pw');
                        if (c && t) {
                            c.onclick = function(){ t.style.display = 'none'; };
                        }
                    });
                </script>
            @enderror

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
