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
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }} </li>
                        @endforeach
                    </ul>
                </div>

            @endif

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="name@email.com" />
            {{--
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
             --}}

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="********" />
            {{--
             @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
            --}}
            <button type="submit">Login </button>

        </form>

    </div>
</x-layout>
