<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Dashboard') - ngajak.com</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Instrument Serif', serif; }
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: transparent; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; }
    </style>
</head>
<body class="text-slate-800 antialiased bg-gradient-to-br from-[#f4e6fa] via-[#e5f4fd] to-[#d6fbfb] min-h-screen flex overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-[260px] bg-white flex flex-col shrink-0 min-h-screen border-r border-slate-100 z-10">
        <div class="p-6 flex items-center gap-3 mb-4">
            <div class="w-8 h-8 rounded-full bg-[#6d28d9] text-white flex items-center justify-center shadow-md shadow-purple-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="font-serif text-[26px] font-bold text-slate-900 tracking-tight leading-none mt-1">ngajak<span class="text-[#6d28d9]">.com</span></span>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scroll">
            {{-- Dashboard --}}
            <a href="{{ route('customer.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('customer.dashboard') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                Dashboard
            </a>

            {{-- Templates --}}
            <a href="{{ route('customer.templates.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('customer.templates.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                Templates
            </a>

            {{-- Invitations --}}
            <a href="{{ route('customer.kelola-undangan.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('customer.kelola-undangan.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Invitations
            </a>

            {{-- Paket Saya --}}
            <a href="{{ route('customer.paket.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('customer.paket.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Paket Saya
            </a>

            {{-- Jadi Kontributor --}}
            <a href="{{ route('customer.kontributor.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('customer.kontributor.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Jadi Kontributor
            </a>

            {{-- Reseller --}}
            <a href="{{ route('customer.reseller.index') }}"
                class="flex items-center gap-3 px-4 py-3 text-[14px] font-medium rounded-full transition-all duration-200
                {{ request()->routeIs('customer.user.*') ? 'bg-[#6d28d9] text-white shadow-md shadow-purple-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Reseller
            </a>
        </nav>

        <div class="p-6 shrink-0">
            <a href="{{ route('customer.kelola-undangan.index') }}" class="w-full py-2.5 bg-white border border-slate-200 rounded-full text-[13px] font-semibold text-slate-700 hover:bg-slate-50 hover:text-slate-900 flex justify-center items-center gap-2 mb-4 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                New invitation
            </a>
            <div class="border border-slate-200 rounded-[1.25rem] p-4 shadow-sm bg-white">
                <div class="text-[11px] text-slate-500 mb-2 truncate font-medium">{{ Auth::user()->email ?? 'customer@ngajak.com' }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-[12px] font-medium text-slate-600 hover:text-[#6d28d9] transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
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
