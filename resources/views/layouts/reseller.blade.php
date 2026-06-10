<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Reseller Dashboard') - NikahDigital</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfbf9;
            /* Warna base stone/sand hangat yang sangat soft */
        }

        .font-serif {
            font-family: 'Instrument Serif', serif;
        }

        /* Custom Scrollbar minimalis untuk area konten */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #e7e5e4;
            border-radius: 20px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #d6d3d1;
        }
    </style>
</head>

<body class="text-stone-700 antialiased selection:bg-emerald-100 selection:text-emerald-900">

    <div class="flex min-h-screen relative overflow-hidden p-0 md:p-4 gap-4">

        <div id="sidebarBackdrop"
            class="fixed inset-0 bg-stone-900/30 backdrop-blur-md z-40 hidden transition-opacity duration-300 md:hidden">
        </div>

        <aside id="sidebarMenu"
            class="fixed inset-y-0 left-0 w-66 bg-white/95 backdrop-blur-xl border border-stone-200/50 md:rounded-2xl flex flex-col justify-between z-50 transform -translate-x-full transition-all duration-300 ease-in-out md:translate-x-0 md:static md:flex shadow-[0_8px_30px_rgb(0,0,0,0.02)]">

            <div>
                <div class="p-6 border-b border-stone-100/80 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="p-2.5 bg-gradient-to-br from-emerald-50 to-emerald-100/50 text-emerald-700 rounded-xl shrink-0 shadow-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75">
                                </path>
                            </svg>
                        </div>

                        <div>
                            <span class="font-serif text-2xl font-bold tracking-wide text-stone-800">Undangan<span
                                    class="text-emerald-600 font-sans text-xs font-semibold uppercase tracking-wider block -mt-1">Digital</span></span>
                        </div>
                    </div>

                    <button id="closeSidebarBtn"
                        class="p-1.5 text-stone-400 hover:text-stone-700 rounded-xl hover:bg-stone-50 md:hidden transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="px-6 pt-4">
                    <span
                        class="text-[10px] font-bold text-stone-400 uppercase tracking-widest bg-stone-50 px-2.5 py-1 rounded-md border border-stone-200/40">Reseller
                        Workspace</span>
                </div>

                <nav class="p-4 space-y-1.5 mt-2">
                    {{-- MENU: Dashboard --}}
                    <a href="{{ route('reseller.dashboard') }}"
                        class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200
                        {{ request()->routeIs('reseller.dashboard')
                            ? 'bg-gradient-to-r from-emerald-50 to-emerald-100/30 text-emerald-900 border-l-4 border-emerald-600 pl-3 font-semibold'
                            : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900 hover:translate-x-1' }}">
                        <svg class="w-5 h-5 transition-colors {{ request()->routeIs('reseller.dashboard') ? 'text-emerald-600' : 'text-stone-400 group-hover:text-stone-600' }}"
                            fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    {{-- MENU: Kelola Undangan --}}
                    <a href="{{ route('reseller.kelola-undangan.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200
                        {{ request()->routeIs('reseller.kelola-undangan.*')
                            ? 'bg-gradient-to-r from-emerald-50 to-emerald-100/30 text-emerald-900 border-l-4 border-emerald-600 pl-3 font-semibold'
                            : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900 hover:translate-x-1' }}">
                        <svg class="w-5 h-5 transition-colors {{ request()->routeIs('reseller.undangan.*') ? 'text-emerald-600' : 'text-stone-400 group-hover:text-stone-600' }}"
                            fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Kelola Undangan
                    </a>

                    {{-- MENU: Customer --}}
                    <a href="{{ route('reseller.user.index') }}"
                        class="group flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200
                        {{ request()->routeIs('reseller.user.*')
                            ? 'bg-gradient-to-r from-emerald-50 to-emerald-100/30 text-emerald-900 border-l-4 border-emerald-600 pl-3 font-semibold'
                            : 'text-stone-500 hover:bg-stone-50 hover:text-stone-900 hover:translate-x-1' }}">
                        <svg class="w-5 h-5 transition-colors {{ request()->routeIs('reseller.user.*') ? 'text-emerald-600' : 'text-stone-400 group-hover:text-stone-600' }}"
                            fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Customer
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-stone-100/80">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-stone-600 bg-stone-50 hover:bg-rose-50 hover:text-rose-600 border border-stone-200/60 hover:border-rose-200/50 rounded-xl transition-all duration-200 cursor-pointer shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </aside>

        <div
            class="flex-1 flex flex-col min-w-0 bg-white border border-stone-200/60 md:rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.015)] overflow-hidden">

            <header
                class="bg-white/80 backdrop-blur-md border-b border-stone-100 h-16 flex items-center justify-between px-6 shrink-0 z-10">
                <div class="flex items-center gap-4">
                    <button id="openSidebarBtn"
                        class="p-2 text-stone-600 hover:bg-stone-50 border border-stone-200/40 rounded-xl md:hidden transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-sm font-bold text-stone-800 tracking-tight sm:text-base">
                            Selamat Datang, {{ explode(' ', trim(Auth::user()->name))[0] }}!
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span
                            class="text-xs font-semibold text-stone-800 leading-tight">{{ Auth::user()->name }}</span>
                        <span
                            class="text-[10px] font-medium text-emerald-600 bg-emerald-50 border border-emerald-200/40 px-1.5 py-0.5 rounded-md mt-0.5 self-end">Reseller</span>
                    </div>
                    <div
                        class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-600 to-emerald-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-emerald-600/10 border-2 border-white ring-1 ring-stone-200/50">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 overflow-y-auto custom-scroll bg-stone-50/40 relative"
                style="background-image: 
                    linear-gradient(to right, rgba(120, 113, 108, 0.04) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(120, 113, 108, 0.04) 1px, transparent 1px);
                background-size: 24px 24px;">

                <div
                    class="absolute inset-0 bg-radial from-transparent via-transparent to-stone-50/20 pointer-events-none">
                </div>

                <div class="relative z-10">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarMenu = document.getElementById('sidebarMenu');
            const openSidebarBtn = document.getElementById('openSidebarBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');
            const sidebarBackdrop = document.getElementById('sidebarBackdrop');

            function toggleSidebar() {
                sidebarMenu.classList.toggle('-translate-x-full');
                sidebarBackdrop.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }

            if (openSidebarBtn && closeSidebarBtn && sidebarBackdrop) {
                openSidebarBtn.addEventListener('click', toggleSidebar);
                closeSidebarBtn.addEventListener('click', toggleSidebar);
                sidebarBackdrop.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>

</html>
