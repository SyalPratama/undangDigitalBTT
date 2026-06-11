<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->title ?? 'Pesta Ulang Tahun Anak' }}</title>

    <!-- Google Fonts: Chewy (Comic style) and Quicksand (Rounded readable text) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chewy&family=Quicksand:wght@500;700;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        toon: {
                            blue: '#4D96FF',
                            yellow: '#FFD93D',
                            pink: '#FF6B6B',
                            green: '#6BCB77',
                            purple: '#9D65C9',
                            dark: '#1A1A2E',
                            paper: '#F9F7F7'
                        }
                    },
                    fontFamily: {
                        comic: ['Chewy', 'cursive'],
                        round: ['Quicksand', 'sans-serif'],
                    },
                    boxShadow: {
                        // Cartoon solid shadows!
                        'toon': '6px 8px 0px 0px rgba(26, 26, 46, 1)',
                        'toon-sm': '3px 4px 0px 0px rgba(26, 26, 46, 1)',
                        'toon-active': '0px 0px 0px 0px rgba(26, 26, 46, 1)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #FFD93D;
            /* Fun Polka Dot Pattern */
            background-image: radial-gradient(#1A1A2E 1.5px, transparent 1.5px);
            background-size: 30px 30px;
            color: #1A1A2E;
            overflow-x: hidden;
        }

        /* Continuous Storybook scroll, no snap! */
        html {
            scroll-behavior: smooth;
        }

        /* Themed Cartoon Cards */
        .card-toon {
            background-color: white;
            border: 4px solid #1A1A2E;
            border-radius: 24px;
            box-shadow: 6px 8px 0px 0px #1A1A2E;
            position: relative;
            z-index: 10;
        }

        /* Bouncy Buttons */
        .btn-toon {
            border: 4px solid #1A1A2E;
            border-radius: 100px;
            box-shadow: 4px 6px 0px 0px #1A1A2E;
            transition: all 0.15s ease-in-out;
            cursor: pointer;
            text-transform: uppercase;
            font-family: 'Chewy', cursive;
            letter-spacing: 1px;
        }

        .btn-toon:active {
            transform: translate(4px, 6px);
            box-shadow: 0px 0px 0px 0px #1A1A2E;
        }

        /* ─── FUN ANIMATIONS ─── */
        @keyframes float-clouds {
            0%, 100% { transform: translateX(0) translateY(0) rotate(var(--rot, 0deg)); }
            50% { transform: translateX(20px) translateY(-10px) rotate(calc(var(--rot, 0deg) + 5deg)); }
        }
        .anim-cloud { animation: float-clouds 8s ease-in-out infinite; }
        .anim-cloud-reverse { animation: float-clouds 10s ease-in-out infinite reverse; }

        @keyframes wiggle {
            0%, 100% { transform: rotate(calc(var(--rot, 0deg) - 3deg)) scale(1); }
            50% { transform: rotate(calc(var(--rot, 0deg) + 3deg)) scale(1.05); }
        }
        .anim-wiggle { animation: wiggle 2s ease-in-out infinite; }

        @keyframes pop-in {
            0% { transform: scale(0); opacity: 0; }
            80% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes slide-up-fade {
            0% { transform: translateY(50px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        .reveal { opacity: 0; }
        .reveal.active { animation: slide-up-fade 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }

        /* Wavy SVG Dividers */
        .wave-divider {
            position: absolute;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }
        .wave-divider svg {
            display: block;
            width: calc(100% + 1.3px);
            height: 60px;
        }

        /* Forms */
        .input-toon {
            width: 100%;
            border: 3px solid #1A1A2E;
            border-radius: 12px;
            padding: 12px 16px;
            font-family: 'Quicksand', sans-serif;
            font-weight: 700;
            box-shadow: inset 2px 2px 0px rgba(0,0,0,0.05);
            outline: none;
            transition: all 0.2s;
        }
        .input-toon:focus {
            background-color: #FFF9E6;
            border-color: #4D96FF;
        }

        /* Opening Gift Cover */
        #opening-cover {
            position: fixed;
            inset: 0;
            background-color: #FF6B6B;
            background-image: radial-gradient(#1A1A2E 2px, transparent 2px);
            background-size: 40px 40px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 1s cubic-bezier(0.85, 0, 0.15, 1);
        }
        #opening-cover.opened {
            transform: translateY(-100%);
            pointer-events: none;
        }

        /* Floating Audio Control */
        #audio-control {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 50;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
    </style>
</head>

<body class="antialiased relative">

    <!-- ─── DEKORASI BACKGROUND KIRI & KANAN (Hanya muncul di desktop/layar besar) ─── -->
    <div class="fixed inset-0 pointer-events-none z-0 hidden md:block overflow-hidden">
        <!-- Dekorasi Kiri -->
        <div class="absolute top-[10%] left-[8%] w-10 h-10 bg-toon-pink border-[3px] border-toon-dark shadow-toon-sm anim-wiggle" style="--rot: 15deg; animation-duration: 3s;"></div>
        <div class="absolute top-[25%] left-[15%] w-12 h-12 bg-white border-[4px] border-toon-dark shadow-toon-sm anim-cloud" style="--rot: -20deg; animation-duration: 5s;"></div>
        <div class="absolute top-[45%] left-[5%] w-8 h-8 bg-toon-blue border-[3px] border-toon-dark shadow-toon-sm anim-wiggle" style="--rot: 45deg; animation-duration: 4s;"></div>
        <div class="absolute top-[65%] left-[12%] w-14 h-14 bg-toon-purple border-[4px] border-toon-dark shadow-toon-sm anim-cloud-reverse" style="--rot: -10deg; animation-duration: 6s;"></div>
        <div class="absolute top-[85%] left-[7%] w-10 h-10 bg-toon-green border-[3px] border-toon-dark shadow-toon-sm anim-wiggle" style="--rot: 30deg; animation-duration: 3.5s;"></div>

        <!-- Dekorasi Kanan -->
        <div class="absolute top-[15%] right-[10%] w-14 h-14 bg-toon-blue border-[4px] border-toon-dark shadow-toon-sm anim-cloud" style="--rot: -15deg; animation-duration: 5.5s;"></div>
        <div class="absolute top-[35%] right-[6%] w-10 h-10 bg-toon-green border-[3px] border-toon-dark shadow-toon-sm anim-wiggle" style="--rot: 25deg; animation-duration: 4s;"></div>
        <div class="absolute top-[55%] right-[14%] w-8 h-8 bg-toon-pink border-[3px] border-toon-dark shadow-toon-sm anim-cloud-reverse" style="--rot: 45deg; animation-duration: 4.5s;"></div>
        <div class="absolute top-[75%] right-[8%] w-12 h-12 bg-white border-[4px] border-toon-dark shadow-toon-sm anim-wiggle" style="--rot: -30deg; animation-duration: 3s;"></div>
        <div class="absolute top-[90%] right-[12%] w-10 h-10 bg-toon-purple border-[3px] border-toon-dark shadow-toon-sm anim-cloud" style="--rot: 10deg; animation-duration: 5s;"></div>
    </div>
    <!-- ─────────────────────────────────────────────────────────────────────────── -->

    <!-- Xylophone/Music Box Happy Birthday Kids Song -->
    <audio id="bg-audio" loop preload="auto">
        <!-- Upbeat, classic happy birthday kids instrumental -->
        <source src="https://cdn.pixabay.com/audio/2022/10/14/audio_9939f792bc.mp3" type="audio/mpeg">
        <source src="https://cdn.pixabay.com/audio/2022/01/18/audio_d0a13f69d2.mp3" type="audio/mpeg">
    </audio>

    <!-- Confetti Canvas -->
    <canvas id="confetti" class="fixed inset-0 pointer-events-none z-[9000] hidden"></canvas>

    <!-- 0. OPENING SCREEN (KADO) -->
    <div id="opening-cover">
        <div class="card-toon bg-white p-8 max-w-[340px] w-[90%] text-center flex flex-col items-center">
            
            <div class="text-7xl mb-4 anim-wiggle">
                🎁
            </div>
            
            <h3 class="font-comic text-2xl text-toon-dark mb-1">Ada Kado Untukmu!</h3>
            <p class="font-round font-bold text-sm text-gray-600 mb-4 border-b-2 border-dashed border-gray-300 pb-4 w-full">
                Kepada:<br>
                <span class="text-xl text-toon-blue font-comic block mt-1 tracking-wider">{{ request()->get('to') ?? 'Teman-Teman' }}</span>
            </p>

            <button onclick="openGift()" class="btn-toon bg-toon-yellow text-toon-dark py-3 px-6 w-full text-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-box-open"></i> BUKA KADO
            </button>
        </div>
    </div>

    <!-- Floating Audio Toggle -->
    <button id="audio-control" class="btn-toon bg-toon-pink text-white" onclick="toggleAudio()">
        <i id="audio-icon" class="fa-solid fa-music anim-wiggle"></i>
    </button>

    <!-- MAIN CONTENT CONTAINER (Ditambahkan relative z-10 agar di atas dekorasi) -->
    <main class="relative z-10 w-full max-w-md mx-auto bg-toon-paper min-h-screen shadow-2xl border-x-4 border-toon-dark overflow-hidden pb-20">
        
        <!-- Hero Section -->
        <section class="relative pt-16 pb-24 px-6 bg-toon-blue overflow-hidden border-b-4 border-toon-dark">
            <!-- Decorative Clouds -->
            <div class="absolute top-10 -left-6 text-5xl anim-cloud opacity-80">☁️</div>
            <div class="absolute top-24 -right-8 text-6xl anim-cloud-reverse opacity-80">☁️</div>
            <div class="absolute bottom-10 left-1/4 text-4xl anim-cloud opacity-60">☁️</div>

            <!-- Floating Balloons -->
            <div class="absolute top-0 right-4 text-5xl anim-wiggle" style="animation-duration: 3s; transform-origin: bottom center;">🎈</div>
            <div class="absolute top-4 left-4 text-4xl anim-wiggle" style="animation-duration: 2.5s; transform-origin: bottom center; animation-delay: 0.5s;">🎈</div>

            <div class="relative z-10 text-center flex flex-col items-center mt-8">
                
                <div class="bg-toon-yellow border-4 border-toon-dark rounded-full px-6 py-2 mb-6 shadow-toon-sm transform -rotate-3 inline-block">
                    <span class="font-comic text-toon-dark text-xl tracking-wide">YEAAY, AKU ULANG TAHUN!</span>
                </div>

                <!-- Nama Anak -->
                <h1 class="font-comic text-white text-5xl md:text-6xl drop-shadow-[4px_4px_0_rgba(26,26,46,1)] leading-tight mb-2" style="-webkit-text-stroke: 1px #1A1A2E;">
                    {{ strtoupper($invitation->profile->first_name ?? 'NAMA') }}
                </h1>
                <h2 class="font-comic text-toon-yellow text-4xl md:text-5xl drop-shadow-[3px_3px_0_rgba(26,26,46,1)] mb-8" style="-webkit-text-stroke: 1px #1A1A2E;">
                    {{ strtoupper($invitation->profile->last_name ?? 'ANAK') }}
                </h2>

                <!-- Character/Photo Placeholder -->
                <div class="w-40 h-40 bg-white border-4 border-toon-dark rounded-full shadow-toon overflow-hidden relative mb-6">
                    <!-- Dynamic avatar generated based on name -->
                    <img src="https://api.dicebear.com/7.x/fun-emoji/svg?seed={{ $invitation->profile->first_name ?? 'Kid' }}&backgroundColor=FFD93D" alt="Birthday Kid" class="w-full h-full object-cover">
                </div>

                <div class="card-toon bg-white p-4 w-full text-center mt-4 transform rotate-1">
                    <p class="font-round font-bold text-toon-dark">
                        "Teman-teman, datang ya ke pestaku! Kita bakal main seru-seruan bareng!" 🥳
                    </p>
                </div>
            </div>

            <!-- Bottom SVG Wave -->
            <div class="wave-divider bottom-0 translate-y-[98%] text-toon-blue">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/20svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,121.32,201.2,112.59,240.76,107.6,281.82,88.4,321.39,56.44Z" fill="currentColor" stroke="#1A1A2E" stroke-width="4"></path>
                </svg>
            </div>
        </section>

        <!-- Countdown Section -->
        <section class="pt-24 pb-16 px-6 relative reveal">
            <h2 class="font-comic text-3xl text-center text-toon-dark mb-8">PESTA DIMULAI DALAM:</h2>
            
            <div class="flex justify-center gap-3">
                <!-- Days -->
                <div class="card-toon bg-toon-pink w-20 h-20 rounded-full flex flex-col items-center justify-center text-white">
                    <span id="days" class="font-comic text-3xl drop-shadow-[2px_2px_0_#1A1A2E]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Hari</span>
                </div>
                <!-- Hours -->
                <div class="card-toon bg-toon-yellow w-20 h-20 rounded-full flex flex-col items-center justify-center text-toon-dark transform translate-y-3">
                    <span id="hours" class="font-comic text-3xl drop-shadow-[2px_2px_0_#FFF]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Jam</span>
                </div>
                <!-- Mins -->
                <div class="card-toon bg-toon-green w-20 h-20 rounded-full flex flex-col items-center justify-center text-white">
                    <span id="mins" class="font-comic text-3xl drop-shadow-[2px_2px_0_#1A1A2E]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Menit</span>
                </div>
                <!-- Secs -->
                <div class="card-toon bg-toon-purple w-20 h-20 rounded-full flex flex-col items-center justify-center text-white transform -translate-y-2">
                    <span id="secs" class="font-comic text-3xl drop-shadow-[2px_2px_0_#1A1A2E]">00</span>
                    <span class="font-round text-[10px] font-black uppercase tracking-wider">Detik</span>
                </div>
            </div>
        </section>

        <!-- Event Info Section -->
        <section class="py-10 px-6 relative bg-toon-yellow border-y-4 border-toon-dark reveal">
            <!-- Decorative stars -->
            <div class="absolute top-4 left-4 text-2xl text-white drop-shadow-[2px_2px_0_#1A1A2E] anim-wiggle">⭐</div>
            <div class="absolute bottom-4 right-4 text-3xl text-white drop-shadow-[2px_2px_0_#1A1A2E] anim-wiggle" style="animation-delay: 1s;">⭐</div>

            <h2 class="font-comic text-3xl text-center text-toon-dark mb-6">KAPAN & DIMANA?</h2>

            <div class="space-y-6">
                @if(isset($invitation) && $invitation->events && $invitation->events->count() > 0)
                    @foreach($invitation->events as $event)
                    <div class="card-toon bg-white p-6 transform rotate-[-1deg] hover:rotate-0 transition-transform">
                        <div class="flex items-center gap-3 mb-4 border-b-4 border-toon-dark pb-2">
                            <span class="text-3xl">🎂</span>
                            <h3 class="font-comic text-2xl text-toon-pink">{{ $event->name }}</h3>
                        </div>
                        
                        <ul class="space-y-4 font-round font-bold text-toon-dark mb-6">
                            <li class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-toon-blue rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0">
                                    <i class="fa-regular fa-calendar-check text-lg"></i>
                                </div>
                                <span>{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-toon-green rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0">
                                    <i class="fa-regular fa-clock text-lg"></i>
                                </div>
                                <span>{{ $event->start_time }} WIB - Selesai</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-toon-pink rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0 mt-1">
                                    <i class="fa-solid fa-map-location-dot text-lg"></i>
                                </div>
                                <div>
                                    <span class="block font-comic text-xl text-toon-purple tracking-wide">{{ $event->venue_name }}</span>
                                    <span class="text-sm font-medium text-gray-600 block mt-1 leading-snug">{{ $event->address }}</span>
                                </div>
                            </li>
                        </ul>

                        <div class="flex flex-col gap-3">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->address) }}" target="_blank" class="btn-toon bg-toon-blue text-white py-3 text-center w-full block">
                                <i class="fa-solid fa-map"></i> BUKA PETA LOKASI
                            </a>
                            <button onclick="openGiftModal()" class="btn-toon bg-toon-pink text-white py-3 text-center w-full block">
                                <i class="fa-solid fa-gift"></i> KIRIM KADO DIGITAL
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Fallback Static Preview Event Card -->
                    <div class="card-toon bg-white p-6 transform rotate-[-1deg] hover:rotate-0 transition-transform">
                        <div class="flex items-center gap-3 mb-4 border-b-4 border-toon-dark pb-2">
                            <span class="text-3xl">🎂</span>
                            <h3 class="font-comic text-2xl text-toon-pink">Pesta Utama</h3>
                        </div>
                        
                        <ul class="space-y-4 font-round font-bold text-toon-dark mb-6">
                            <li class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-toon-blue rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0">
                                    <i class="fa-regular fa-calendar-check text-lg"></i>
                                </div>
                                <span>Minggu, 15 Agustus 2026</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-toon-green rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0">
                                    <i class="fa-regular fa-clock text-lg"></i>
                                </div>
                                <span>15.00 WIB - Selesai</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-toon-pink rounded-full border-2 border-toon-dark flex items-center justify-center text-white shadow-toon-sm shrink-0 mt-1">
                                    <i class="fa-solid fa-map-location-dot text-lg"></i>
                                </div>
                                <div>
                                    <span class="block font-comic text-xl text-toon-purple tracking-wide">Taman Bermain Anak</span>
                                    <span class="text-sm font-medium text-gray-600 block mt-1 leading-snug">Jl. Pelangi Ceria No. 123, Kota Bahagia</span>
                                </div>
                            </li>
                        </ul>

                        <div class="flex flex-col gap-3">
                            <a href="https://www.google.com/maps/search/?api=1&query=Taman+Bermain" target="_blank" class="btn-toon bg-toon-blue text-white py-3 text-center w-full block">
                                <i class="fa-solid fa-map"></i> BUKA PETA LOKASI
                            </a>
                            <button onclick="openGiftModal()" class="btn-toon bg-toon-pink text-white py-3 text-center w-full block">
                                <i class="fa-solid fa-gift"></i> KIRIM KADO DIGITAL
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- RSVP & Wishes Section -->
        <section class="py-12 px-6 relative reveal">
            <h2 class="font-comic text-3xl text-center text-toon-dark mb-6">BUKU TAMU</h2>

            <!-- RSVP Form -->
            <div class="card-toon bg-toon-blue p-5 mb-8 transform rotate-1">
                <div class="bg-white rounded-xl p-4 border-2 border-toon-dark">
                    <form id="form-rsvp" onsubmit="submitRsvp(event)" class="space-y-4">
                        <div>
                            <label class="font-comic text-lg text-toon-dark block mb-1">Siapa namamu?</label>
                            <input type="text" id="rsvp-name" class="input-toon" placeholder="Nama panggilan" value="{{ request()->get('to') }}" required>
                        </div>
                        <div>
                            <label class="font-comic text-lg text-toon-dark block mb-1">Bisa datang nggak?</label>
                            <select id="rsvp-status" class="input-toon" required>
                                <option value="" disabled selected>Pilih dong!</option>
                                <option value="hadir">Yey, Pasti Datang! 🏃‍♂️💨</option>
                                <option value="tidak_hadir">Yaaah, Gak Bisa 😢</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-comic text-lg text-toon-dark block mb-1">Pesan buat aku:</label>
                            <textarea id="rsvp-message" rows="2" class="input-toon" placeholder="Selamat ulang tahun!"></textarea>
                        </div>
                        <button type="submit" class="btn-toon bg-toon-yellow text-toon-dark w-full py-3 text-lg mt-2">
                            KIRIM PESAN! 🚀
                        </button>
                    </form>
                </div>
            </div>

            <!-- Guestbook Wall -->
            <div class="card-toon bg-white p-5">
                <h3 class="font-comic text-2xl text-toon-pink mb-4 border-b-2 border-dashed border-gray-300 pb-2">Pesan Teman-teman:</h3>
                
                <div id="wishes-list" class="space-y-3 max-h-60 overflow-y-auto pr-2">
                    <!-- Dummy Chat Bubble 1 -->
                    <div class="bg-toon-paper border-2 border-toon-dark p-3 rounded-2xl rounded-tl-none relative">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-comic text-toon-blue">Daffa</span>
                            <span class="text-[9px] bg-toon-green text-white px-2 py-1 border border-toon-dark rounded-full font-bold">DATANG</span>
                        </div>
                        <p class="font-round text-sm font-bold text-gray-700">Selamat ulang tahun! Nanti kita main bola bareng yaa!</p>
                    </div>
                    <!-- Dummy Chat Bubble 2 -->
                    <div class="bg-toon-yellow border-2 border-toon-dark p-3 rounded-2xl rounded-tr-none relative ml-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-comic text-toon-pink">Aisyah</span>
                            <span class="text-[9px] bg-toon-green text-white px-2 py-1 border border-toon-dark rounded-full font-bold">DATANG</span>
                        </div>
                        <p class="font-round text-sm font-bold text-gray-700">Happy Bday! Semoga kuenya enak hihihi 🍰</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="text-center pb-8 pt-4">
            <p class="font-comic text-toon-dark text-lg anim-wiggle inline-block">See you at the party! 🎉</p>
        </footer>

    </main>

    <!-- Custom Cartoon Toast -->
    <div id="toast" class="fixed top-10 left-1/2 -translate-x-1/2 bg-white border-4 border-toon-dark px-6 py-3 rounded-full z-[9999] opacity-0 pointer-events-none transition-all duration-300 transform -translate-y-10 shadow-toon flex items-center gap-3">
        <span class="text-2xl">🔔</span>
        <span id="toast-text" class="font-round font-bold text-toon-dark"></span>
    </div>

    <!-- Digital Gift Modal Popup -->
    <div id="gift-modal" class="fixed inset-0 z-[10000] bg-toon-dark/80 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity">
        <div class="card-toon bg-white w-full max-w-sm p-6 transform scale-90 transition-transform duration-300" id="gift-card">
            
            <button onclick="closeGiftModal()" class="absolute -top-4 -right-4 w-10 h-10 bg-toon-pink border-4 border-toon-dark rounded-full text-white font-black text-xl flex items-center justify-center btn-toon shadow-toon-sm z-10">
                X
            </button>

            <div class="text-center mb-6">
                <div class="text-5xl mb-2">🎁</div>
                <h3 class="font-comic text-3xl text-toon-blue">KOTAK KADO</h3>
                <p class="font-round text-xs font-bold text-gray-500 mt-1">Kalau mau kasih kado digital, bisa kesini ya tante/om!</p>
            </div>

            <div class="space-y-4 font-round">
                <!-- Rekening 1 -->
                <div class="bg-toon-paper border-2 border-toon-dark p-3 rounded-xl relative">
                    <span class="font-comic text-toon-blue block mb-1">BANK BCA</span>
                    <div class="flex gap-2">
                        <input type="text" id="rek-bca" value="1234567890" class="input-toon py-1 px-2 text-sm" readonly>
                        <button onclick="copyText('rek-bca')" class="btn-toon bg-toon-yellow px-3 text-sm shrink-0">SALIN</button>
                    </div>
                    <p class="text-xs font-bold text-gray-500 mt-1">a.n Ayah/Ibu {{ $invitation->profile->first_name ?? 'Anak' }}</p>
                </div>

                <!-- Rekening 2 -->
                <div class="bg-toon-paper border-2 border-toon-dark p-3 rounded-xl relative">
                    <span class="font-comic text-toon-green block mb-1">GOPAY / DANA</span>
                    <div class="flex gap-2">
                        <input type="text" id="rek-ewallet" value="081234567890" class="input-toon py-1 px-2 text-sm" readonly>
                        <button onclick="copyText('rek-ewallet')" class="btn-toon bg-toon-pink text-white px-3 text-sm shrink-0">SALIN</button>
                    </div>
                    <p class="text-xs font-bold text-gray-500 mt-1">a.n Ayah/Ibu {{ $invitation->profile->first_name ?? 'Anak' }}</p>
                </div>
            </div>
        </div>
    </div>


    <script>
        /* ─── BLADE PREVIEW ENGINE ─── */
        // Menjaga agar tampilan preview di client tetap bagus walaupun variabel blade belum di-render server
        document.addEventListener("DOMContentLoaded", function() {
            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
            let node;
            const nodesToClean = [];

            while (node = walker.nextNode()) {
                const text = node.nodeValue;
                if (text.includes('@if') || text.includes('@foreach') || text.includes('@endforeach') || text.includes('@else') || text.includes('@endif')) {
                    nodesToClean.push({ node, type: 'directive' });
                } else if (text.includes('{{') && text.includes('}}')) {
                    nodesToClean.push({ node, type: 'variable', originalText: text });
                }
            }

            nodesToClean.forEach(item => {
                if (item.type === 'directive') {
                    item.node.nodeValue = '';
                } else if (item.type === 'variable') {
                    let cleanValue = item.originalText;
                    if (cleanValue.includes('first_name') || cleanValue.includes('NAMA')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'BIMA');
                    } else if (cleanValue.includes('last_name') || cleanValue.includes('ANAK')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'BINTANG');
                    } else if (cleanValue.includes("get('to')") || cleanValue.includes('Teman-Teman')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Teman-Temanku');
                    } else if (cleanValue.includes('title')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Bima Birthday!');
                    } else if (cleanValue.includes('event->name')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Pesta Seru');
                    } else if (cleanValue.includes('event_date')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Minggu, 15 Agustus 2026');
                    } else if (cleanValue.includes('start_time')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, '15.00');
                    } else if (cleanValue.includes('venue_name')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Taman Bermain Anak');
                    } else if (cleanValue.includes('address')) {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, 'Jl. Pelangi Ceria No. 123');
                    } else {
                        cleanValue = cleanValue.replace(/\{\{[^}]+\}\}/g, '');
                    }
                    item.node.nodeValue = cleanValue;
                }
            });

            document.querySelectorAll('input, select, textarea').forEach(el => {
                if (el.value.includes('{{')) el.value = '';
                if (el.placeholder.includes('{{')) el.placeholder = 'Ketik disini...';
            });
        });

        /* ─── CORE LOGIC ─── */
        const audio = document.getElementById('bg-audio');
        const audioControl = document.getElementById('audio-control');
        const audioIcon = document.getElementById('audio-icon');
        const targetDateStr = "{{ $invitation->event_date ?? '2026-08-15' }}T15:00:00";
        let isOpened = false;

        // 1. OPEN GIFT (Mulai acara)
        function openGift() {
            if (isOpened) return;
            isOpened = true;

            // Slide up cover
            document.getElementById('opening-cover').classList.add('opened');
            
            // Show audio button
            audioControl.style.display = 'flex';

            // Play Music
            audio.load();
            audio.play().then(() => {
                audioIcon.classList.remove('fa-music');
                audioIcon.classList.add('fa-volume-high');
            }).catch(e => console.log("Audio autoplay blocked by browser"));

            // Start countdown & effects
            initCountdown();
            startConfetti();
        }

        // 2. TOGGLE AUDIO
        function toggleAudio() {
            if (audio.paused) {
                audio.play();
                audioIcon.classList.replace('fa-volume-xmark', 'fa-volume-high');
                audioIcon.classList.add('anim-wiggle');
            } else {
                audio.pause();
                audioIcon.classList.replace('fa-volume-high', 'fa-volume-xmark');
                audioIcon.classList.remove('anim-wiggle');
            }
        }

        // 3. SCROLL REVEAL ANIMATION
        const reveals = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });
        reveals.forEach(el => revealObserver.observe(el));

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

        // 5. TOAST MESSAGE
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

        // 6. RSVP SUBMIT
        function submitRsvp(e) {
            e.preventDefault();
            const name = document.getElementById('rsvp-name').value.trim();
            const status = document.getElementById('rsvp-status').value;
            const msg = document.getElementById('rsvp-message').value.trim();

            if (!name || !status) return;

            const isAttending = status === 'hadir';
            const badgeClass = isAttending ? 'bg-toon-green text-white' : 'bg-toon-pink text-white';
            const badgeText = isAttending ? 'DATANG' : 'GAK BISA';
            
            // Random bubble color
            const colors = ['bg-toon-paper', 'bg-toon-yellow', 'bg-blue-100'];
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            const alignClass = Math.random() > 0.5 ? 'rounded-tl-none mr-4' : 'rounded-tr-none ml-4';

            const list = document.getElementById('wishes-list');
            const newItem = document.createElement('div');
            newItem.className = `${randomColor} border-2 border-toon-dark p-3 rounded-2xl ${alignClass} relative mb-3`;
            newItem.innerHTML = `
                <div class="flex justify-between items-center mb-1">
                    <span class="font-comic text-toon-blue">${name}</span>
                    <span class="text-[9px] ${badgeClass} px-2 py-1 border border-toon-dark rounded-full font-bold">${badgeText}</span>
                </div>
                <p class="font-round text-sm font-bold text-gray-700">${msg || 'Selamat Ulang Tahun!!'}</p>
            `;
            list.prepend(newItem);

            showToast(`Yay! Makasih ${name} pesannya masuk!`);
            document.getElementById('form-rsvp').reset();
        }

        // 7. GIFT MODAL & COPY TEXT
        function openGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-card');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                card.classList.remove('scale-90');
                card.classList.add('scale-100');
            }, 10);
        }

        function closeGiftModal() {
            const modal = document.getElementById('gift-modal');
            const card = document.getElementById('gift-card');
            card.classList.add('scale-90');
            card.classList.remove('scale-100');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

        function copyText(inputId) {
            const input = document.getElementById(inputId);
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');
            showToast('Nomor berhasil disalin! 📋');
        }

        // 8. BIG CARTOON CONFETTI
        const canvas = document.getElementById('confetti');
        const ctx = canvas.getContext('2d');
        let confettis = [];
        const colors = ['#4D96FF', '#FFD93D', '#FF6B6B', '#6BCB77', '#9D65C9', '#1A1A2E'];

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        class Confetti {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height - canvas.height;
                this.size = Math.random() * 15 + 10; // Big chunky confetti
                this.color = colors[Math.floor(Math.random() * colors.length)];
                this.speedY = Math.random() * 4 + 2;
                this.speedX = Math.random() * 4 - 2;
                this.rotation = Math.random() * 360;
                this.rotationSpeed = Math.random() * 10 - 5;
            }
            update() {
                this.y += this.speedY;
                this.x += this.speedX;
                this.rotation += this.rotationSpeed;
                if (this.y > canvas.height) {
                    this.y = -20;
                    this.x = Math.random() * canvas.width;
                }
            }
            draw() {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.rotation * Math.PI / 180);
                
                // Draw outline for cartoon effect
                ctx.lineWidth = 3;
                ctx.strokeStyle = '#1A1A2E';
                ctx.fillStyle = this.color;
                
                ctx.beginPath();
                ctx.rect(-this.size/2, -this.size/2, this.size, this.size);
                ctx.fill();
                ctx.stroke();
                
                ctx.restore();
            }
        }

        function startConfetti() {
            canvas.classList.remove('hidden');
            resizeCanvas();
            for (let i = 0; i < 40; i++) confettis.push(new Confetti());
            animateConfetti();
        }

        function animateConfetti() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            confettis.forEach(c => { c.update(); c.draw(); });
            requestAnimationFrame(animateConfetti);
        }

        window.addEventListener('resize', resizeCanvas);
    </script>
</body>
</html>