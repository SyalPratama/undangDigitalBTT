<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Nunito:wght@200;300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            letter-spacing: 0.03em;
        }

        .heading-font {
            font-family: 'Lora', serif;
            letter-spacing: 0.05em;
        }

        /* Hero Background with Soft Blue Overlay */
        .hero-bg {
            background:
                linear-gradient(rgba(240, 244, 248, 0.8),
                    rgba(240, 244, 248, 0.9)),
                url('{{ $invitation->cover?->file_path
                    ? asset('storage/' . $invitation->cover->file_path)
                    : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000' }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .floral-corner {
            background-image: url('https://images.unsplash.com/photo-1526047932273-341f2a7631f9?q=80&w=500');
            opacity: 0.03;
            mix-blend-mode: multiply;
        }

        .floral-ornament {
            position: absolute;
            width: 150px;
            height: 150px;
            opacity: 0.2;
            pointer-events: none;
            z-index: 5;
        }

        /* Filter untuk mengubah ornamen menjadi warna dusty blue */
        .blue-filter {
            filter: hue-rotate(180deg) saturate(0.5) brightness(1.2);
        }

        .top-left-flower { top: 0; left: 0; transform: scaleX(-1); }
        .top-right-flower { top: 0; right: 0; }
        .bottom-left-flower { bottom: 0; left: 0; transform: scale(-1); }
        .bottom-right-flower { bottom: 0; right: 0; transform: scaleY(-1); }

        .theme-accent { color: #6B8EAD; } /* Dusty Blue */
        .theme-border { border-color: #A9C2D9; }
        .theme-bg { background-color: #6B8EAD; }

        body.envelope-active { overflow: hidden; }
    </style>
</head>

<body class="bg-[#F8FAFC] text-[#334155] antialiased selection:bg-[#A9C2D9] envelope-active">

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    <button id="musicToggle" onclick="toggleMusic()"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-white/90 text-[#6B8EAD] rounded-full border border-[#A9C2D9] shadow-lg flex items-center justify-center hidden hover:bg-white transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-compact-disc fa-spin text-xl"></i>
    </button>

    <div id="envelopeOverlay"
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#F0F4F8] transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden">
        
        <div class="absolute inset-0 floral-corner"></div>

        <div class="absolute top-0 left-0 w-32 h-32 md:w-48 md:h-48 border-t-2 border-l-2 theme-border m-6 md:m-12 opacity-60"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 md:w-48 md:h-48 border-b-2 border-r-2 theme-border m-6 md:m-12 opacity-60"></div>

        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.4em] uppercase text-xs text-[#6B8EAD] mb-4 font-semibold">WEDDING INVITATION</p>

            <h2 class="heading-font text-4xl md:text-5xl font-medium text-[#1e293b] mb-2">
                {{ $invitation->profile->first_name ?? '' }}
                <span class="theme-accent italic text-2xl heading-font block md:inline my-1 md:my-0 mx-2">&</span>
                {{ $invitation->profile->second_name ?? '' }}
            </h2>

            <div class="w-16 h-[1px] theme-bg mx-auto my-6 opacity-60"></div>

            <p class="text-xs text-slate-500 uppercase tracking-widest font-light mb-8">
                Kepada Bapak/Ibu/Saudara/i:
            </p>

            <div class="bg-white border theme-border/60 py-4 px-8 rounded-xl shadow-md mb-10 max-w-sm mx-auto">
                <p class="text-[#1e293b] font-medium tracking-wide text-base">
                    {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
                </p>
            </div>

            <button onclick="openInvitation()"
                class="inline-flex items-center gap-3 px-8 py-3.5 bg-[#6B8EAD] hover:bg-[#4a6b8c] text-white text-xs uppercase tracking-[0.2em] font-bold rounded-full transition-all duration-500 transform hover:scale-105 shadow-lg">
                <i class="fa-solid fa-envelope-open text-xs"></i> Buka Undangan
            </button>
        </div>
    </div>

    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-6 relative overflow-hidden">
        <div class="absolute inset-6 md:inset-12 border theme-border opacity-50 pointer-events-none rounded-3xl"></div>

        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament top-left-flower blue-filter" alt="">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament top-right-flower blue-filter" alt="">

        <div class="max-w-4xl z-10 py-12">
            <p class="tracking-[0.5em] uppercase text-xs md:text-sm text-[#6B8EAD] mb-8 font-bold">The Wedding Celebration Of</p>

            <h1 class="heading-font text-5xl md:text-7xl text-[#1e293b] leading-tight drop-shadow-sm">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>

            <div class="my-4 text-2xl md:text-3xl italic theme-accent heading-font">and</div>

            <h1 class="heading-font text-5xl md:text-7xl text-[#1e293b] leading-tight mb-12 drop-shadow-sm">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div class="inline-block border-t border-b theme-border py-3 px-8 mt-4 bg-white/60 backdrop-blur-md rounded-lg">
                <p class="text-xs uppercase tracking-[0.3em] text-[#6B8EAD] mb-1 font-bold">Save The Date</p>
                <p class="heading-font text-xl md:text-2xl text-[#1e293b] font-medium">
                    {{ optional($invitation->event_date)->format('d . m . Y') }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-white relative overflow-hidden">
        <div class="max-w-2xl mx-auto text-center relative z-10">
            <div class="text-5xl theme-accent heading-font mb-4 opacity-50">“</div>
            <h2 class="heading-font text-xl md:text-2xl mb-8 tracking-wide text-[#1e293b] italic">Bismillahirrahmanirrahim</h2>
            <p class="leading-relaxed text-slate-500 font-light text-sm md:text-base italic px-4">
                {{ $invitation->profile->quote }}
            </p>
            <div class="text-5xl theme-accent heading-font mt-4 opacity-50">”</div>
        </div>
    </section>

    <section class="bg-[#F0F4F8] py-32 px-6 relative overflow-hidden">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament top-right-flower blue-filter opacity-30" alt="">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png" class="floral-ornament bottom-left-flower blue-filter opacity-30" alt="">

        <div class="max-w-5xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-24 md:gap-16 items-center">
                <div class="text-center group">
                    @if ($invitation->firstPersonPhoto)
                        <div class="w-64 h-64 md:w-72 md:h-72 mx-auto overflow-hidden rounded-full shadow-lg border-8 border-white transition-all duration-700 group-hover:shadow-2xl">
                            <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover scale-100 hover:scale-110 transition-all duration-700">
                        </div>
                    @endif
                    <h3 class="heading-font text-3xl md:text-4xl mt-8 text-[#1e293b]">{{ $invitation->profile->first_name }}</h3>
                    <div class="w-12 h-[2px] theme-bg mx-auto my-4"></div>
                    <p class="text-xs uppercase tracking-widest text-[#6B8EAD] font-bold mb-2">Putra Kekasih dari</p>
                    <p class="font-light text-sm md:text-base text-slate-600">
                        <span class="font-semibold text-slate-800">{{ $invitation->profile->first_father }}</span> <br>&<br>
                        <span class="font-semibold text-slate-800">{{ $invitation->profile->first_mother }}</span>
                    </p>
                </div>

                <div class="text-center group">
                    @if ($invitation->secondPersonPhoto)
                        <div class="w-64 h-64 md:w-72 md:h-72 mx-auto overflow-hidden rounded-full shadow-lg border-8 border-white transition-all duration-700 group-hover:shadow-2xl">
                            <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}" class="w-full h-full object-cover scale-100 hover:scale-110 transition-all duration-700">
                        </div>
                    @endif
                    <h3 class="heading-font text-3xl md:text-4xl mt-8 text-[#1e293b]">{{ $invitation->profile->second_name }}</h3>
                    <div class="w-12 h-[2px] theme-bg mx-auto my-4"></div>
                    <p class="text-xs uppercase tracking-widest text-[#6B8EAD] font-bold mb-2">Putri Kekasih dari</p>
                    <p class="font-light text-sm md:text-base text-slate-600">
                        <span class="font-semibold text-slate-800">{{ $invitation->profile->second_father }}</span> <br>&<br>
                        <span class="font-semibold text-slate-800">{{ $invitation->profile->second_mother }}</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-white relative overflow-hidden">
        <div class="max-w-4xl mx-auto relative z-10">
            <div class="text-center mb-20">
                <p class="text-xs uppercase tracking-[0.4em] text-[#6B8EAD] mb-2 font-bold">The Day Of</p>
                <h2 class="heading-font text-4xl md:text-5xl text-[#1e293b]">Wedding Events</h2>
                <div class="w-12 h-[2px] theme-bg mx-auto mt-6"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @foreach ($invitation->events as $event)
                    <div class="bg-[#F8FAFC] border-t-4 border-[#6B8EAD] p-10 text-center shadow-md rounded-b-xl hover:-translate-y-2 transition-transform duration-300">
                        <h3 class="heading-font text-2xl md:text-3xl text-[#1e293b] mb-6">{{ $event->name }}</h3>
                        
                        <div class="mb-4">
                            <i class="fa-regular fa-calendar theme-accent text-xl mb-2"></i>
                            <p class="text-slate-700 font-semibold">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                            <p class="text-slate-500 text-sm">{{ $event->start_time }} - Selesai</p>
                        </div>

                        <div class="w-16 h-[1px] bg-slate-200 mx-auto my-6"></div>

                        <div>
                            <i class="fa-solid fa-location-dot theme-accent text-xl mb-2"></i>
                            <p class="text-[#1e293b] font-bold mb-2">{{ $event->venue_name }}</p>
                            <p class="text-slate-500 text-xs leading-relaxed max-w-xs mx-auto">{{ $event->address }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#F0F4F8] py-32 px-6 relative">
        <div class="max-w-6xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <p class="text-xs uppercase tracking-[0.4em] text-[#6B8EAD] mb-2 font-bold">Captured Moments</p>
                <h2 class="heading-font text-4xl md:text-5xl text-[#1e293b]">Our Gallery</h2>
                <div class="w-12 h-[2px] theme-bg mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($invitation->galleries as $gallery)
                    <div class="overflow-hidden rounded-xl shadow-sm group">
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-80 object-cover transition-all duration-700 group-hover:scale-110">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-[#6B8EAD] text-white relative text-center">
        <div class="max-w-3xl mx-auto relative z-10">
            <h2 class="heading-font text-4xl md:text-5xl mb-8">Terima Kasih</h2>
            <p class="font-light text-sm md:text-base leading-loose max-w-2xl mx-auto mb-16 opacity-90">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.
            </p>
            <p class="text-xs uppercase tracking-[0.3em] mb-4 font-bold opacity-80">Kami yang berbahagia</p>
            <h3 class="heading-font text-3xl md:text-4xl">
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