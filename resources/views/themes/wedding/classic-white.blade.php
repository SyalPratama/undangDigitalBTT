<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400&family=Montserrat:wght@200;300;400;500;600&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.05em;
        }

        .heading-font {
            font-family: 'Playfair Display', serif;
            letter-spacing: 0.02em;
        }

        /* Hero Background with Classic Subtle Overlay */
        .hero-bg {
            background:
                linear-gradient(rgba(255, 255, 255, 0.75),
                    rgba(255, 255, 255, 0.85)),
                url('{{ $invitation->cover?->file_path
                    ? asset('storage/' . $invitation->cover->file_path)
                    : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000' }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* Premium Aesthetic Corner Florals (White Classic Gold Accent) */
        .floral-corner {
            background-image: url('https://images.unsplash.com/photo-1526047932273-341f2a7631f9?q=80&w=500');
            /* Tekstur bunga samar di background */
            opacity: 0.04;
            mix-blend-mode: multiply;
        }

        /* SVG Floral Corner Decoration Style Injection */
        .floral-ornament {
            position: absolute;
            width: 140px;
            height: 140px;
            opacity: 0.15;
            pointer-events: none;
            z-index: 5;
        }

        .top-left-flower {
            top: 0;
            left: 0;
            transform: scaleX(-1);
            filter: sepia(0.3) hue-rotate(10deg);
        }

        .top-right-flower {
            top: 0;
            right: 0;
            filter: sepia(0.3) hue-rotate(10deg);
        }

        .bottom-left-flower {
            bottom: 0;
            left: 0;
            transform: scale(-1);
            filter: sepia(0.3) hue-rotate(10deg);
        }

        .bottom-right-flower {
            bottom: 0;
            right: 0;
            transform: scaleY(-1);
            filter: sepia(0.3) hue-rotate(10deg);
        }

        .gold-accent {
            color: #bfa15f;
        }

        .gold-border {
            border-color: #e5d5b5;
        }

        .gold-bg {
            background-color: #bfa15f;
        }

        /* Lock scroll when envelope is closed */
        body.envelope-active {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-white text-[#333333] antialiased selection:bg-[#e5d5b5] envelope-active">

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    <button id="musicToggle" onclick="toggleMusic()"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-white/90 text-[#bfa15f] rounded-full border border-[#e5d5b5] shadow-lg flex items-center justify-center hidden hover:bg-white transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-compact-disc fa-spin text-xl"></i>
    </button>


    <div id="envelopeOverlay"
        class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-all duration-1000 ease-in-out transform translate-y-0 overflow-hidden">

        <div class="absolute inset-0 floral-corner"></div>
        <img src="https://cdn.pixabay.com/photo/2017/08/12/10/16/pattern-2633917_1280.png"
            class="absolute inset-0 w-full h-full object-cover opacity-[0.03] pointer-events-none">

        <div
            class="absolute top-0 left-0 w-32 h-32 md:w-48 md:h-48 border-t-2 border-l-2 gold-border m-6 md:m-12 opacity-40">
        </div>
        <div
            class="absolute bottom-0 right-0 w-32 h-32 md:w-48 md:h-48 border-b-2 border-r-2 gold-border m-6 md:m-12 opacity-40">
        </div>

        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.4em] uppercase text-xs text-gray-400 mb-4 font-light">WEDDING INVITATION</p>

            <h2 class="heading-font text-4xl md:text-5xl font-light text-[#1a1a1a] mb-2">
                {{ $invitation->profile->first_name ?? '' }}
                <span class="gold-accent italic text-2xl heading-font block md:inline my-1 md:my-0 mx-2">&</span>
                {{ $invitation->profile->second_name ?? '' }}
            </h2>

            <div class="w-16 h-[1px] bg-[#bfa15f] mx-auto my-6 opacity-60"></div>

            <p class="text-xs text-gray-400 uppercase tracking-widest font-light mb-8">
                Kepada Bapak/Ibu/Saudara/i:
            </p>

            <div
                class="bg-[#f9f9f9] border gold-border/60 py-4 px-8 rounded-lg shadow-sm mb-10 max-w-sm mx-auto backdrop-blur-sm">
                <p class="text-[#1a1a1a] font-medium tracking-wide text-base">
                    {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
                </p>
            </div>

            <button onclick="openInvitation()"
                class="inline-flex items-center gap-3 px-8 py-3.5 bg-[#1a1a1a] hover:bg-[#bfa15f] text-white text-xs uppercase tracking-[0.2em] font-medium rounded-full transition-all duration-500 transform hover:scale-105 shadow-md">
                <i class="fa-solid fa-envelope-open text-xs"></i> Buka Undangan
            </button>
        </div>
    </div>


    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-6 relative overflow-hidden">
        <div class="absolute inset-6 md:inset-12 border gold-border opacity-40 pointer-events-none"></div>

        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png"
            class="floral-ornament top-left-flower" alt="">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png"
            class="floral-ornament top-right-flower" alt="">

        <div class="max-w-4xl z-10 py-12">
            <p class="tracking-[0.5em] uppercase text-xs md:text-sm text-gray-500 mb-8 font-light">
                The Wedding Celebration Of
            </p>

            <h1 class="heading-font text-5xl md:text-7xl font-light text-[#1a1a1a] leading-tight">
                {{ $invitation->profile->first_name ?? '' }}
            </h1>

            <div class="my-6 text-2xl md:text-3xl italic gold-accent heading-font font-light">
                and
            </div>

            <h1 class="heading-font text-5xl md:text-7xl font-light text-[#1a1a1a] leading-tight mb-12">
                {{ $invitation->profile->second_name ?? '' }}
            </h1>

            <div class="inline-block border-t border-b gold-border py-3 px-8 mt-4 bg-white/40 backdrop-blur-xs">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-1 font-medium">
                    Save The Date
                </p>
                <p class="heading-font text-xl md:text-2xl text-[#1a1a1a] font-medium">
                    {{ optional($invitation->event_date)->format('d . m . Y') }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-white relative overflow-hidden">
        <div class="absolute inset-0 floral-corner"></div>

        <div class="max-w-2xl mx-auto text-center relative z-10">
            <div class="text-4xl text-gray-300 heading-font mb-4">“</div>
            <h2 class="heading-font text-xl md:text-2xl mb-8 tracking-wide text-[#1a1a1a] italic font-light">
                Bismillahirrahmanirrahim
            </h2>
            <p class="leading-relaxed text-gray-500 font-light text-sm md:text-base italic px-4">
                {{ $invitation->profile->quote }}
            </p>
            <div class="text-4xl text-gray-300 heading-font mt-4">”</div>
        </div>
    </section>

    <section class="bg-[#f9f9f9] py-32 px-6 border-t border-b border-gray-100 relative overflow-hidden">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png"
            class="floral-ornament top-right-flower opacity-10" alt="">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png"
            class="floral-ornament bottom-left-flower opacity-10" alt="">

        <div class="max-w-5xl mx-auto relative z-10">
            <div class="grid md:grid-cols-2 gap-24 md:gap-16 items-center">

                <div class="text-center group">
                    @if ($invitation->firstPersonPhoto)
                        <div
                            class="w-72 h-[400px] mx-auto overflow-hidden shadow-sm border-4 border-white transition-all duration-700 group-hover:shadow-xl relative">
                            <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                class="w-full h-full object-cover grayscale-[20%] hover:grayscale-0 transition-all duration-700 scale-100 hover:scale-105">
                        </div>
                    @endif

                    <h3 class="heading-font text-4xl mt-8 text-[#1a1a1a] font-light">
                        {{ $invitation->profile->first_name }}
                    </h3>
                    <div class="w-8 h-[1px] bg-[#bfa15f] mx-auto my-4"></div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-light mb-2">
                        Putra Kekasih dari
                    </p>
                    <p class="font-light text-sm md:text-base text-gray-600">
                        <span class="font-medium text-gray-800">{{ $invitation->profile->first_father }}</span>
                        <br>&<br>
                        <span class="font-medium text-gray-800">{{ $invitation->profile->first_mother }}</span>
                    </p>
                </div>

                <div class="text-center group">
                    @if ($invitation->secondPersonPhoto)
                        <div
                            class="w-72 h-[400px] mx-auto overflow-hidden shadow-sm border-4 border-white transition-all duration-700 group-hover:shadow-xl relative">
                            <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                class="w-full h-full object-cover grayscale-[20%] hover:grayscale-0 transition-all duration-700 scale-100 hover:scale-105">
                        </div>
                    @endif

                    <h3 class="heading-font text-4xl mt-8 text-[#1a1a1a] font-light">
                        {{ $invitation->profile->second_name }}
                    </h3>
                    <div class="w-8 h-[1px] bg-[#bfa15f] mx-auto my-4"></div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-light mb-2">
                        Putri Kekasih dari
                    </p>
                    <p class="font-light text-sm md:text-base text-gray-600">
                        <span class="font-medium text-gray-800">{{ $invitation->profile->second_father }}</span>
                        <br>&<br>
                        <span class="font-medium text-gray-800">{{ $invitation->profile->second_mother }}</span>
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-white relative overflow-hidden">
        <div class="absolute inset-0 floral-corner"></div>

        <div class="max-w-4xl mx-auto relative z-10">
            <div class="text-center mb-20">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-2 font-light">The Day Of</p>
                <h2 class="heading-font text-4xl md:text-5xl text-[#1a1a1a] font-light">
                    Wedding Events
                </h2>
                <div class="w-12 h-[1px] bg-[#bfa15f] mx-auto mt-4"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                @foreach ($invitation->events as $event)
                    <div
                        class="bg-white/90 backdrop-blur-xs border border-gray-100 p-10 md:p-12 text-center shadow-sm relative transition-all duration-300 hover:shadow-md hover:border-[#e5d5b5]">
                        <div class="absolute top-4 left-4 right-4 bottom-4 border border-gray-50 pointer-events-none">
                        </div>

                        <h3 class="heading-font text-2xl md:text-3xl text-[#1a1a1a] mb-6 font-light">
                            {{ $event->name }}
                        </h3>

                        <div class="text-xs uppercase tracking-widest text-gray-400 mb-1 font-light">Tanggal</div>
                        <p class="text-gray-700 text-sm font-medium mb-6">
                            {{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}
                        </p>

                        <div class="text-xs uppercase tracking-widest text-gray-400 mb-1 font-light">Waktu</div>
                        <p class="text-gray-700 text-sm font-medium mb-6">
                            {{ $event->start_time }} - Selesai
                        </p>

                        <div class="w-8 h-[1px] bg-gray-200 mx-auto mb-6"></div>

                        <div class="text-xs uppercase tracking-widest text-gray-400 mb-1 font-light">Tempat</div>
                        <p class="text-gray-900 text-sm font-semibold mb-2 heading-font tracking-wide">
                            {{ $event->venue_name }}
                        </p>
                        <p class="text-gray-400 text-xs font-light leading-relaxed max-w-xs mx-auto">
                            {{ $event->address }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#f9f9f9] py-32 px-6 border-t border-b border-gray-100 relative overflow-hidden">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png"
            class="floral-ornament top-left-flower opacity-10" alt="">
        <img src="https://www.transparentpng.com/download/floral/vintage-gold-floral-corner-png-3.png"
            class="floral-ornament bottom-right-flower opacity-10" alt="">

        <div class="max-w-6xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <p class="text-xs uppercase tracking-[0.4em] text-gray-400 mb-2 font-light">Captured Moments</p>
                <h2 class="heading-font text-4xl md:text-5xl text-[#1a1a1a] font-light">
                    Our Gallery
                </h2>
                <div class="w-12 h-[1px] bg-[#bfa15f] mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach ($invitation->galleries as $gallery)
                    <div
                        class="overflow-hidden bg-white p-3 shadow-sm transition-all duration-500 hover:shadow-lg group">
                        <img src="{{ asset($gallery->file_path) }}"
                            class="w-full h-80 object-cover transition-all duration-700 filter contrast-[95%] group-hover:contrast-100 scale-100 group-hover:scale-102">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-32 px-6 bg-white relative overflow-hidden">
        <div class="absolute inset-0 floral-corner"></div>

        <div class="max-w-3xl mx-auto text-center z-10 relative">
            <h2 class="heading-font text-4xl md:text-5xl mb-8 text-[#1a1a1a] font-light">
                Terima Kasih
            </h2>

            <p class="text-gray-500 font-light text-sm md:text-base leading-loose max-w-2xl mx-auto mb-16">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila
                Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu kepada kedua mempelai.
            </p>

            <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-4 font-light">Kami yang berbahagia</p>
            <div class="mt-4">
                <h3 class="heading-font text-3xl md:text-4xl font-light text-[#1a1a1a]">
                    {{ $invitation->profile->first_name }} & {{ $invitation->profile->second_name }}
                </h3>
            </div>
        </div>
    </section>


    <script>
        const audio = document.getElementById('weddingMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        function openInvitation() {
            // Slide up and fade out the envelope cover overlay smoothly
            const envelope = document.getElementById('envelopeOverlay');
            envelope.style.transform = 'translateY(-100%)';
            envelope.style.opacity = '0';

            // Re-enable page scrolling
            document.body.classList.remove('envelope-active');

            // Show the floating music trigger
            musicBtn.classList.remove('hidden');

            // Play background music gracefully
            audio.play().catch(error => {
                console.log("Autoplay blocked by browser policy, waiting for direct click interaction.");
            });

            // Automatically sweep overlay away after transition completes
            setTimeout(() => {
                envelope.classList.add('hidden');
            }, 1000);
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
