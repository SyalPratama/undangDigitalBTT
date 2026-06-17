<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title ?? 'Birthday Invitation' }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            light: '#F3E5AB',
                            DEFAULT: '#E2B875',
                            dark: '#A3824A',
                            accent: '#D4AF37'
                        },
                        dark: {
                            obsidian: '#030712',
                            card: 'rgba(15, 23, 42, 0.65)',
                            cardSolid: '#0f172a'
                        }
                    },
                    fontFamily: {
                        display: ['Cinzel', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        /* Snap Scroll Base */
        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: none;
        }

        body {
            background-color: #030712;
            color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }

        #scroll-container {
            height: 100vh;
            height: 100svh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
            position: relative;
            z-index: 10;
        }

        #scroll-container::-webkit-scrollbar {
            display: none;
        }

        .section {
            scroll-snap-align: start;
            height: 100vh;
            height: 100svh;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 20px;
        }

        /* Glassmorphic Cards */
        .glass-card {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 184, 117, 0.2);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(226,184,117,0.3) 0%, transparent 40%, rgba(163,130,74,0.3) 100%);
            pointer-events: none;
            z-index: -1;
        }

        /* Animated Particles Canvas Background */
        #particle-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        /* Custom Gold Gradients and Textures */
        .gold-gradient-text {
            background: linear-gradient(135deg, #F3E5AB 0%, #E2B875 50%, #A3824A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 12px rgba(226, 184, 117, 0.1);
        }

        .gold-gradient-btn {
            background: linear-gradient(135deg, #E2B875 0%, #A3824A 100%);
            color: #030712;
            box-shadow: 0 4px 20px rgba(226, 184, 117, 0.35);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gold-gradient-btn:hover {
            background: linear-gradient(135deg, #F3E5AB 0%, #E2B875 100%);
            box-shadow: 0 6px 25px rgba(226, 184, 117, 0.5);
            transform: translateY(-2px);
        }

        /* Envelope Opening Animations */
        .envelope-wrapper {
            transition: transform 1.2s cubic-bezier(0.85, 0, 0.15, 1), opacity 1.2s ease-in-out;
        }

        .envelope-wrapper.open {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        /* Equalizer Audio Visualizer */
        .eq-bar {
            width: 3px;
            background-color: #E2B875;
            animation: bounce-eq 1s ease-in-out infinite alternate;
            transform-origin: bottom;
        }

        .eq-bar:nth-child(2) { animation-delay: 0.2s; animation-duration: 0.8s; }
        .eq-bar:nth-child(3) { animation-delay: 0.4s; animation-duration: 1.2s; }
        .eq-bar:nth-child(4) { animation-delay: 0.1s; animation-duration: 0.9s; }

        @keyframes bounce-eq {
            0% { transform: scaleY(0.2); }
            100% { transform: scaleY(1); }
        }

        /* Ornament Frame Corners */
        .decor-line {
            position: absolute;
            width: 25px;
            height: 25px;
            border: 1px solid #E2B875;
            pointer-events: none;
        }

        /* Glow effects */
        .gold-glow {
            box-shadow: 0 0 15px rgba(226, 184, 117, 0.25);
        }

        /* Form Controls Overrides */
        input::placeholder, textarea::placeholder {
            color: #64748B !important;
        }

        /* Micro Reveal Effects */
        [data-anim] {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 1.1s cubic-bezier(0.16, 1, 0.3, 1), transform 1.1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        [data-anim].shown {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <!-- Gold Particle Canvas -->
    <canvas id="particle-canvas"></canvas>

    <!-- Background Celebration Audio (Happy Birthday Theme) -->
    <audio id="bg-audio" loop preload="auto">
        <!-- Sumber 1: MP3 Premium Acoustic Happy Birthday (Cepat & Stabil) -->
        <source src="https://cdn.pixabay.com/audio/2022/11/09/audio_24a520f922.mp3" type="audio/mpeg">
        <!-- Sumber 2: Fallback Piano Instrumental dari server Wikimedia -->
        <source src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Happy_Birthday_to_You_%28instrumental%29.ogg" type="audio/ogg">
    </audio>

    <!-- Custom Luxury Toast Alert -->
    <div id="toast" class="fixed bottom-24 left-1/2 -translate-x-1/2 translate-y-24 bg-dark-cardSolid border border-gold px-6 py-3 rounded-full z-[9999] opacity-0 pointer-events-none transition-all duration-500 flex items-center gap-3 shadow-[0_10px_30px_rgba(0,0,0,0.8),0_0_20px_rgba(226,184,117,0.2)]">
        <i class="fa-solid fa-bell-ring text-gold"></i>
        <span id="toast-text" class="text-sm font-sans font-medium text-slate-100"></span>
    </div>

    <!-- 0. ELEGANT ENVELOPE OPENING SCREEN -->
    <div id="opening-screen" class="envelope-wrapper fixed inset-0 bg-dark-obsidian z-[1000] flex items-center justify-center p-4">
        <!-- Ambient radial lighting behind card -->
        <div class="absolute w-[250px] md:w-[450px] h-[250px] md:h-[450px] bg-gold-dark/10 blur-[100px] rounded-full top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
        
        <div class="glass-card max-w-[485px] w-full p-8 md:p-12 rounded-2xl text-center relative overflow-hidden flex flex-col items-center">
            <!-- Decorative Corners -->
            <div class="decor-line top-4 left-4 border-r-0 border-b-0"></div>
            <div class="decor-line top-4 right-4 border-l-0 border-b-0"></div>
            <div class="decor-line bottom-4 left-4 border-r-0 border-t-0"></div>
            <div class="decor-line bottom-4 right-4 border-l-0 border-t-0"></div>

            <!-- Crown Icon Top Ornament -->
            <div class="mb-4 text-gold/60 text-2xl">
                <i class="fa-solid fa-crown"></i>
            </div>

            <p class="font-display text-gold tracking-[0.35em] text-xs font-semibold mb-3 uppercase">THE PRIVILEGE OF YOUR PRESENCE</p>
            <h2 class="font-display text-slate-100 text-xl md:text-2xl font-light mb-6 leading-relaxed">WE CORDIALLY INVITE YOU TO THE CELEBRATION OF</h2>
            
            <!-- Dynamic / Blade Replacement Tag for Preview & Backend -->
            <h1 class="font-display gold-gradient-text text-3xl md:text-4xl font-extrabold tracking-wider leading-tight mb-8">
                {{ $invitation->profile->first_name ?? 'NAMA' }}
            </h1>

            <div class="h-[1px] w-1/3 bg-gradient-to-r from-transparent via-gold to-transparent mb-8"></div>

            <p class="text-xs text-slate-400 tracking-wider mb-2 uppercase">Exclusively Invited:</p>
            <p class="font-serif text-lg text-slate-200 italic font-medium mb-8">
                {{ request()->get('to') ?? 'Tamu Undangan' }}
            </p>

            <button class="gold-gradient-btn px-8 py-4 rounded-full font-display font-bold text-xs tracking-[0.25em] flex items-center gap-3 transition-all cursor-pointer" onclick="unlockInvitation()">
                <i class="fa-solid fa-envelope-open text-sm"></i> BUKA UNDANGAN
            </button>
        </div>
    </div>

    <!-- Sound Floating Controller with Visual Equalizer -->
    <button id="floating-music" class="fixed bottom-24 right-5 md:bottom-8 md:right-8 z-50 w-12 h-12 rounded-full bg-dark-obsidian/90 border border-gold flex items-center justify-center text-gold cursor-pointer shadow-[0_4px_20px_rgba(0,0,0,0.5),0_0_15px_rgba(226,184,117,0.2)] hover:scale-115 active:scale-95 transition-all hidden" onclick="handleMusic()">
        <div id="eq-container" class="flex gap-[2px] items-end justify-center h-4 w-5">
            <span class="eq-bar h-2"></span>
            <span class="eq-bar h-3"></span>
            <span class="eq-bar h-1"></span>
            <span class="eq-bar h-4"></span>
        </div>
        <i id="music-fallback-icon" class="fa-solid fa-music text-xs hidden"></i>
    </button>

    <!-- Side Circle Dots Navigation (Desktop Only) -->
    <div id="side-nav" class="fixed right-8 top-1/2 -translate-y-1/2 z-[45] hidden md:flex flex-col gap-4"></div>

    <!-- Luxury Bottom Frosted Navbar (Mobile Only) -->
    <nav id="bottom-nav" class="fixed bottom-0 left-0 right-0 h-20 bg-dark-obsidian/90 border-t border-gold/25 backdrop-blur-2xl z-[45] flex md:hidden justify-around items-center px-4 pb-safe shadow-[0_-10px_30px_rgba(0,0,0,0.5)]">
        <div class="b-nav-item active flex flex-col items-center gap-1 cursor-pointer text-slate-400 transition-all duration-300" onclick="jumpTo(0)" data-section="0">
            <i class="fa-solid fa-star text-base"></i>
            <span class="text-[9px] font-display tracking-widest font-semibold">HERO</span>
        </div>
        <div class="b-nav-item flex flex-col items-center gap-1 cursor-pointer text-slate-400 transition-all duration-300" onclick="jumpTo(1)" data-section="1">
            <i class="fa-solid fa-clock text-base"></i>
            <span class="text-[9px] font-display tracking-widest font-semibold">TIME</span>
        </div>
        <div class="b-nav-item flex flex-col items-center gap-1 cursor-pointer text-slate-400 transition-all duration-300" onclick="jumpTo(2)" data-section="2">
            <i class="fa-solid fa-calendar-days text-base"></i>
            <span class="text-[9px] font-display tracking-widest font-semibold">EVENT</span>
        </div>
        <div class="b-nav-item flex flex-col items-center gap-1 cursor-pointer text-slate-400 transition-all duration-300" onclick="jumpTo(3)" data-section="3">
            <i class="fa-solid fa-envelope-open-text text-base"></i>
            <span class="text-[9px] font-display tracking-widest font-semibold">RSVP</span>
        </div>
    </nav>


    <!-- MAIN INVITATION SCROLL CONTAINER -->
    <div id="scroll-container">

        <!-- 1. HERO MASTHEAD SECTION -->
        <section class="section flex items-center justify-center" id="sec-hero">
            <div class="max-w-[700px] w-full mx-auto text-center z-10 px-4">
                <p class="font-display text-gold tracking-[0.4em] text-xs md:text-sm font-bold mb-4 uppercase" data-anim>BIRTHDAY CELEBRATION</p>
                
                <h1 class="font-display text-4xl md:text-6xl font-light tracking-wide leading-tight mb-6 uppercase text-slate-100" data-anim>
                    {{ strtoupper($invitation->profile->first_name ?? 'SAVE THE') }}<br>
                    <span class="gold-gradient-text font-extrabold tracking-widest block mt-2">
                        {{ strtoupper($invitation->profile->last_name ?? 'DATE') }}
                    </span>
                </h1>

                <div class="w-16 h-[2px] bg-gold/50 mx-auto my-8" data-anim></div>

                <p class="font-serif italic text-base md:text-lg text-slate-300 leading-relaxed max-w-[540px] mx-auto" data-anim>
                    “Counting down the days to celebrate another beautiful year of life, love, and wonderful opportunities ahead with the dearest ones.”
                </p>
            </div>
        </section>

        <!-- 2. COUNTDOWN GRID SECTION -->
        <section class="section flex items-center justify-center" id="sec-countdown">
            <div class="max-w-[800px] w-full mx-auto text-center z-10 px-4">
                <h2 class="font-display text-2xl md:text-3xl font-light text-slate-100 tracking-widest mb-2" data-anim>TIME REMAINING</h2>
                <p class="text-xs text-slate-400 font-sans tracking-[0.2em] mb-10 uppercase" data-anim>Menghitung Hari Menuju Perayaan Istimewa</p>

                <!-- Modern Minimal Card Flippers Grid -->
                <div class="grid grid-cols-4 gap-3 md:gap-6 max-w-[550px] mx-auto" data-anim>
                    <!-- Days -->
                    <div class="glass-card p-4 md:p-6 rounded-xl relative flex flex-col items-center justify-center">
                        <span class="text-3xl md:text-5xl font-display font-bold gold-gradient-text" id="days">00</span>
                        <span class="text-[9px] md:text-[10px] tracking-widest text-slate-400 font-display font-medium mt-2 uppercase">Hari</span>
                    </div>
                    <!-- Hours -->
                    <div class="glass-card p-4 md:p-6 rounded-xl relative flex flex-col items-center justify-center">
                        <span class="text-3xl md:text-5xl font-display font-bold gold-gradient-text" id="hours">00</span>
                        <span class="text-[9px] md:text-[10px] tracking-widest text-slate-400 font-display font-medium mt-2 uppercase">Jam</span>
                    </div>
                    <!-- Minutes -->
                    <div class="glass-card p-4 md:p-6 rounded-xl relative flex flex-col items-center justify-center">
                        <span class="text-3xl md:text-5xl font-display font-bold gold-gradient-text" id="mins">00</span>
                        <span class="text-[9px] md:text-[10px] tracking-widest text-slate-400 font-display font-medium mt-2 uppercase">Menit</span>
                    </div>
                    <!-- Seconds -->
                    <div class="glass-card p-4 md:p-6 rounded-xl relative flex flex-col items-center justify-center">
                        <span class="text-3xl md:text-5xl font-display font-bold gold-gradient-text" id="secs">00</span>
                        <span class="text-[9px] md:text-[10px] tracking-widest text-slate-400 font-display font-medium mt-2 uppercase">Detik</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. DETAILED EVENTS MAPS AND INFOS -->
        <section class="section flex items-center justify-center overflow-y-auto" id="sec-events">
            <div class="max-w-[950px] w-full mx-auto z-10 px-4 py-8">
                <h2 class="font-display gold-gradient-text text-3xl md:text-4xl text-center font-bold tracking-widest mb-1" data-anim>THE DAY</h2>
                <p class="font-serif italic text-sm md:text-base text-slate-400 text-center mb-8" data-anim>Agenda Pelaksanaan Acara</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-[850px] mx-auto" data-anim>
                    @if(isset($invitation) && $invitation->events && $invitation->events->count() > 0)
                        @foreach($invitation->events as $event)
                        <div class="glass-card p-6 md:p-8 rounded-xl flex flex-col justify-between hover:scale-[1.02] transition-transform duration-300">
                            <div>
                                <h3 class="font-display text-lg md:text-xl font-bold tracking-widest text-slate-100 border-b border-gold/20 pb-3 mb-4 flex items-center justify-between">
                                    <span>{{ $event->name }}</span>
                                    <i class="fa-solid fa-cake-candles text-gold/60 text-sm"></i>
                                </h3>
                                <div class="space-y-3 text-slate-300 text-xs md:text-sm leading-relaxed mb-6">
                                    <p class="flex items-center gap-3"><i class="fa-regular fa-calendar text-gold text-base w-5"></i> {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                    <p class="flex items-center gap-3"><i class="fa-regular fa-clock text-gold text-base w-5"></i> {{ $event->start_time }} WIB - Selesai</p>
                                    <p class="flex items-center gap-3"><i class="fa-solid fa-location-dot text-gold text-base w-5"></i> <span><strong>{{ $event->venue_name }}</strong></span></p>
                                    <p class="text-[11px] text-slate-400 pl-8 leading-normal">{{ $event->address }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 mt-auto pt-4">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->address) }}" target="_blank" class="w-full text-center py-3 bg-gold/10 hover:bg-gold hover:text-dark-obsidian border border-gold text-gold rounded-lg text-xs font-display font-bold tracking-wider transition-all flex items-center justify-center gap-2">
                                    GOOGLE MAPS <i class="fa-solid fa-location-arrow"></i>
                                </a>
                                <button onclick="openGiftModal()" class="w-full text-center py-3 bg-gradient-to-r from-gold to-gold-dark hover:from-gold-light hover:to-gold border border-gold/50 text-dark-obsidian rounded-lg text-xs font-display font-bold tracking-wider transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    KIRIM KADO <i class="fa-solid fa-gift"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- STATIC FALLBACK PREVIEW CARD -->
                        <div class="glass-card p-6 md:p-8 rounded-xl flex flex-col justify-between hover:scale-[1.02] transition-transform duration-300">
                            <div>
                                <h3 class="font-display text-lg md:text-xl font-bold tracking-widest text-slate-100 border-b border-gold/20 pb-3 mb-4 flex items-center justify-between">
                                    <span>Main Birthday Party</span>
                                    <i class="fa-solid fa-cake-candles text-gold/60 text-sm"></i>
                                </h3>
                                <div class="space-y-3 text-slate-300 text-xs md:text-sm leading-relaxed mb-6">
                                    <p class="flex items-center gap-3"><i class="fa-regular fa-calendar text-gold text-base w-5"></i> Sabtu, 20 Juni 2026</p>
                                    <p class="flex items-center gap-3"><i class="fa-regular fa-clock text-gold text-base w-5"></i> 19.00 WIB - Selesai</p>
                                    <p class="flex items-center gap-3"><i class="fa-solid fa-location-dot text-gold text-base w-5"></i> <span><strong>Grand Ballroom Luxury Hotel</strong></span></p>
                                    <p class="text-[11px] text-slate-400 pl-8 leading-normal">Jl. Jend. Sudirman No. 123, SCBD, Jakarta Selatan</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2 mt-auto pt-4">
                                <a href="https://www.google.com/maps/search/?api=1&query=Grand+Ballroom+Luxury+Hotel+Jakarta" target="_blank" class="w-full text-center py-3 bg-gold/10 hover:bg-gold hover:text-dark-obsidian border border-gold text-gold rounded-lg text-xs font-display font-bold tracking-wider transition-all flex items-center justify-center gap-2">
                                    GOOGLE MAPS <i class="fa-solid fa-location-arrow"></i>
                                </a>
                                <button onclick="openGiftModal()" class="w-full text-center py-3 bg-gradient-to-r from-gold to-gold-dark hover:from-gold-light hover:to-gold border border-gold/50 text-dark-obsidian rounded-lg text-xs font-display font-bold tracking-wider transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    KIRIM KADO <i class="fa-solid fa-gift"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- 4. RSVP AND FRIEND WISHES GUESTBOOK -->
        <section class="section flex items-center justify-center overflow-y-auto" id="sec-rsvp">
            <div class="max-w-[950px] w-full mx-auto z-10 px-4 py-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch max-w-[850px] mx-auto">
                    <!-- RSVP CARD FORM -->
                    <div class="glass-card p-6 md:p-8 rounded-xl" data-anim>
                        <h3 class="font-display gold-gradient-text text-xl md:text-2xl text-center font-bold tracking-widest mb-6">RSVP CONFIRMATION</h3>
                        
                        <form id="form-rsvp" onsubmit="submitRsvp(event)" class="space-y-4">
                            <div class="space-y-1">
                                <label class="text-xs font-display tracking-widest text-slate-300 uppercase">Nama Lengkap</label>
                                <input type="text" id="rsvp-name" class="w-full bg-dark-obsidian/60 border border-gold/30 text-slate-100 rounded-lg p-3 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-all" placeholder="Tulis nama lengkap Anda" value="{{ request()->get('to') }}" required>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-display tracking-widest text-slate-300 uppercase">Konfirmasi Kehadiran</label>
                                <select id="rsvp-status" class="w-full bg-dark-obsidian/60 border border-gold/30 text-slate-100 rounded-lg p-3 text-sm focus:border-gold outline-none transition-all cursor-pointer" required>
                                    <option value="" disabled selected class="bg-dark-obsidian text-slate-400">Pilih salah satu</option>
                                    <option value="hadir" class="bg-dark-obsidian text-slate-100">Hadir</option>
                                    <option value="tidak_hadir" class="bg-dark-obsidian text-slate-100">Berhalangan Hadir</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-display tracking-widest text-slate-300 uppercase">Ucapan & Doa Hangat</label>
                                <textarea id="rsvp-message" rows="3" class="w-full bg-dark-obsidian/60 border border-gold/30 text-slate-100 rounded-lg p-3 text-sm focus:border-gold focus:ring-1 focus:ring-gold outline-none transition-all resize-none" placeholder="Berikan doa atau pesan terbaik Anda..."></textarea>
                            </div>

                            <button type="submit" class="w-full text-center py-4 bg-gradient-to-r from-gold to-gold-dark hover:from-gold-light hover:to-gold text-dark-obsidian font-display font-bold text-xs tracking-widest rounded-lg transition-all cursor-pointer shadow-[0_4px_15px_rgba(226,184,117,0.2)]">
                                KIRIM KONFIRMASI <i class="fa-solid fa-paper-plane ml-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- GUESTBOOK REALTIME WISHES STREAM -->
                    <div id="wishes-display" class="glass-card p-6 md:p-8 rounded-xl flex flex-col justify-between" data-anim>
                        <div>
                            <h3 class="font-display gold-gradient-text text-xl md:text-2xl text-center font-bold tracking-widest mb-6">WISHES STREAM</h3>
                            
                            <!-- Custom dynamic scrollbar container -->
                            <div id="wishes-list" class="space-y-4 max-h-[280px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gold scrollbar-track-transparent">
                                <div class="wish-item bg-white/5 border border-white/5 p-4 rounded-lg border-l-2 border-l-gold">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="wish-name font-bold text-xs font-display tracking-widest text-gold">ALEX EMMANUEL</div>
                                        <span class="text-[9px] bg-gold/10 text-gold px-2 py-0.5 rounded-full font-display">HADIR</span>
                                    </div>
                                    <div class="wish-text text-xs italic text-slate-300 leading-relaxed font-sans">
                                        "Happy birthday! Semoga sukses selalu, dimudahkan jalannya di perkuliahan, dan sehat selalu bro!"
                                    </div>
                                </div>
                                <div class="wish-item bg-white/5 border border-white/5 p-4 rounded-lg border-l-2 border-l-gold">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="wish-name font-bold text-xs font-display tracking-widest text-gold">SARAH OLIVIA</div>
                                        <span class="text-[9px] bg-gold/10 text-gold px-2 py-0.5 rounded-full font-display">HADIR</span>
                                    </div>
                                    <div class="wish-text text-xs italic text-slate-300 leading-relaxed font-sans">
                                        "Selamat bertambah usia! Semoga harimu menyenangkan dan berkah selalu mengalir untukmu."
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-4 border-t border-gold/15 mt-4">
                            <p class="text-[10px] tracking-widest font-display text-slate-400">TERIMA KASIH ATAS DOA & PARTISIPASI ANDA</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- DIGITAL GIFT REGISTRY POPUP MODAL -->
    <div id="gift-modal" class="fixed inset-0 z-[10000] bg-dark-obsidian/85 backdrop-blur-md flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300">
        <div class="glass-card max-w-[420px] w-full p-6 md:p-8 rounded-2xl relative overflow-hidden text-center transform scale-95 transition-all duration-300" id="gift-modal-card">
            <button onclick="closeGiftModal()" class="absolute top-4 right-4 text-slate-400 hover:text-gold text-lg cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <i class="fa-solid fa-gift text-gold text-3xl mb-4"></i>
            <h3 class="font-display gold-gradient-text text-xl font-bold tracking-widest mb-2">KADO DIGITAL</h3>
            <p class="text-xs text-slate-400 leading-relaxed mb-6">Kirimkan kado terbaik atau ucapan tanda kasih sayang Anda melalui rekening di bawah ini:</p>

            <div class="space-y-4">
                <!-- BCA Bank Card -->
                <div class="bg-dark-obsidian/60 border border-gold/20 p-4 rounded-xl relative text-left">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold text-sm tracking-wider font-display text-slate-200">BANK BCA</span>
                        <i class="fa-solid fa-building-columns text-gold/60 text-xs"></i>
                    </div>
                    <p class="text-slate-400 text-[10px] tracking-wider mb-1">Nomor Rekening</p>
                    <div class="flex justify-between items-center bg-white/5 px-3 py-2 rounded-lg">
                        <span class="font-mono font-bold text-slate-200 text-sm tracking-wide" id="bca-num">1234567890</span>
                        <button onclick="copyAccount('bca-num')" class="text-gold hover:text-gold-light text-xs font-display font-bold flex items-center gap-1 cursor-pointer">
                            <i class="fa-regular fa-copy"></i> SALIN
                        </button>
                    </div>
                    <p class="text-slate-300 text-xs mt-2 font-medium">a.n {{ $invitation->profile->first_name ?? 'GABRIEL' }}</p>
                </div>

                <!-- GoPay / E-Wallet Card -->
                <div class="bg-dark-obsidian/60 border border-gold/20 p-4 rounded-xl relative text-left">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-bold text-sm tracking-wider font-display text-slate-200">GOPAY / E-WALLET</span>
                        <i class="fa-solid fa-wallet text-gold/60 text-xs"></i>
                    </div>
                    <p class="text-slate-400 text-[10px] tracking-wider mb-1">Nomor Handphone</p>
                    <div class="flex justify-between items-center bg-white/5 px-3 py-2 rounded-lg">
                        <span class="font-mono font-bold text-slate-200 text-sm tracking-wide" id="wallet-num">081234567890</span>
                        <button onclick="copyAccount('wallet-num')" class="text-gold hover:text-gold-light text-xs font-display font-bold flex items-center gap-1 cursor-pointer">
                            <i class="fa-regular fa-copy"></i> SALIN
                        </button>
                    </div>
                    <p class="text-slate-300 text-xs mt-2 font-medium">a.n {{ $invitation->profile->first_name ?? 'GABRIEL' }}</p>
                </div>
            </div>

            <p class="text-[10px] text-slate-500 mt-6 leading-relaxed">Kehadiran dan doa restu Anda adalah kado terindah bagi kami.</p>
        </div>
    </div>


    <script>
        /* ─── CLIENT-SIDE PREVIEW ENGINE ─── */
        // Runs statically to convert raw Blade tags into stunning dummy contents during preview modes.
        document.addEventListener("DOMContentLoaded", function() {
            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
            let node;
            const nodesToClean = [];

            while (node = walker.nextNode()) {
                const text = node.nodeValue;
                if (text.includes('@@if') || text.includes('@@foreach') || text.includes('@@endforeach') || text.includes('@@else') || text.includes('@@endif')) {
                    nodesToClean.push({ node, type: 'directive' });
                } else if (text.includes('@{{') && text.includes('@}}')) {
                    nodesToClean.push({ node, type: 'variable', originalText: text });
                }
            }

            nodesToClean.forEach(item => {
                if (item.type === 'directive') {
                    item.node.nodeValue = '';
                } else if (item.type === 'variable') {
                    let cleanValue = item.originalText;
                    if (cleanValue.includes('first_name') || cleanValue.includes('NAMA') || cleanValue.includes('SAVE THE')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'GABRIEL');
                    } else if (cleanValue.includes('last_name') || cleanValue.includes('DATE')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'KURNIA');
                    } else if (cleanValue.includes("get('to')") || cleanValue.includes('Tamu Undangan')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Bapak/Ibu/Saudara/i');
                    } else if (cleanValue.includes('title')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'GABRIEL BIRTHDAY');
                    } else if (cleanValue.includes('event->name')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Main Birthday Party');
                    } else if (cleanValue.includes('event_date')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Sabtu, 20 Juni 2026');
                    } else if (cleanValue.includes('start_time')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, '19.00');
                    } else if (cleanValue.includes('venue_name')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Grand Ballroom Luxury Hotel');
                    } else if (cleanValue.includes('address')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Jl. Jend. Sudirman No. 123, SCBD, Jakarta Selatan');
                    } else {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, '');
                    }
                    item.node.nodeValue = cleanValue;
                }
            });

            document.querySelectorAll('input, select, textarea').forEach(el => {
                if (el.value.includes('@{{')) {
                    el.value = '';
                }
                if (el.placeholder.includes('@{{')) {
                    el.placeholder = 'Nama Anda';
                }
            });
        });

        // Countdown targets
        const targetDateStr = "{{ $invitation->event_date ?? '2026-06-20' }}T19:00:00";

        const scContainer = document.getElementById('scroll-container');
        const sections = [...document.querySelectorAll('.section')];
        const dotsNav = document.getElementById('side-nav');
        const audio = document.getElementById('bg-audio');
        const musicBtn = document.getElementById('floating-music');
        const eqContainer = document.getElementById('eq-container');
        const musicFallback = document.getElementById('music-fallback-icon');

        let activeIndex = 0;
        let isOpened = false;

        // 1. GENERATE DESKTOP SIDE NAV
        sections.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.className = `w-2 h-2 rounded-full bg-slate-600 cursor-pointer transition-all duration-300 ${i === 0 ? 'bg-gold w-3 h-3 ring-4 ring-gold/25' : 'hover:bg-gold/60'}`;
            dot.onclick = () => jumpTo(i);
            dotsNav.appendChild(dot);
        });

        // 2. SCROLL JUMP FUNCTION
        function jumpTo(index) {
            if (index < 0 || index >= sections.length) return;
            sections[index].scrollIntoView({
                behavior: 'smooth'
            });
        }

        // 3. UNLOCK INVITATION (OPENING SCREEN)
        function unlockInvitation() {
            if (isOpened) return;
            isOpened = true;

            document.getElementById('opening-screen').classList.add('open');
            musicBtn.classList.remove('hidden');

            document.body.style.overflow = 'auto';
            document.body.style.overflowX = 'hidden';

            // Paksa browser untuk memuat audio agar tidak tersendat
            audio.load();
            
            // Play bg music immediately
            audio.play().then(() => {
                setEqActive(true);
            }).catch(e => {
                console.log("Autoplay caught/blocked by browser policies", e);
                // fallback state jika diblokir sistem device (misal: mode hemat daya)
                setEqActive(false);
            });

            // Trigger countdown and reveal initial section animations
            initCountdown();
            setTimeout(() => {
                triggerSectionAnimation(0);
            }, 300);
        }

        // 4. MUSIC PLAYER HANDLER
        function handleMusic() {
            if (audio.paused) {
                audio.play();
                setEqActive(true);
            } else {
                audio.pause();
                setEqActive(false);
            }
        }

        function setEqActive(active) {
            const bars = document.querySelectorAll('.eq-bar');
            if (active) {
                eqContainer.classList.remove('hidden');
                musicFallback.classList.add('hidden');
                bars.forEach(bar => bar.style.animationPlayState = 'running');
            } else {
                eqContainer.classList.add('hidden');
                musicFallback.classList.remove('hidden');
                bars.forEach(bar => bar.style.animationPlayState = 'paused');
            }
        }

        // 5. OBSERVER FOR ACTIVE SECTIONS
        const observerOptions = {
            threshold: 0.5
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const index = sections.indexOf(entry.target);
                    activeIndex = index;

                    // Update Desktop Dot Navs
                    document.querySelectorAll('#side-nav div').forEach((dot, idx) => {
                        if (idx === index) {
                            dot.className = 'w-3 h-3 rounded-full bg-gold ring-4 ring-gold/25 cursor-pointer transition-all duration-300';
                        } else {
                            dot.className = 'w-2 h-2 rounded-full bg-slate-600 hover:bg-gold/60 cursor-pointer transition-all duration-300';
                        }
                    });

                    // Update Mobile Bottom Nav state
                    document.querySelectorAll('.b-nav-item').forEach((item, idx) => {
                        item.classList.toggle('active', idx === index);
                        if (idx === index) {
                            item.classList.add('text-gold', 'scale-110');
                            item.classList.remove('text-slate-400');
                        } else {
                            item.classList.remove('text-gold', 'scale-110');
                            item.classList.add('text-slate-400');
                        }
                    });

                    triggerSectionAnimation(index);
                }
            });
        }, observerOptions);

        sections.forEach(sec => observer.observe(sec));

        function triggerSectionAnimation(index) {
            sections[index].querySelectorAll('[data-anim]').forEach(el => {
                el.classList.add('shown');
            });
        }

        // 6. COUNTDOWN TIMER LOGIC
        function initCountdown() {
            const targetTime = new Date(targetDateStr).getTime();
            if (isNaN(targetTime)) return;

            const timerInterval = setInterval(() => {
                const now = new Date().getTime();
                const diff = targetTime - now;

                if (diff <= 0) {
                    clearInterval(timerInterval);
                    return;
                }

                const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('days').textContent = String(d).padStart(2, '0');
                document.getElementById('hours').textContent = String(h).padStart(2, '0');
                document.getElementById('mins').textContent = String(m).padStart(2, '0');
                document.getElementById('secs').textContent = String(s).padStart(2, '0');
            }, 1000);
        }

        // 7. GOLD TOAST MESSENGER
        function showToast(text) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-text').textContent = text;
            toast.classList.remove('opacity-0', 'translate-y-24', 'pointer-events-none');
            toast.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-24', 'pointer-events-none');
                toast.classList.remove('opacity-100', 'translate-y-0');
            }, 3500);
        }

        // 8. RSVP SUBMISSION & GUESTBOOK STREAM UPDATE
        function submitRsvp(e) {
            e.preventDefault();
            const nameInput = document.getElementById('rsvp-name');
            const statusInput = document.getElementById('rsvp-status');
            const msgInput = document.getElementById('rsvp-message');

            const name = nameInput.value.trim();
            const status = statusInput.value;
            const msg = msgInput.value.trim();

            if (!name || !status) return;

            // Live updates for guestbook stream
            const list = document.getElementById('wishes-list');
            const newItem = document.createElement('div');
            newItem.className = 'wish-item bg-white/5 border border-white/5 p-4 rounded-lg border-l-2 border-l-gold animate-pulse';
            
            const badgeText = status === 'hadir' ? 'HADIR' : 'BERHALANGAN';

            newItem.innerHTML = `
                <div class="flex items-center justify-between mb-2">
                    <div class="wish-name font-bold text-xs font-display tracking-widest text-gold">${name.toUpperCase()}</div>
                    <span class="text-[9px] bg-gold/10 text-gold px-2 py-0.5 rounded-full font-display">${badgeText}</span>
                </div>
                <div class="wish-text text-xs italic text-slate-300 leading-relaxed font-sans">
                    "${msg !== "" ? msg : 'Selamat bertambah usia! Semoga selalu diberi kemudahan.'}"
                </div>
            `;
            list.prepend(newItem);
            
            setTimeout(() => {
                newItem.classList.remove('animate-pulse');
            }, 1500);

            showToast(`Terima kasih ${name}, rsvp berhasil terkirim!`);
            document.getElementById('form-rsvp').reset();
        }

        // 9. GIFT REGISTRY MODAL LOGIC
        function openGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-modal-card');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-modal-card');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.classList.remove('opacity-100');
            card.classList.add('scale-95');
            card.classList.remove('scale-100');
        }

        // BCA / Gopay Copy Command Helper compatible with iframe rules
        function copyAccount(elementId) {
            const textToCopy = document.getElementById(elementId).innerText;
            const tempInput = document.createElement("input");
            tempInput.value = textToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            
            showToast(`Nomor rekening ${textToCopy} berhasil disalin!`);
        }

        // 10. GOLD DUST INTERACTIVE CANVAS
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        let mouse = { x: null, y: null };

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            initParticles();
        }

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height + canvas.height;
                this.size = Math.random() * 2.5 + 0.5;
                this.speedY = -(Math.random() * 0.8 + 0.2);
                this.speedX = Math.random() * 0.4 - 0.2;
                this.alpha = Math.random() * 0.5 + 0.2;
                this.wiggle = Math.random() * 0.02;
                this.wiggleSpeed = Math.random() * 0.05;
            }

            update() {
                this.y += this.speedY;
                this.x += this.speedX + Math.sin(this.y * this.wiggle) * 0.2;

                // Handle out of bound resetting
                if (this.y < 0) {
                    this.y = canvas.height + Math.random() * 50;
                    this.x = Math.random() * canvas.width;
                }

                // Mouse interaction / ripple push
                if (mouse.x && mouse.y) {
                    const dx = this.x - mouse.x;
                    const dy = this.y - mouse.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    if (distance < 100) {
                        const force = (100 - distance) / 100;
                        this.x += (dx / distance) * force * 4;
                        this.y += (dy / distance) * force * 4;
                    }
                }
            }

            draw() {
                ctx.save();
                ctx.globalAlpha = this.alpha;
                ctx.shadowBlur = 10;
                ctx.shadowColor = '#E2B875';
                ctx.fillStyle = '#E2B875';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
                ctx.restore();
            }
        }

        function initParticles() {
            particles = [];
            const particleCount = Math.floor((canvas.width * canvas.height) / 9000);
            for (let i = 0; i < Math.min(particleCount, 150); i++) {
                particles.push(new Particle());
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                p.update();
                p.draw();
            });
            requestAnimationFrame(animateParticles);
        }

        window.addEventListener('resize', resizeCanvas);
        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });
        window.addEventListener('mouseleave', () => {
            mouse.x = null;
            mouse.y = null;
        });
        window.addEventListener('touchmove', (e) => {
            if (e.touches.length > 0) {
                mouse.x = e.touches[0].clientX;
                mouse.y = e.touches[0].clientY;
            }
        });
        window.addEventListener('touchend', () => {
            mouse.x = null;
            mouse.y = null;
        });

        window.onload = function () {
            resizeCanvas();
            animateParticles();
        }
    </script>
    @include('themes.partials.universal-sections')
</body>

</html>