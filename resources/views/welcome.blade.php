<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/png" href="{{ asset('images/small_logo.png') }}">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
    <script src="https://kit.fontawesome.com/7c33d9b7cf.js" crossorigin="anonymous"></script>
    <style>
        html, body {
            width: 100vw;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 16px;
            background: #fdfdfc;
        }
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }
        #header, .header-text, main, .thanks {
            width: 100%;
            max-width: 360px;
            margin: 0 auto;
        }
        .container-nav nav {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .logo img {
            max-width: 120px;
            height: auto;
        }
        ul {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0;
            margin: 0;
            justify-content: center;
        }
        ul li {
            list-style: none;
        }
        .header-text {
            text-align: center;
            padding: 1rem 0.5rem;
        }
        .header-text p {
            font-size: clamp(1rem, 2vw, 1.2rem);
            margin: 0.5rem 0;
        }
        .about-container {
            padding: 1rem 0.5rem;
        }
        .about-row {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .about-card {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 1rem;
            text-align: center;
        }
        .icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .contact-container {
            padding: 1rem 0.5rem;
        }
        .row-contact {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .contact-left, .contact-right {
            width: 100%;
        }
        .contact-right form {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .contact-right input, .contact-right textarea {
            width: 100%;
            padding: 0.5rem;
            border-radius: 0.25rem;
            border: 1px solid #e3e3e0;
            font-size: 1rem;
        }
        .contact-right button {
            padding: 0.5rem;
            border-radius: 0.25rem;
            background: #2e7d32;
            color: #fff;
            border: none;
            font-size: 1rem;
        }
        .thanks {
            text-align: center;
            padding: 1rem 0;
            font-size: 0.9rem;
            color: #706f6c;
        }
        @media (min-width: 361px) {
            #header, .header-text, main, .thanks {
                max-width: 360px;
            }
        }
    </style>
</head>

<body>
    {{--
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        --}}




    <div id="header">
        <div class="container-nav">
            <nav>
                <div class="logo" id="image-logo"><img src="{{ asset('images/nutritrack(2).png') }}" alt="logo" class="image-logo" loading="lazy"></div>

                <ul>
                    <Li><a href="#header">Home</a></Li>
                    <Li><a href="#about">About</a></Li>
                    <Li><a href="#contact">Contact</a></Li>
                    <Li><a href="{{ route('login') }}">Login</a></Li>
                    {{-- <Li><a href="{{ route('register') }}">Register</a></Li> --}}

                </ul>
            </nav>

        </div>

    </div>

    <div class="header-text">

        <p div style="text-align: center;">Track your <span>Students' Nutrition</span></p>
        <p div style="text-align: center; color: #ffffff;">Effortlessly monitor students’ meals, growth, and health goals with Nutritrack at school.</p>
        <!--
        <div class="arrow">
            <i class="fa fa-arrow-down arrow-bounce"></i>
        </div>
        -->
    </div>

    <main>
        <!--About Me-->
        <section>
            <div id="about">
                <div class="about-container">

                    <h2>ABOUT NUTRI<span>TRACK</span></h2>

                    <div class="about-row">
                        <div class="about-card">
                            <h3>Track Nutrition</h3>
                            <div class="icon">
                                <i class="fa-solid fa-chart-simple icon-bounce"></i>
                            </div>

                            <p>Monitor meals, growth, and student health progress effortlesly.</p>
                        </div>

                        <div class="about-card">
                            <h3>Health Goals</h3>
                            <div class="icon">
                                <i class="fa-regular fa-square-plus icon-bounce"></i>
                            </div>
                            <p>Help students achieve wellness objective with personalize targets.</p>
                        </div>

                        <div class="about-card">
                            <h3>Educational Tips</h3>
                            <div class="icon">
                                <i class="fa-solid fa-chalkboard-user icon-bounce"></i>
                            </div>
                            <p>Provide easy-to-read nutrition tips and health recommendations for students.</p>
                        </div>


                    </div>
                </div>
            </div>
        </section>
        <!--Contact Information-->
        <section>
            <div id="contact">
                <div class="contact-container">
                    <div class="row-contact">
                        <div class="contact-left">
                            <h1 class="sub-title">Socials</h1>

                            <p><i class="fa fa-google"></i> bridgesolutions@gmail.com</p>

                            <p><i class="fa fa-phone"></i> 09159233582</p>
                            <div class="social-icons">
                                <a href="https://www.facebook.com/johnandrew.fonsecaii" target="_blank"><i
                                        class="fa fa-facebook"></i></a>

                                <a href="https://github.com/fonseca202311799?tab=repositories" target="_blank"><i
                                        class="fa fa-github"></i></a>
                            </div>
                        </div>

                        <div class="contact-right">
                            <h2>Contact Us</h2>
                            <form id="contactForm">
                                <input type="text" id="name" placeholder="Your Name" required>
                                <input type="email" id="email" placeholder="Your Email" required>
                                <textarea id="message" rows="3" placeholder="Your Message" required></textarea>
                                <button type="submit">Send</button>
                            </form>
                        </div>

                    </div>
                </div>




            </div>
        </section>

    </main>

    <div class="thanks">
        <p>&copy; 2025 BridgeSolutions. All Rights Reserved</p>
    </div>



    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>
