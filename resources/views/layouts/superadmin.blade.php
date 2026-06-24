<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Superadmin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-serif {
            font-family: 'Instrument Serif', serif;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function showLockedAlert(featureName, upgradeUrl) {
            Swal.fire({
                title: 'Fitur Terkunci',
                text: 'Anda tidak memiliki akses ke fitur ' + featureName + '. Silakan upgrade paket Anda.',
                icon: 'lock',
                iconHtml: '🔒',
                showCancelButton: true,
                confirmButtonColor: '#6d28d9',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Upgrade Paket',
                cancelButtonText: 'Batal',
                customClass: {
                    title: 'font-serif text-2xl text-slate-800',
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-full px-6 font-semibold',
                    cancelButton: 'rounded-full px-6 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed && upgradeUrl) {
                    window.location.href = upgradeUrl;
                }
            });
        }
    </script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>

<body
    class="text-slate-800 antialiased bg-gradient-to-br from-[#f4e6fa] via-[#e5f4fd] to-[#d6fbfb] min-h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-[260px] bg-white flex flex-col shrink-0 min-h-screen border-r border-slate-100 z-10">
        <div class="p-6 flex items-center gap-3 mb-4">
            <div
                class="w-8 h-8 rounded-full bg-[#6d28d9] text-white flex items-center justify-center shadow-md shadow-purple-500/30">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0 -1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z">
                    </path>
                    <path d="M20 2v4"></path>
                    <path d="M22 4h-4"></path>
                    <circle cx="4" cy="20" r="2"></circle>
                </svg>
            </div>
            <span class="font-serif text-[26px] font-bold text-slate-900 tracking-tight leading-none mt-1">ngajak<span
                    class="text-[#6d28d9]">.my.id</span></span>
        </div>

        <div class="px-6 pb-2">
            <span
                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-50 px-2.5 py-1 rounded-md border border-slate-200/40">Superadmin</span>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scroll mt-2">
            {{-- Dashboard --}}
            <a href="{{ route('superadmin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z">
                    </path>
                </svg>
                Dashboard
            </a>

            {{-- Kelola Undangan --}}
            <a href="{{ route('superadmin.kelola-undangan.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('superadmin.kelola-undangan.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Kelola Undangan
            </a>

            {{-- Reseller & Customer --}}
            <a href="{{ route('superadmin.user.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('superadmin.user.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Reseller & Customer
            </a>

            {{-- Template Desain --}}
            <a href="{{ route('superadmin.themes.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('superadmin.themes.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                    </path>
                </svg>
                Template Desain
            </a>

            {{-- Kelola Paket --}}
            <a href="{{ route('superadmin.packages.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('superadmin.packages.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fa-solid fa-box-open text-[16px] w-[18px] text-center"></i>
                Kelola Paket
            </a>

            {{-- Kelola Pembayaran --}}
            <a href="{{ route('superadmin.transactions.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('superadmin.transactions.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fa-solid fa-money-bill-transfer text-[16px] w-[18px] text-center"></i>
                Kelola Pembayaran
            </a>

            {{-- Kelola Chatbot --}}
            <a href="{{ route('superadmin.chatbot.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('superadmin.chatbot.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fa-solid fa-robot text-[16px] w-[18px] text-center"></i>
                Kelola Chatbot
            </a>
        </nav>

        <div class="p-6 shrink-0">
            <a href="{{ route('superadmin.kelola-undangan.create') }}"
                class="w-full py-2.5 bg-white border border-slate-200 rounded-full text-[13px] font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 flex justify-center items-center gap-2 mb-4 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                New invitation
            </a>
            <div class="border border-slate-200 rounded-[1.25rem] p-4 shadow-sm bg-white">
                <div class="text-[11px] text-slate-500 mb-2 truncate font-medium">
                    {{ Auth::user()->email ?? 'superadmin@ngajak.com' }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 text-[12px] font-medium text-slate-600 hover:text-[#6d28d9] transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 relative overflow-y-auto custom-scroll h-screen p-8 md:p-12 lg:p-16">
        @yield('content')
    </main>

</body>

</html>
