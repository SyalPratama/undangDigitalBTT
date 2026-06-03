@extends('layouts.landing')

@section('title', 'Ngajak.com | Cinematic Digital Invitation')

@section('content')
    <!-- Hero Badge -->
    <div
        class="inline-flex items-center gap-1.5 bg-white/60 backdrop-blur-md border border-white px-3 py-1 rounded-full text-xs font-medium text-slate-600 shadow-xs mb-8">
        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
        <span class="font-semibold text-purple-700">New</span> — AI Invitation generator
        <span class="text-slate-400 font-normal">(preview)</span>
    </div>

    <!-- Hero Heading -->
    <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-[#1a0836] max-w-3xl mx-auto leading-[1.15]">
        Invitations that
        <span
            class="serif-italic bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent font-semibold">
            move
        </span>
        people.
    </h1>

    <p class="mt-6 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
        Cinematic digital invitations with realtime RSVP, live guestbook, music, QR, and luxurious motion. Built for moments
        worth remembering.
    </p>

    <!-- Main CTAs -->
    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
        <button
            class="w-full sm:w-auto bg-[#4c229a] hover:bg-[#3b1979] text-white px-8 py-4 rounded-full font-medium shadow-xl shadow-purple-900/10 transition duration-300 flex items-center justify-center gap-2 group">
            Create your invitation
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
        <button
            class="w-full sm:w-auto bg-white/80 hover:bg-white backdrop-blur-sm text-slate-800 px-8 py-4 rounded-full font-medium border border-slate-200/60 shadow-sm transition duration-300">
            Explore templates
        </button>
    </div>

    <!-- Stepper Visual Journey -->
    <div
        class="mt-20 bg-white/70 backdrop-blur-xl border border-white/80 rounded-3xl p-6 sm:p-8 shadow-[0_20px_50px_rgba(0,0,0,0.04)] max-w-4xl mx-auto">

        <p class="text-xs font-bold tracking-widest text-purple-600/80 uppercase mb-8">
            Perjalanan Undangan Anda
        </p>

        <div
            class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6 md:gap-4 px-2 sm:px-6 before:absolute before:left-[23px] md:before:left-0 before:top-0 before:bottom-0 md:before:top-6 md:before:bottom-auto before:w-[2px] md:before:w-full before:h-full md:before:h-[2px] before:bg-slate-200 before:-z-10">

            <!-- Plane Indicator -->
            <div
                class="anim-plane absolute z-20 w-8 h-8 rounded-full bg-purple-600 border-2 border-white flex items-center justify-center text-white shadow-md shadow-purple-300 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                    class="w-4 h-4 transform -rotate-45 translate-x-[1px] -translate-y-[1px]">
                    <path
                        d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                </svg>
            </div>

            <!-- Steps -->
            <div class="flex md:flex-col items-center gap-4 md:gap-3 w-full md:w-auto relative z-10">
                <div
                    class="anim-step-1 w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-800">Dibuat</span>
            </div>

            <div class="flex md:flex-col items-center gap-4 md:gap-3 w-full md:w-auto relative z-10">
                <div
                    class="anim-step-2 w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">Dibagikan</span>
            </div>

            <div class="flex md:flex-col items-center gap-4 md:gap-3 w-full md:w-auto relative z-10">
                <div
                    class="anim-step-3 w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">Terkirim</span>
            </div>

            <div class="flex md:flex-col items-center gap-4 md:gap-3 w-full md:w-auto relative z-10">
                <div
                    class="anim-step-4 w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">Dibuka</span>
            </div>

            <div class="flex md:flex-col items-center gap-4 md:gap-3 w-full md:w-auto relative z-10">
                <div
                    class="anim-step-5 w-12 h-12 rounded-full flex items-center justify-center border-2 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-slate-500">RSVP</span>
            </div>

        </div>

        <!-- Stepper Analytics -->
        <div class="mt-10 pt-6 border-t border-slate-200/60 flex flex-wrap items-center justify-center gap-3">
            <div
                class="inline-flex items-center gap-1.5 bg-purple-50 border border-purple-100 text-xs font-semibold text-purple-700 px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                120 tamu merespon
            </div>
            <div class="bg-slate-100 text-xs font-medium text-slate-600 px-3 py-1.5 rounded-full">
                Realtime &bull; Tanpa refresh
            </div>
        </div>

    </div>

    <!-- Features Section -->
    <div id="features" class="mt-28">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-[#1a0836]">
            Every detail, considered.
        </h2>
        <p class="mt-2 text-sm sm:text-base text-slate-500 max-w-xl mx-auto">
            A complete platform from invitation builder to live event experience.
        </p>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto text-left">
            <!-- Feature 1 -->
            <div
                class="bg-white/70 backdrop-blur-md border border-white/80 p-6 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] transition hover:translate-y-[-2px] duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-[#4c229a] text-white flex items-center justify-center mb-4 shadow-md shadow-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </div>
                <h3 class="font-bold text-base text-slate-900 mb-1">Visual Builder</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Drag, edit, preview. No design skills required.</p>
            </div>

            <!-- Feature 2 -->
            <div
                class="bg-white/70 backdrop-blur-md border border-white/80 p-6 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] transition hover:translate-y-[-2px] duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-[#4c229a] text-white flex items-center justify-center mb-4 shadow-md shadow-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </div>
                <h3 class="font-bold text-base text-slate-900 mb-1">Realtime RSVP</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Live attendance, guestbook, and analytics.</p>
            </div>

            <!-- Feature 3 -->
            <div
                class="bg-white/70 backdrop-blur-md border border-white/80 p-6 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] transition hover:translate-y-[-2px] duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-[#4c229a] text-white flex items-center justify-center mb-4 shadow-md shadow-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 9l10.5-3m0 0v11.25m0-11.25L9 12M9 12v6.25M9 12L3 14m12-6.75V12m-6 3.75H3.75a1.125 1.125 0 01-1.125-1.125V11.25M9 15.75v3A1.125 1.125 0 017.875 20H3.75a1.125 1.125 0 01-1.125-1.125V15.75m6 0H3.75" />
                    </svg>
                </div>
                <h3 class="font-bold text-base text-slate-900 mb-1">Cinematic Mood</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Autoplay music, floating particles, smooth scroll.</p>
            </div>

            <!-- Feature 4 -->
            <div
                class="bg-white/70 backdrop-blur-md border border-white/80 p-6 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] transition hover:translate-y-[-2px] duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-[#4c229a] text-white flex items-center justify-center mb-4 shadow-md shadow-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z" />
                    </svg>
                </div>
                <h3 class="font-bold text-base text-slate-900 mb-1">QR & Personal URLs</h3>
                <p class="text-xs text-slate-500 leading-relaxed">/invite?to=Michael — every guest greeted by name.</p>
            </div>

            <!-- Feature 5 -->
            <div
                class="bg-white/70 backdrop-blur-md border border-white/80 p-6 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] transition hover:translate-y-[-2px] duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-[#4c229a] text-white flex items-center justify-center mb-4 shadow-md shadow-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
                <h3 class="font-bold text-base text-slate-900 mb-1">Live Guestbook</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Wishes flow in realtime as guests RSVP.</p>
            </div>

            <!-- Feature 6 -->
            <div
                class="bg-white/70 backdrop-blur-md border border-white/80 p-6 rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.02)] transition hover:translate-y-[-2px] duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-[#4c229a] text-white flex items-center justify-center mb-4 shadow-md shadow-purple-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499c.173-.439.61-.724 1.082-.724s.909.285 1.082.724l2.43 6.161 6.64.966c.47.068.854.4.98.856.125.456-.004.948-.346 1.286l-4.804 4.681 1.134 6.613c.08.468-.109.938-.485 1.211a1.122 1.122 0 01-1.175.068L12 18.254l-5.94 3.123a1.122 1.122 0 01-1.175-.068c-.376-.273-.564-.743-.485-1.211l1.134-6.613-4.804-4.681c-.342-.338-.47-.83-.346-1.286.126-.456.51-.788.98-.856l6.64-.966 2.43-6.161z" />
                    </svg>
                </div>
                <h3 class="font-bold text-base text-slate-900 mb-1">Luxury Templates</h3>
                <p class="text-xs text-slate-500 leading-relaxed">Wedding, corporate, birthday, more. Premium & free.</p>
            </div>
        </div>
    </div>

    <!-- CTA & Pricing Promo -->
    <div id="pricing"
        class="mt-20 bg-white/70 backdrop-blur-xl border border-white/80 rounded-3xl p-8 sm:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.02)] max-w-4xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-[#1a0836]">
            Paket untuk setiap acara.
        </h2>
        <p class="mt-3 text-xs sm:text-sm text-slate-500 max-w-2xl mx-auto leading-relaxed">
            Mulai dari Basic untuk acara intim hingga Enterprise untuk reseller & event organizer.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <button
                class="w-full sm:w-auto bg-[#4c229a] hover:bg-[#3b1979] text-white px-6 py-3 rounded-full text-sm font-medium shadow-md transition duration-300 flex items-center justify-center gap-2">
                Lihat semua paket
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
            <button
                class="w-full sm:w-auto bg-white/90 hover:bg-white text-slate-800 px-6 py-3 rounded-full text-sm font-medium border border-slate-200 shadow-sm transition duration-300">
                Coba gratis
            </button>
        </div>
    </div>
@endsection
