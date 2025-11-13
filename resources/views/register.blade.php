<x-layout>

    <div class="login">



        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="logo">
                <a href="{{ route('welcome') }}"> <img src="{{ asset('images/nutritrack(2).png') }}" alt="logo"
                        class="image-logo"></a>

            </div>

            <h1>Sign Up</h1>
            <p>Start tracking your nutrition.</p>

            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }} </li>
                        @endforeach
                    </ul>
                </div>

            @endif
            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Name" />
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email" />
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" />

            <button type="submit">Register</button>



        </form>
    </div>
</x-layout>
