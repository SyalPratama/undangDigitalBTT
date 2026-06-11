<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #FAFCFA;
        }

        .heading-font {
            font-family: 'Cormorant Garamond', serif;
        }

        .hero-bg {
            background:
                linear-gradient(rgba(250, 252, 250, 0.85), rgba(250, 252, 250, 0.95)),
                url('{{ $invitation->cover?->file_path ? asset('storage/' . $invitation->cover->file_path) : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000' }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .floral-ornament {
            position: absolute;
            width: 160px;
            height: 160px;
            opacity: 0.25;
            pointer-events: none;
            z-index: 5;
        }

        /* Filter mengubah ornamen emas menjadi Sage Green */
        .sage-filter {
            filter: hue-rotate(90deg) saturate(0.6) brightness(0.8);
        }

        .top-left-flower { top: 0; left: 0; transform: scaleX(-1); }
        .top-right-flower { top: 0; right: 0; }
        .bottom-left-flower { bottom: 0; left: 0; transform: scale(-1); }
        .bottom-right-flower { bottom: 0; right: 0; transform: scaleY(-1); }

        .theme-accent { color: #849C81; } /* Sage Green */
        .theme-border { border-color: #C3D1C1; }
        .theme-bg { background-color: #849C81; }

        /* Estetika Arch (Lengkungan Khas Undangan Modern) */
        .arch-frame {
            border-radius: 150px 150px 0 0;
        }

        body.envelope-active { overflow: hidden; }
    </style>
</head>

<body class="text-[#2C362C] antialiased selection:bg-[#C3D1C1] envelope-active">

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    <button id="musicToggle" onclick="toggleMusic()"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-white/90 text-[#849C81] rounded-full border border-[#C3D1C1] shadow-lg flex items-center justify-center hidden hover:bg-white transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-compact-disc fa-spin text-xl"></i>
    </button>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#FAFCFA] transition-all duration-1000 transform translate-y-0 overflow-hidden">
        
        <div class="absolute inset-4 border theme-border opacity-50 rounded-2xl pointer-events-none"></div>

        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.3em] uppercase text-xs text-[#849C81] mb-6 font-semibold">The Wedding Of</p>

            <h2 class="heading-font text-5xl md:text-6xl text-[#2C362C] mb-2">
                {{ $invitation->profile->first_name ?? '' }}
                <span class="theme-accent italic text-3xl md:text-4xl mx-2">&</span>
                {{ $invitation->profile->second_name ?? '' }}
            </h2>

            <div class="w-12 h-[1px] theme-bg mx-auto my-8"></div>

            <p class="text-xs text-gray-500 uppercase tracking-widest font-light mb-4">Special Invitation For:</p>

            <div class="bg-white border theme-border py-3 px-10 rounded-full shadow-sm mb-10 inline-block">
                <p class="text-[#2C362C] font-semibold tracking-wide">
                    {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
                </p>
            </div>

            <br>

            <button onclick="openInvitation()"
                class="inline-flex items-center gap-2 px-10 py-3 bg-[#2C362C] hover:bg-[#849C81] text-white text-xs uppercase tracking-[0.2em] rounded-full transition-all duration-500">
                Open Invitation
            </button>
        </div>
    </div>

    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-6 relative overflow-hidden">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament top-left-flower sage-filter" alt="">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament top-right-flower sage-filter" alt="">

        <div class="max-w-4xl z-10 py-12">
            <div class="w-[1px] h-20 theme-bg mx-auto mb-8"></div>
            <p class="tracking-[0.4em] uppercase text-xs md:text-sm text-[#849C81] mb-6 font-semibold">We Are Getting Married</p>

            <h1 class="heading-font text-6xl md:text-8xl text-[#2C362C]">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>
            <div class="my-2 text-4xl italic theme-accent heading-font">&</div>
            <h1 class="heading-font text-6xl md:text-8xl text-[#2C362C] mb-10">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <p class="text-sm uppercase tracking-[0.3em] text-gray-600 font-medium">
                {{ optional($invitation->event_date)->format('d . m . Y') }}
            </p>
        </div>
    </section>

    <section class="py-24 px-6 bg-[#849C81] text-white text-center">
        <div class="max-w-3xl mx-auto">
            <i class="fa-solid fa-leaf text-2xl mb-6 opacity-70"></i>
            <p class="leading-relaxed font-light text-base md:text-lg italic px-4">
                "{{ $invitation->profile->quote }}"
            </p>
        </div>
    </section>

    <section class="py-32 px-6 relative bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                
                <div class="text-center">
                    @if ($invitation->firstPersonPhoto)
                        <div class="w-64 h-80 mx-auto overflow-hidden arch-frame border border-[#C3D1C1] p-2 mb-8">
                            <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover arch-frame grayscale-[30%]">
                        </div>
                    @endif
                    <h3 class="heading-font text-4xl text-[#2C362C] mb-4">{{ $invitation->profile->first_name }}</h3>
                    <p class="text-xs uppercase tracking-widest text-[#849C81] mb-2">Putra dari</p>
                    <p class="text-sm text-gray-600">Bpk. {{ $invitation->profile->first_father }} & Ibu {{ $invitation->profile->first_mother }}</p>
                </div>

                <div class="text-center">
                    @if ($invitation->secondPersonPhoto)
                        <div class="w-64 h-80 mx-auto overflow-hidden arch-frame border border-[#C3D1C1] p-2 mb-8">
                            <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}" class="w-full h-full object-cover arch-frame grayscale-[30%]">
                        </div>
                    @endif
                    <h3 class="heading-font text-4xl text-[#2C362C] mb-4">{{ $invitation->profile->second_name }}</h3>
                    <p class="text-xs uppercase tracking-widest text-[#849C81] mb-2">Putri dari</p>
                    <p class="text-sm text-gray-600">Bpk. {{ $invitation->profile->second_father }} & Ibu {{ $invitation->profile->second_mother }}</p>
                </div>

            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-[#FAFCFA] relative overflow-hidden border-t border-gray-100">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament bottom-left-flower sage-filter opacity-10" alt="">
        <div class="max-w-5xl mx-auto relative z-10 text-center">
            <h2 class="heading-font text-5xl text-[#2C362C] mb-16">Wedding Details</h2>

            <div class="grid md:grid-cols-2 gap-8">
                @foreach ($invitation->events as $event)
                    <div class="bg-white border theme-border p-12 text-center rounded-2xl shadow-sm">
                        <h3 class="heading-font text-3xl theme-accent mb-6">{{ $event->name }}</h3>
                        
                        <p class="text-[#2C362C] font-semibold tracking-widest uppercase text-sm mb-2">
                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="text-gray-500 text-sm mb-8">{{ $event->start_time }} - Selesai</p>

                        <div class="w-12 h-[1px] theme-bg mx-auto mb-8"></div>

                        <p class="text-[#2C362C] font-bold mb-2">{{ $event->venue_name }}</p>
                        <p class="text-gray-500 text-xs leading-relaxed">{{ $event->address }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-32 px-6 text-center">
        <div class="max-w-6xl mx-auto">
            <h2 class="heading-font text-5xl text-[#2C362C] mb-12">Sweet Memories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($invitation->galleries as $gallery)
                    <div class="overflow-hidden bg-[#FAFCFA] p-2 border theme-border">
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-64 object-cover filter contrast-[90%] hover:contrast-100 transition-all duration-500">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-[#2C362C] text-white text-center">
        <div class="max-w-2xl mx-auto">
            <h2 class="heading-font text-5xl mb-8 theme-accent">Thank You</h2>
            <p class="font-light text-sm leading-loose mb-12 opacity-80">
                Kehadiran dan doa restu Bapak/Ibu/Saudara/i merupakan anugerah terindah bagi kami.
            </p>
            <h3 class="heading-font text-4xl">
                {{ $invitation->profile->first_name }} & {{ $invitation->profile->second_name }}
            </h3>
        </div>
    </section>

    <script>
        const audio = document.getElementById('weddingMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        function openInvitation() {
            const envelope = document.getElementById('envelopeOverlay');
            envelope.style.transform = 'translateY(-100%)';
            envelope.style.opacity = '0';
            document.body.classList.remove('envelope-active');
            musicBtn.classList.remove('hidden');
            audio.play().catch(e => console.log("Autoplay blocked"));
            setTimeout(() => envelope.classList.add('hidden'), 1000);
        }

        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                musicIcon.classList.add('fa-spin');
                musicIcon.className = "fa-solid fa-compact-disc fa-spin text-xl";
            } else {
                audio.pause();
                musicIcon.classList.remove('fa-spin');
                musicIcon.className = "fa-solid fa-circle-pause text-xl";
            }
        }
    </script>
</body>
</html>