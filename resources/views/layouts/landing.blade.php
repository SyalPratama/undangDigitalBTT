<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cinematic Digital Invitation')</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght=400;500;600;700&family=Playfair+Display:ital,wght=1,600&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .serif-italic {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }

        /* Animasi untuk Pulse Lingkaran Stepper */
        @keyframes sequencePulse {

            0%,
            100% {
                background-color: #ffffff;
                color: #64748b;
                border-color: #e2e8f0;
                transform: scale(1);
            }

            7%,
            20% {
                background-color: #4c229a;
                color: #ffffff;
                border-color: #ffffff;
                transform: scale(1.1);
                box-shadow: 0 10px 15px -3px rgba(168, 85, 247, 0.4);
            }

            27% {
                background-color: #ffffff;
                color: #64748b;
                border-color: #e2e8f0;
                transform: scale(1);
                box-shadow: none;
            }
        }

        .anim-step-1 {
            animation: sequencePulse 10s infinite ease-in-out;
            animation-delay: 0s;
        }

        .anim-step-2 {
            animation: sequencePulse 10s infinite ease-in-out;
            animation-delay: 2s;
        }

        .anim-step-3 {
            animation: sequencePulse 10s infinite ease-in-out;
            animation-delay: 4s;
        }

        .anim-step-4 {
            animation: sequencePulse 10s infinite ease-in-out;
            animation-delay: 6s;
        }

        .anim-step-5 {
            animation: sequencePulse 10s infinite ease-in-out;
            animation-delay: 8s;
        }

        /* Animasi Pesawat Bergerak untuk Layar Desktop (Horizontal) */
        @keyframes planeFlyHorizontal {
            0% {
                left: 2%;
                top: 24px;
                opacity: 0;
                transform: translate(-50%, -50%) rotate(0deg);
            }

            2% {
                opacity: 1;
            }

            15%,
            35%,
            55%,
            75% {
                top: 24px;
            }

            20% {
                left: 26%;
                top: 24px;
            }

            40% {
                left: 50%;
                top: 24px;
            }

            60% {
                left: 74%;
                top: 24px;
            }

            80% {
                left: 98%;
                top: 24px;
                opacity: 1;
            }

            95%,
            100% {
                left: 98%;
                top: 24px;
                opacity: 0;
            }
        }

        /* Animasi Pesawat Bergerak untuk Layar Mobile (Vertikal) */
        @keyframes planeFlyVertical {
            0% {
                left: 24px;
                top: 2%;
                opacity: 0;
                transform: translate(-50%, -50%) rotate(90deg);
            }

            2% {
                opacity: 1;
            }

            15%,
            35%,
            55%,
            75% {
                left: 24px;
            }

            20% {
                left: 24px;
                top: 24%;
            }

            40% {
                left: 24px;
                top: 47%;
            }

            60% {
                left: 24px;
                top: 71%;
            }

            80% {
                left: 24px;
                top: 94%;
                opacity: 1;
            }

            95%,
            100% {
                left: 24px;
                top: 94%;
                opacity: 0;
            }
        }

        .anim-plane {
            animation: planeFlyVertical 10s infinite ease-in-out;
        }

        @media (min-width: 768px) {
            .anim-plane {
                animation: planeFlyHorizontal 10s infinite ease-in-out;
            }
        }
    </style>
    @stack('styles')
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>

<body
    class="bg-gradient-to-r from-[#ebdffa] via-[#f1f2fa] to-[#d6f4fd] min-h-screen text-slate-900 selection:bg-purple-200">

    <header
        class="fixed top-0 left-0 right-0 z-50 bg-white/60 backdrop-blur-md border-b border-white/40 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <div class="flex items-center gap-2 cursor-pointer">
                    <div
                        class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-indigo-200">
                        <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0 -1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0 -1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                            </path>
                            <path d="M20 2v4"></path>
                            <path d="M22 4h-4"></path>
                            <circle cx="4" cy="20" r="2"></circle>
                        </svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-[#2d124d]">
                        ngajak<span class="text-indigo-600">.my.id</span>
                    </span>
                </div>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                    <a href="{{ url('/') }}#features" class="hover:text-indigo-600 transition">Fitur</a>
                    <a href="{{ route('themes.index') }}" class="hover:text-indigo-600 transition">Template</a>
                    <a href="{{ route('pricing') }}" class="hover:text-indigo-600 transition">Harga</a>
                </nav>

                <div class="hidden md:flex items-center gap-4 text-sm font-medium">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-slate-700 hover:text-indigo-600 transition py-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 border border-indigo-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div
                                class="absolute right-0 top-full mt-0 w-48 bg-white rounded-xl shadow-2xl border border-slate-100 py-2 hidden group-hover:block z-50">
                                <div class="px-4 py-2 border-b border-slate-50">
                                    <p class="text-xs text-slate-400">Akun Anda</p>
                                    <p class="text-sm font-bold text-slate-700 truncate">{{ Auth::user()->name }}</p>
                                </div>

                                {{-- LOGIKA ROLE --}}
                                @php
                                    $user = Auth::user();
                                    // Tentukan route dashboard berdasarkan role
                                    $dashboardRoute = match (true) {
                                        $user->hasRole('superadmin') => route('superadmin.dashboard'),
                                        $user->hasRole('reseller') => route('reseller.dashboard'),
                                        default => route('customer.dashboard'),
                                    };
                                @endphp

                                {{-- Menu Dashboard --}}
                                <a href="{{ $dashboardRoute }}"
                                    class="group flex items-center gap-3 px-4 py-2.5 text-slate-600 hover:bg-indigo-50 hover:text-indigo-700 transition-all duration-200">
                                    <svg class="w-4 h-4 opacity-70 group-hover:opacity-100" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span class="font-medium">Dashboard</span>
                                </a>

                                {{-- Garis pembatas tipis --}}
                                <div class="my-1 border-t border-slate-100"></div>

                                {{-- Menu Logout --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="font-medium">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-slate-700 hover:text-indigo-600 transition">Masuk</a>
                        <a href="/register"
                            class="bg-[#4c229a] hover:bg-[#3b1979] text-white px-5 py-2.5 rounded-full shadow-lg shadow-indigo-100 transition duration-300">
                            Mulai gratis
                        </a>
                    @endauth
                </div>

                <div class="flex md:hidden">
                    <button id="mobile-menu-button" type="button"
                        class="text-slate-700 hover:text-indigo-600 p-2 rounded-lg focus:outline-none"
                        aria-label="Toggle Menu">
                        <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-6 h-6 block">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" class="w-6 h-6 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <div id="mobile-menu"
            class="hidden md:hidden border-t border-slate-200/50 bg-white/95 backdrop-blur-lg px-4 pt-4 pb-6 shadow-xl space-y-4">
            <nav class="flex flex-col gap-4 text-base font-medium text-slate-600">
                <a href="{{ url('/') }}#features"
                    class="mobile-nav-link hover:text-indigo-600 transition py-1">Fitur</a>
                <a href="{{ route('themes.index') }}"
                    class="mobile-nav-link hover:text-indigo-600 transition py-1">Template</a>
                <a href="{{ route('pricing') }}"
                    class="mobile-nav-link hover:text-indigo-600 transition py-1">Harga</a>
            </nav>
            <hr class="border-slate-200/60">
            <div class="flex flex-col gap-3 font-medium">
                @auth
                    @php $user = Auth::user(); @endphp

                    @if ($user->hasRole('superadmin'))
                        <a href="{{ route('superadmin.dashboard') }}"
                            class="mobile-nav-link text-center text-slate-700 py-2 rounded-lg border border-slate-200">
                            Kembali ke Dashboard
                        </a>
                    @elseif($user->hasRole('reseller'))
                        <a href="{{ route('reseller.dashboard') }}"
                            class="mobile-nav-link text-center text-slate-700 py-2 rounded-lg border border-slate-200">
                            Kembali ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}"
                            class="mobile-nav-link text-center text-slate-700 py-2 rounded-lg border border-slate-200">
                            Kembali ke Dashboard {{ $user->name }}
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-center bg-red-600 text-white py-2.5 rounded-full shadow-md">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/login"
                        class="mobile-nav-link text-center text-slate-700 py-2 rounded-lg border border-slate-200">Masuk</a>
                    <a href="/register" class="text-center bg-[#4c229a] text-white py-2.5 rounded-full shadow-md">Mulai
                        gratis</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-12 text-center">
        @yield('content')
    </main>

    <footer class="w-full bg-white/60 backdrop-blur-xl border-t border-white/40 mt-28 shadow-lg shadow-slate-200/20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 text-left">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 pb-12">
                <div class="md:col-span-2 pr-0 md:pr-12">
                    <div class="flex items-center gap-2 cursor-pointer mb-4">
                        <div
                            class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-indigo-100">
                            <svg class="w-3.5 h-3.5 text-white" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0 -1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                                </path>
                                <path d="M20 2v4"></path>
                                <path d="M22 4h-4"></path>
                                <circle cx="4" cy="20" r="2"></circle>
                            </svg>
                        </div>
                        <span class="font-bold text-lg tracking-tight text-[#2d124d]">ngajak<span
                                class="text-indigo-600">.my.id</span></span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-sm">
                        Platform undangan digital premium untuk momen yang layak dikenang. Cepat, elegan, interaktif.
                    </p>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Produk</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm font-medium text-slate-600">
                        <li><a href="{{ route('themes.index') }}"
                                class="hover:text-indigo-600 transition">Template</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-indigo-600 transition">Harga</a></li>
                        <li><a href="/register" class="hover:text-indigo-600 transition">Mulai gratis</a></li>
                        <li><a href="/login" class="hover:text-indigo-600 transition">Masuk</a></li>
                    </ul>
                </div>

                <div class="flex flex-col gap-8">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Gabung Tim</h4>
                        <ul class="space-y-2.5 text-xs sm:text-sm font-medium text-slate-600">
                            <li><a href="/register" class="hover:text-indigo-600 transition">Jadi Kontributor</a></li>
                            <li><a href="/register" class="hover:text-indigo-600 transition">Jadi Reseller</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Perusahaan</h4>
                        <p class="text-xs sm:text-sm font-semibold text-slate-800 mb-1">PT Berkah Teknologi Terdepan
                        </p>
                        <a href="mailto:support@ngajak.my.id"
                            class="text-xs sm:text-sm text-slate-500 hover:text-indigo-600 transition">support@ngajak.my.id</a>
                    </div>
                </div>
            </div>

            <div
                class="border-t border-white/40 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] sm:text-xs text-slate-400 font-medium">
                <div>&copy; 2026 PT Berkah Teknologi Terdepan. All rights reserved.</div>
                <div>by <a href="#" class="text-purple-600 font-semibold hover:underline">futurecloud.id</a>
                </div>
            </div>
        </div>
    </footer>


    @include('components.chatbot')

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');
            const mobileLinks = document.querySelectorAll('.mobile-nav-link');

            function toggleMenu() {
                const isHidden = mobileMenu.classList.contains('hidden');

                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    hamburgerIcon.classList.replace('block', 'hidden');
                    closeIcon.classList.replace('hidden', 'block');
                } else {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.replace('hidden', 'block');
                    closeIcon.classList.replace('block', 'hidden');
                }
            }

            menuButton.addEventListener('click', toggleMenu);

            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (!mobileMenu.classList.contains('hidden')) {
                        toggleMenu();
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
