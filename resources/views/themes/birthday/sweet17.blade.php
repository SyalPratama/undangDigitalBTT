<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title ?? 'Chapter 17 Invitation' }}</title>

    <!-- Google Fonts: Syne (Gen Z Display Font) and Plus Jakarta Sans (Clean Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@500;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        body: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            dark: '#030305',
                            purple: '#7e22ce',
                            blue: '#3b82f6',
                            accent: '#c084fc',
                            pink: '#db2777'
                        }
                    },
                    animation: {
                        'marquee': 'marquee 25s linear infinite',
                        'blob': 'blob 10s infinite alternate',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        marquee: {
                            '0%': { transform: 'translateX(0%)' },
                            '100%': { transform: 'translateX(-100%)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-15px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #030305;
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Ambient Mesh Gradient Background - ENHANCED COLORS */
        .mesh-bg {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: -3;
            background: #030305;
            overflow: hidden;
        }
        .mesh-blob {
            position: absolute;
            filter: blur(120px);
            opacity: 0.7; /* Increased opacity */
            border-radius: 50%;
            animation: blob 15s infinite alternate ease-in-out;
        }
        .mesh-blob-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: #6b21a8; } /* Bright Purple */
        .mesh-blob-2 { bottom: -20%; right: -10%; width: 60vw; height: 60vw; background: #1e40af; animation-delay: -5s; } /* Bright Blue */
        .mesh-blob-3 { top: 30%; left: 30%; width: 50vw; height: 50vw; background: #be185d; animation-delay: -10s; opacity: 0.5; } /* Neon Pink for Euphoria Vibe */

        /* Noise Texture Overlay */
        .noise-overlay {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: -1;
            opacity: 0.04;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }

        /* Floating Sparkles Animation */
        .sparkles-container {
            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: -2; pointer-events: none; overflow: hidden;
        }
        .sparkle {
            position: absolute;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 10px #fff, 0 0 20px #c084fc;
            animation: flyUp linear infinite, pulse ease-in-out infinite alternate;
        }
        @keyframes flyUp {
            0% { transform: translateY(105vh) scale(0.5); opacity: 0; }
            10% { opacity: 0.8; }
            90% { opacity: 0.8; }
            100% { transform: translateY(-10vh) scale(1.2); opacity: 0; }
        }
        @keyframes pulse {
            0% { opacity: 0.3; box-shadow: 0 0 5px #fff, 0 0 10px #c084fc; }
            100% { opacity: 1; box-shadow: 0 0 15px #fff, 0 0 30px #c084fc; }
        }

        /* Bento Box Grid Styles */
        .bento-box {
            background: rgba(20, 20, 25, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .bento-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%);
            z-index: 0;
            pointer-events: none;
        }

        .bento-box > * { position: relative; z-index: 1; }

        .bento-box:hover {
            transform: translateY(-5px) scale(1.01);
            border-color: rgba(192, 132, 252, 0.3);
            box-shadow: 0 20px 40px -10px rgba(126, 34, 206, 0.2);
        }

        /* 3D VIP Card Opening Screen - NOW SEMI TRANSPARENT */
        #opening-screen {
            position: fixed; inset: 0;
            background: rgba(3, 3, 5, 0.4); /* Glassmorphism background instead of solid black */
            backdrop-filter: blur(8px); /* Blurs the animated background */
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex; justify-content: center; align-items: center;
            transition: opacity 1s ease, visibility 1s, backdrop-filter 1s;
            perspective: 1000px;
        }
        
        .vip-card {
            width: 300px; height: 450px;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.02));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            transform-style: preserve-3d;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8), inset 0 0 20px rgba(255,255,255,0.1);
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            text-align: center; padding: 30px;
            animation: float 6s ease-in-out infinite;
        }

        .vip-card:hover { transform: rotateY(10deg) rotateX(10deg); box-shadow: 0 35px 60px -12px rgba(192, 132, 252, 0.3); }

        #opening-screen.opened { opacity: 0; visibility: hidden; pointer-events: none; backdrop-filter: blur(0px); }
        #opening-screen.opened .vip-card { transform: scale(1.5) translateY(-100px) rotateX(45deg); opacity: 0; }

        /* Form Inputs */
        .glass-input {
            width: 100%; background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white; padding: 12px 16px; border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px;
            transition: all 0.3s ease;
        }
        .glass-input:focus {
            outline: none; border-color: #c084fc; background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 15px rgba(192, 132, 252, 0.2);
        }

        /* Buttons */
        .btn-glow {
            background: linear-gradient(135deg, #7e22ce, #3b82f6);
            color: white; font-family: 'Syne', sans-serif;
            font-weight: 700; border-radius: 99px;
            transition: all 0.3s ease; border: none; cursor: pointer;
            position: relative; overflow: hidden;
        }
        .btn-glow:hover {
            box-shadow: 0 0 25px rgba(192, 132, 252, 0.6);
            transform: scale(1.02);
        }

        /* Scroll Animations */
        .reveal-element {
            opacity: 0; transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .reveal-element.is-visible { opacity: 1; transform: translateY(0); }

        /* Custom Scrollbar for Guests List */
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }

        /* Floating Audio Control */
        #music-btn {
            position: fixed; bottom: 30px; right: 30px; z-index: 50;
            width: 55px; height: 55px; border-radius: 50%;
            background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2); color: white;
            display: none; align-items: center; justify-content: center;
            font-size: 20px; transition: all 0.3s; cursor: pointer;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        #music-btn:hover { transform: scale(1.1); background: rgba(255,255,255,0.2); border-color: #c084fc; box-shadow: 0 0 20px rgba(192, 132, 252, 0.4); }
        .spin { animation: spin 4s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
</head>

<body class="antialiased">

    <!-- THE ANIMATED BACKGROUND -->
    <div class="mesh-bg" id="main-bg">
        <div class="mesh-blob mesh-blob-1"></div>
        <div class="mesh-blob mesh-blob-2"></div>
        <div class="mesh-blob mesh-blob-3"></div>
    </div>
    <div class="sparkles-container" id="sparkles"></div>
    <div class="noise-overlay"></div>

    <!-- Upbeat trendy aesthetic music -->
    <audio id="bg-audio" loop preload="auto">
        <source src="https://cdn.pixabay.com/download/audio/2022/10/25/audio_2db88e5d03.mp3?filename=creative-technology-showreel-124317.mp3" type="audio/mpeg">
    </audio>

    <!-- 0. OPENING SCREEN -->
    <div id="opening-screen">
        <div class="vip-card">
            <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mb-6 border border-white/20 shadow-[0_0_15px_rgba(192,132,252,0.4)]">
                <i class="fa-solid fa-crown text-xl text-brand-accent"></i>
            </div>
            
            <p class="font-display tracking-[0.3em] text-[10px] text-gray-300 uppercase mb-2">VIP Access For</p>
            <h3 class="font-display text-xl font-bold text-white mb-6 uppercase tracking-wider">{{ request()->get('to') ?? 'Special Guest' }}</h3>
            
            <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-white/40 to-transparent my-4"></div>

            <p class="font-body text-xs text-gray-300 mb-2 leading-relaxed">You are exclusively invited to<br>celebrate Chapter 17 of</p>
            <h2 class="font-display text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-brand-accent via-pink-400 to-brand-blue uppercase mt-2 mb-8 drop-shadow-lg">
                {{ $invitation->profile->first_name ?? 'NAMA' }}
            </h2>

            <button onclick="unlockAccess()" class="btn-glow py-3 px-8 w-full text-sm tracking-widest flex items-center justify-center gap-2">
                <i class="fa-solid fa-fingerprint"></i> TAP TO UNLOCK
            </button>
        </div>
    </div>

    <!-- Floating Audio Toggle -->
    <button id="music-btn" onclick="toggleAudio()">
        <i id="music-icon" class="fa-solid fa-compact-disc"></i>
    </button>

    <!-- MAIN CONTENT CONTAINER (BENTO GRID) -->
    <main class="w-full max-w-[1400px] mx-auto min-h-screen p-4 md:p-8 lg:p-12 pb-24 relative z-10">
        
        <!-- Marquee Text Band -->
        <div class="w-full overflow-hidden flex bg-white/5 backdrop-blur-sm border-y border-white/10 py-3 mb-8 rounded-2xl reveal-element">
            <div class="animate-marquee whitespace-nowrap flex items-center gap-8 font-display font-bold text-sm tracking-[0.2em] text-brand-accent uppercase">
                <span>✦ SWEET SEVENTEEN ✦</span>
                <span class="text-white">A NIGHT OF EUPHORIA</span>
                <span>✦ CHAPTER 17 ✦</span>
                <span class="text-white">NOSTALGIA & MEMORIES</span>
                <span>✦ SWEET SEVENTEEN ✦</span>
                <span class="text-white">A NIGHT OF EUPHORIA</span>
                <span>✦ CHAPTER 17 ✦</span>
                <span class="text-white">NOSTALGIA & MEMORIES</span>
            </div>
        </div>

        <!-- THE BENTO GRID -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6">

            <!-- BENTO 1: Main Title / Hero (Span 8) -->
            <div class="bento-box md:col-span-8 flex flex-col justify-center min-h-[300px] reveal-element">
                <p class="font-display tracking-[0.4em] text-xs text-brand-pink uppercase mb-4 pl-1">Est. 2009</p>
                <h1 class="font-display font-extrabold text-5xl md:text-7xl lg:text-8xl text-white leading-[0.9] uppercase tracking-tighter mb-4">
                    {{ strtoupper($invitation->profile->first_name ?? 'NAMA') }}<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accent to-brand-blue">
                        {{ strtoupper($invitation->profile->last_name ?? 'REMAJA') }}
                    </span>
                </h1>
                <p class="font-body text-gray-300 text-sm md:text-base max-w-md mt-4 leading-relaxed">
                    "Stepping into seventeen with big dreams, good vibes, and the best people by my side. Let's make this night unforgettable."
                </p>
            </div>

            <!-- BENTO 2: Aesthetic Photo (Span 4) -->
            <div class="bento-box md:col-span-4 p-2 min-h-[300px] reveal-element group">
                <div class="w-full h-full min-h-[280px] rounded-[20px] overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1541701494587-cb58502866ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Aesthetic Setup" 
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 filter brightness-90 contrast-125">
                    <div class="absolute bottom-4 right-4 bg-black/60 backdrop-blur-md border border-white/20 rounded-full px-4 py-2 flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></div>
                        <span class="font-display text-[10px] tracking-widest font-bold uppercase text-white">Live in the moment</span>
                    </div>
                </div>
            </div>

            <!-- BENTO 3: Countdown (Span 12 - Full Width Block) -->
            <div class="bento-box md:col-span-12 reveal-element flex flex-col md:flex-row items-center justify-between gap-8 md:gap-4 p-8">
                <div class="text-center md:text-left">
                    <h2 class="font-display font-bold text-2xl text-white mb-1">COUNTING DOWN</h2>
                    <p class="font-body text-sm text-gray-400">The clock is ticking until midnight.</p>
                </div>
                
                <div class="flex gap-4 md:gap-6">
                    <div class="flex flex-col items-center">
                        <span id="days" class="font-display text-4xl md:text-5xl font-extrabold text-white">00</span>
                        <span class="font-display text-[10px] tracking-[0.2em] text-brand-pink mt-1 uppercase">Days</span>
                    </div>
                    <span class="font-display text-4xl font-extrabold text-gray-600">:</span>
                    <div class="flex flex-col items-center">
                        <span id="hours" class="font-display text-4xl md:text-5xl font-extrabold text-white">00</span>
                        <span class="font-display text-[10px] tracking-[0.2em] text-brand-blue mt-1 uppercase">Hours</span>
                    </div>
                    <span class="font-display text-4xl font-extrabold text-gray-600">:</span>
                    <div class="flex flex-col items-center">
                        <span id="mins" class="font-display text-4xl md:text-5xl font-extrabold text-white">00</span>
                        <span class="font-display text-[10px] tracking-[0.2em] text-brand-accent mt-1 uppercase">Mins</span>
                    </div>
                    <span class="font-display text-4xl font-extrabold text-gray-600 hidden md:inline">:</span>
                    <div class="flex flex-col items-center hidden md:flex">
                        <span id="secs" class="font-display text-4xl md:text-5xl font-extrabold text-white">00</span>
                        <span class="font-display text-[10px] tracking-[0.2em] text-brand-pink mt-1 uppercase">Secs</span>
                    </div>
                </div>
            </div>

            <!-- BENTO 4: Event Details (Span 7) -->
            <div class="bento-box md:col-span-7 reveal-element">
                <h3 class="font-display text-sm tracking-[0.3em] text-brand-blue uppercase mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-calendar-check"></i> Itinerary
                </h3>
                
                <div class="space-y-6">
                    @if(isset($invitation) && $invitation->events && $invitation->events->count() > 0)
                        @foreach($invitation->events as $event)
                        <div class="bg-black/40 rounded-2xl p-5 border border-white/5 hover:border-brand-accent/50 transition-colors group">
                            <h4 class="font-display text-xl font-bold text-white mb-4 group-hover:text-brand-accent transition-colors">{{ $event->name }}</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 font-body text-sm text-gray-300">
                                <div class="flex items-start gap-3">
                                    <div class="mt-1 text-brand-accent"><i class="fa-regular fa-clock"></i></div>
                                    <div>
                                        <p class="font-bold text-white">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                                        <p class="text-xs mt-0.5">{{ $event->start_time }} WIB - End</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="mt-1 text-brand-blue"><i class="fa-solid fa-location-dot"></i></div>
                                    <div>
                                        <p class="font-bold text-white">{{ $event->venue_name }}</p>
                                        <p class="text-xs mt-0.5 leading-snug">{{ $event->address }}</p>
                                    </div>
                                </div>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->address) }}" target="_blank" 
                               class="mt-5 inline-flex items-center gap-2 text-xs font-display font-bold tracking-widest text-brand-pink hover:text-white transition-colors">
                                DIRECT ME THERE <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <!-- Fallback Event -->
                        <div class="bg-black/40 rounded-2xl p-5 border border-white/5 hover:border-brand-accent/50 transition-colors group">
                            <h4 class="font-display text-xl font-bold text-white mb-4 group-hover:text-brand-accent transition-colors">Euphoria Night Party</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 font-body text-sm text-gray-300">
                                <div class="flex items-start gap-3">
                                    <div class="mt-1 text-brand-accent"><i class="fa-regular fa-clock"></i></div>
                                    <div>
                                        <p class="font-bold text-white">Saturday, 25 October 2026</p>
                                        <p class="text-xs mt-0.5">19.00 WIB - Till Drop</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="mt-1 text-brand-blue"><i class="fa-solid fa-location-dot"></i></div>
                                    <div>
                                        <p class="font-bold text-white">Skyline Skydeck Lounge</p>
                                        <p class="text-xs mt-0.5 leading-snug">Jl. Sudirman Boulevard No. 17, Jakarta</p>
                                    </div>
                                </div>
                            </div>
                            <a href="https://www.google.com/maps/search/?api=1&query=Skyline+Lounge" target="_blank" 
                               class="mt-5 inline-flex items-center gap-2 text-xs font-display font-bold tracking-widest text-brand-pink hover:text-white transition-colors">
                                DIRECT ME THERE <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- BENTO 5: Dress Code & Digital Gift (Span 5) -->
            <div class="md:col-span-5 grid grid-rows-2 gap-4 md:gap-6">
                <!-- Dress Code Box -->
                <div class="bento-box flex flex-col justify-center items-center text-center reveal-element">
                    <i class="fa-solid fa-wand-magic-sparkles text-3xl text-brand-pink mb-3"></i>
                    <h3 class="font-display text-sm tracking-[0.3em] text-gray-400 uppercase mb-2">Dress Code</h3>
                    <p class="font-display font-bold text-xl text-white">Y2K GLAM / METALLIC</p>
                    <p class="font-body text-xs text-gray-400 mt-2">Come in your most dazzling aesthetic fits.</p>
                </div>
                
                <!-- Digital Gift Box -->
                <div class="bento-box flex flex-col justify-center items-center text-center reveal-element cursor-pointer group" onclick="openGiftModal()">
                    <div class="w-12 h-12 rounded-full bg-brand-blue/20 flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-blue/40 group-hover:shadow-[0_0_15px_rgba(59,130,246,0.5)] transition-all duration-300">
                        <i class="fa-solid fa-gift text-xl text-brand-blue group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-display text-sm tracking-[0.3em] text-gray-400 uppercase mb-2">Send Love</h3>
                    <p class="font-display font-bold text-lg text-white">DIGITAL ENVELOPE</p>
                    <p class="font-body text-xs text-gray-500 mt-1">(Tap to open)</p>
                </div>
            </div>

            <!-- BENTO 6: RSVP Form (Span 6) -->
            <div class="bento-box md:col-span-6 reveal-element">
                <h3 class="font-display text-sm tracking-[0.3em] text-brand-accent uppercase mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-envelope-open-text"></i> RSVP
                </h3>
                <form id="form-rsvp" onsubmit="submitRsvp(event)" class="space-y-4">
                    <div>
                        <input type="text" id="rsvp-name" class="glass-input" placeholder="Your Name" value="{{ request()->get('to') }}" required>
                    </div>
                    <div>
                        <select id="rsvp-status" class="glass-input appearance-none" required>
                            <option value="" disabled selected class="text-black">Will you be there?</option>
                            <option value="hadir" class="text-black">Yes, Count me in! 🥂</option>
                            <option value="tidak_hadir" class="text-black">Sorry, can't make it 🙏</option>
                        </select>
                    </div>
                    <div>
                        <textarea id="rsvp-message" rows="3" class="glass-input resize-none" placeholder="Leave a sweet wish..." required></textarea>
                    </div>
                    <button type="submit" class="btn-glow py-3 w-full text-sm tracking-widest mt-2">
                        CONFIRM ATTENDANCE
                    </button>
                </form>
            </div>

            <!-- BENTO 7: Guestbook / Wishes Stream (Span 6) -->
            <div class="bento-box md:col-span-6 reveal-element flex flex-col">
                <h3 class="font-display text-sm tracking-[0.3em] text-brand-blue uppercase mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-comment-dots"></i> Wishes Stream
                </h3>
                
                <div id="wishes-list" class="flex-1 max-h-[300px] overflow-y-auto pr-2 custom-scroll space-y-4">
                    <!-- Dummy Chat 1 -->
                    <div class="bg-black/40 p-4 rounded-2xl border border-white/10 hover:border-brand-blue/30 transition-colors">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-display text-sm font-bold text-white">Nathaniel</span>
                            <span class="text-[9px] bg-brand-blue/20 text-brand-blue px-2 py-1 rounded font-bold tracking-wider border border-brand-blue/30">ATTENDING</span>
                        </div>
                        <p class="font-body text-xs text-gray-300 leading-relaxed">Happy Sweet 17! Hope this year brings you endless joy and aesthetic moments. See u at the party! ✨</p>
                    </div>
                    <!-- Dummy Chat 2 -->
                    <div class="bg-black/40 p-4 rounded-2xl border border-white/10 hover:border-brand-accent/30 transition-colors">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-display text-sm font-bold text-white">Chloe Aurora</span>
                            <span class="text-[9px] bg-brand-accent/20 text-brand-accent px-2 py-1 rounded font-bold tracking-wider border border-brand-accent/30">ATTENDING</span>
                        </div>
                        <p class="font-body text-xs text-gray-300 leading-relaxed">Omggg happiest birthday bestieee! Get ready to slay tonight 💖</p>
                    </div>
                </div>
            </div>

        </div>

        <footer class="text-center mt-12 mb-4 reveal-element">
            <p class="font-display text-gray-500 text-xs tracking-[0.3em] uppercase">Built for Euphoria.</p>
        </footer>

    </main>

    <!-- Custom Toast -->
    <div id="toast" class="fixed top-5 left-1/2 -translate-x-1/2 bg-black/80 backdrop-blur-lg border border-brand-accent/50 shadow-[0_0_20px_rgba(192,132,252,0.3)] px-6 py-3 rounded-full z-[9999] opacity-0 pointer-events-none transition-all duration-300 transform -translate-y-10 flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-brand-accent"></i>
        <span id="toast-text" class="font-body text-sm font-bold text-white tracking-wide"></span>
    </div>

    <!-- Digital Gift Modal -->
    <div id="gift-modal" class="fixed inset-0 z-[10000] bg-black/90 backdrop-blur-xl flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-500">
        <div class="bento-box w-full max-w-sm p-8 transform scale-95 transition-transform duration-500 border-brand-blue/50 bg-[#0a0a0f]" id="gift-card">
            
            <button onclick="closeGiftModal()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/10 text-gray-400 hover:text-white hover:bg-red-500/50 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="text-center mb-8 mt-2">
                <i class="fa-solid fa-gift text-4xl text-brand-blue mb-4 drop-shadow-[0_0_15px_rgba(59,130,246,0.6)]"></i>
                <h3 class="font-display text-xl font-bold text-white tracking-[0.2em] uppercase">Digital Gift</h3>
                <p class="font-body text-xs text-gray-400 mt-2">Your presence means the world, but if you'd like to share a gift:</p>
            </div>

            <div class="space-y-4">
                <!-- Rekening 1 -->
                <div class="bg-black/50 border border-white/10 p-4 rounded-xl relative group hover:border-brand-blue/50 hover:shadow-[0_0_20px_rgba(59,130,246,0.1)] transition">
                    <span class="font-display text-[10px] text-brand-blue block mb-2 font-bold tracking-[0.2em] uppercase">BCA Account</span>
                    <div class="flex gap-2">
                        <input type="text" id="rek-bca" value="1234567890" class="glass-input w-full py-2 px-3 text-sm rounded-lg font-bold tracking-wider bg-transparent border-none p-0 focus:box-shadow-none" readonly>
                        <button onclick="copyText('rek-bca')" class="bg-white/10 hover:bg-brand-blue hover:text-white text-brand-blue text-xs px-4 rounded-lg font-bold transition">COPY</button>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-2 uppercase tracking-wide">A.n {{ $invitation->profile->first_name ?? 'Nama Lengkap' }}</p>
                </div>

                <!-- Rekening 2 -->
                <div class="bg-black/50 border border-white/10 p-4 rounded-xl relative group hover:border-brand-accent/50 hover:shadow-[0_0_20px_rgba(192,132,252,0.1)] transition">
                    <span class="font-display text-[10px] text-brand-accent block mb-2 font-bold tracking-[0.2em] uppercase">Gopay / OVO</span>
                    <div class="flex gap-2">
                        <input type="text" id="rek-ewallet" value="081234567890" class="glass-input w-full py-2 px-3 text-sm rounded-lg font-bold tracking-wider bg-transparent border-none p-0 focus:box-shadow-none" readonly>
                        <button onclick="copyText('rek-ewallet')" class="bg-white/10 hover:bg-brand-accent hover:text-white text-brand-accent text-xs px-4 rounded-lg font-bold transition">COPY</button>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-2 uppercase tracking-wide">A.n {{ $invitation->profile->first_name ?? 'Nama Lengkap' }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* ─── BLADE PREVIEW ENGINE ─── */
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
                    if (cleanValue.includes('first_name') || cleanValue.includes('NAMA')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'VALERIE');
                    } else if (cleanValue.includes('last_name') || cleanValue.includes('REMAJA')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'AURORA');
                    } else if (cleanValue.includes("get('to')") || cleanValue.includes('Special Guest')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Besties');
                    } else if (cleanValue.includes('title')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Valerie 17th');
                    } else if (cleanValue.includes('event->name')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Euphoria Night Party');
                    } else if (cleanValue.includes('event_date')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Saturday, 25 October 2026');
                    } else if (cleanValue.includes('start_time')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, '19.00');
                    } else if (cleanValue.includes('venue_name')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Skyline Skydeck Lounge');
                    } else if (cleanValue.includes('address')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Jl. Sudirman Boulevard No. 17, Jakarta');
                    } else {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, '');
                    }
                    item.node.nodeValue = cleanValue;
                }
            });

            document.querySelectorAll('input, select, textarea').forEach(el => {
                if (el.value.includes('@{{')) el.value = '';
            });

            // Initialize Background Sparkles
            createSparkles();
        });

        /* ─── BACKGROUND SPARKLES (NEW FEATURE) ─── */
        function createSparkles() {
            const container = document.getElementById('sparkles');
            const particleCount = window.innerWidth < 768 ? 20 : 45; // Less on mobile to save performance
            
            for (let i = 0; i < particleCount; i++) {
                let sparkle = document.createElement('div');
                sparkle.className = 'sparkle';
                
                // Randomize positions, size, and animation durations
                sparkle.style.left = Math.random() * 100 + 'vw';
                let size = Math.random() * 3 + 1;
                sparkle.style.width = size + 'px';
                sparkle.style.height = size + 'px';
                
                let flyDuration = Math.random() * 10 + 8; // 8s to 18s
                let pulseDuration = Math.random() * 2 + 1; // 1s to 3s
                let delay = Math.random() * 10;
                
                sparkle.style.animationDuration = `${flyDuration}s, ${pulseDuration}s`;
                sparkle.style.animationDelay = `${delay}s, ${Math.random() * 2}s`;
                
                container.appendChild(sparkle);
            }
        }

        /* ─── CORE LOGIC ─── */
        const audio = document.getElementById('bg-audio');
        const audioBtn = document.getElementById('music-btn');
        const audioIcon = document.getElementById('music-icon');
        const targetDateStr = "{{ $invitation->event_date ?? '2026-10-25' }}T19:00:00";
        let isOpened = false;

        // 1. OPEN ACCESS
        function unlockAccess() {
            if (isOpened) return;
            isOpened = true;

            const screen = document.getElementById('opening-screen');
            screen.classList.add('opened');
            
            setTimeout(() => {
                screen.style.display = 'none';
                audioBtn.style.display = 'flex';
                initScrollReveal(); // Trigger reveals after screen goes away
            }, 1000);

            // Play Music
            audio.load();
            audio.play().then(() => {
                audioIcon.classList.add('spin');
            }).catch(e => console.log("Audio autoplay blocked."));

            initCountdown();
        }

        // 2. MUSIC TOGGLE
        function toggleAudio() {
            if (audio.paused) {
                audio.play();
                audioIcon.classList.add('spin');
                audioIcon.className = "fa-solid fa-compact-disc spin";
            } else {
                audio.pause();
                audioIcon.classList.remove('spin');
                audioIcon.className = "fa-solid fa-pause";
            }
        }

        // 3. SCROLL REVEAL OBSERVER
        function initScrollReveal() {
            const reveals = document.querySelectorAll('.reveal-element');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

            reveals.forEach(el => observer.observe(el));
            
            // Check elements immediately visible on screen load
            setTimeout(() => {
                reveals.forEach(el => {
                    const top = el.getBoundingClientRect().top;
                    if (top < window.innerHeight) el.classList.add('is-visible');
                });
            }, 100);
        }

        // 4. COUNTDOWN
        function initCountdown() {
            const targetTime = new Date(targetDateStr).getTime();
            if (isNaN(targetTime)) return;

            setInterval(() => {
                const now = new Date().getTime();
                const diff = targetTime - now;

                if (diff <= 0) return;

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

        // 5. TOAST
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-text').textContent = msg;
            toast.classList.replace('opacity-0', 'opacity-100');
            toast.classList.replace('-translate-y-10', 'translate-y-0');
            setTimeout(() => {
                toast.classList.replace('opacity-100', 'opacity-0');
                toast.classList.replace('translate-y-0', '-translate-y-10');
            }, 3000);
        }

        // 6. RSVP SUBMIT (Live Demo)
        function submitRsvp(e) {
            e.preventDefault();
            const name = document.getElementById('rsvp-name').value.trim();
            const status = document.getElementById('rsvp-status').value;
            const msg = document.getElementById('rsvp-message').value.trim();

            if (!name || !status || !msg) return;

            const isAttending = status === 'hadir';
            const badgeClass = isAttending ? 'bg-brand-blue/20 text-brand-blue border-brand-blue/30' : 'bg-red-500/20 text-red-400 border-red-500/30';
            const badgeText = isAttending ? 'ATTENDING' : 'ABSENT';

            const list = document.getElementById('wishes-list');
            const newItem = document.createElement('div');
            newItem.className = 'bg-white/10 p-4 rounded-2xl border border-white/20 mb-4 opacity-0 transition-opacity duration-500';
            newItem.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <span class="font-display text-sm font-bold text-white">${name}</span>
                    <span class="text-[9px] ${badgeClass} px-2 py-1 rounded font-bold tracking-wider border">${badgeText}</span>
                </div>
                <p class="font-body text-xs text-gray-300 leading-relaxed">${msg}</p>
            `;
            list.prepend(newItem);
            
            // Trigger animation for new message
            setTimeout(() => newItem.classList.replace('opacity-0', 'opacity-100'), 50);

            showToast('RSVP Confirmed! ✨');
            document.getElementById('form-rsvp').reset();
        }

        // 7. MODAL & CLIPBOARD
        function openGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-card');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 10);
        }

        function closeGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-card');
            card.classList.add('scale-95');
            card.classList.remove('scale-100');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 500);
        }

        function copyText(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            showToast('Account copied to clipboard! 📋');
        }
    </script>
</body>
</html>