<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,400&family=Montserrat:wght@200;300;400;500&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #0d0d0d;
            letter-spacing: 0.08em;
        }

        .serif-premium {
            font-family: 'Cormorant Garamond', serif;
        }

        .display-royal {
            font-family: 'Cinzel', serif;
            letter-spacing: 0.15em;
        }

        /* Metallic Gold Shimmer Effect */
        .gold-gradient-text {
            background: linear-gradient(90deg, #96702d 0%, #f3e7c4 30%, #d4af37 70%, #8a6421 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shine 4s linear infinite;
        }

        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }

        /* Glassmorphism Luxury Card */
        .glass-gold-card {
            background: linear-gradient(135deg, rgba(25, 25, 25, 0.75) 0%, rgba(15, 15, 15, 0.9) 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(12px);
        }

        /* Art Deco Subtle Line Pattern */
        .bg-deco-overlay {
            background-image: radial-gradient(rgba(212, 175, 55, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Smooth Cover Slide-out */
        .envelope-hidden {
            transform: translateY(-100%);
            opacity: 0;
            pointer-events: none;
        }

        body.envelope-active {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-[#0d0d0d] text-[#e5e5e5] antialiased envelope-active">

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
    </audio>

    <button id="musicToggle" onclick="toggleMusic()"
        class="fixed bottom-8 right-8 z-50 w-14 h-14 bg-[#111]/90 text-[#d4af37] rounded-full border border-[#d4af37]/40 shadow-[0_0_15px_rgba(212,175,55,0.2)] flex items-center justify-center hidden hover:scale-110 transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-compass-drafting fa-spin text-xl"></i>
    </button>


    <div id="envelopeOverlay"
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#0a0a0a] transition-all duration-1000 ease-in-out overflow-hidden">

        <div class="absolute inset-0 bg-deco-overlay opacity-30"></div>

        <div class="absolute top-8 left-8 right-8 bottom-8 border border-[#d4af37]/10 pointer-events-none"></div>
        <div class="absolute top-12 left-12 right-12 bottom-12 border border-[#d4af37]/20 pointer-events-none"></div>

        <div class="max-w-2xl text-center px-6 z-10">
            <span class="display-royal text-[10px] tracking-[0.6em] text-[#d4af37] block mb-6">OFFICIAL
                INVITATION</span>

            <h2 class="serif-premium text-5xl md:text-7xl font-light text-white tracking-wide mb-4">
                {{ $invitation->profile->first_name ?? 'Groom' }}
                <span class="block text-2xl italic my-2 gold-gradient-text serif-premium">&</span>
                {{ $invitation->profile->second_name ?? 'Bride' }}
            </h2>

            <div class="w-12 h-[1px] bg-[#d4af37] mx-auto my-8"></div>

            <p class="text-[11px] uppercase tracking-[0.3em] text-gray-500 mb-4">Special Invitation For</p>

            <div
                class="glass-gold-card py-5 px-8 mb-10 max-w-sm mx-auto rounded-none shadow-[0_10px_30px_rgba(0,0,0,0.5)]">
                <span class="text-xs text-gray-400 block mb-1 font-light">Dear Honorable Guest,</span>
                <p class="serif-premium text-2xl font-light text-white tracking-wide">
                    {{ request()->get('to') ?? 'Tamu Undangan Terhormat' }}
                </p>
            </div>

            <button onclick="openInvitation()"
                class="group relative inline-flex items-center justify-center px-10 py-4 overflow-hidden border border-[#d4af37] transition-all duration-300 hover:bg-[#d4af37]/10">
                <span
                    class="absolute w-0 h-0 transition-all duration-500 ease-out bg-[#d4af37] rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                <span
                    class="relative display-royal text-xs text-[#d4af37] font-medium tracking-[0.3em] flex items-center gap-3">
                    <i class="fa-solid fa-gavel text-[10px]"></i> ENTER EXPERIENCE
                </span>
            </button>
        </div>
    </div>


    <section class="relative min-h-screen grid md:grid-cols-12 items-stretch overflow-hidden">
        <div
            class="md:col-span-5 bg-[#111] flex flex-col justify-between p-8 md:p-16 relative z-10 border-r border-[#d4af37]/10">
            <div class="absolute inset-0 bg-deco-overlay opacity-20"></div>

            <span class="display-royal text-xs text-[#d4af37] tracking-[0.5em]">CELEBRATION OF LOVE</span>

            <div class="my-auto py-12 md:py-0">
                <h1
                    class="display-royal text-6xl md:text-7xl font-bold text-white/5 tracking-tighter leading-none select-none absolute -left-4 top-1/3 transform -rotate-90 origin-left hidden md:block">
                    WEDDING</h1>
                <p class="serif-premium text-lg italic text-[#d4af37] mb-2">The Wedding of</p>
                <div class="serif-premium text-6xl md:text-7xl font-light text-white leading-none mb-4">
                    {{ $invitation->profile->first_name }}
                </div>
                <div class="serif-premium text-4xl italic gold-gradient-text my-2">&</div>
                <div class="serif-premium text-6xl md:text-7xl font-light text-white leading-none">
                    {{ $invitation->profile->second_name }}
                </div>
            </div>

            <div class="border-t border-[#d4af37]/30 pt-6 flex justify-between items-center">
                <div>
                    <span class="text-[10px] block uppercase text-gray-500 tracking-widest">Date of Event</span>
                    <span
                        class="display-royal text-lg text-white font-medium">{{ optional($invitation->event_date)->format('d . m . Y') }}</span>
                </div>
                <div class="w-12 h-[1px] bg-[#d4af37]/40"></div>
            </div>
        </div>

        <div class="md:col-span-7 relative min-h-[50vh] md:min-h-screen flex items-end p-8 md:p-16">
            <div class="absolute inset-0 bg-cover bg-center filter grayscale contrast-[110%] brightness-[40%]"
                style="background-image: url('{{ $invitation->cover?->file_path ? asset('storage/' . $invitation->cover->file_path) : 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=2000' }}');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0d0d] via-transparent to-transparent"></div>

            <div class="relative z-10 max-w-md glass-gold-card p-6 md:p-8">
                <p class="serif-premium text-xl italic text-white/90 font-light leading-relaxed">
                    "Two souls with but a single thought, two hearts that beat as one."
                </p>
            </div>
        </div>
    </section>


    <section class="py-36 px-6 bg-[#0a0a0a] relative text-center border-b border-[#d4af37]/10">
        <div class="max-w-3xl mx-auto">
            <span class="display-royal text-[10px] tracking-[0.4em] text-[#d4af37] block mb-8">THE SACRED
                COVENANT</span>
            <h2 class="serif-premium text-3xl md:text-4xl mb-6 text-white font-light italic">
                Bismillahirrahmanirrahim
            </h2>
            <p class="serif-premium text-lg md:text-xl text-gray-400 font-light leading-relaxed italic px-4 md:px-16">
                {{ $invitation->profile->quote }}
            </p>
            <div class="w-8 h-[1px] bg-[#d4af37] mx-auto mt-8"></div>
        </div>
    </section>


    <section class="bg-[#0d0d0d] py-36 px-6 relative overflow-hidden">
        <div class="max-w-5xl mx-auto space-y-32">

            <div class="grid md:grid-cols-12 gap-12 items-center">
                <div class="md:col-span-5 relative group">
                    <div
                        class="absolute -inset-4 border border-[#d4af37]/30 translate-x-2 translate-y-2 group-hover:translate-x-0 group-hover:translate-y-0 transition-all duration-500">
                    </div>
                    @if ($invitation->firstPersonPhoto)
                        <div
                            class="relative bg-[#111] p-3 border border-[#d4af37]/20 shadow-2xl overflow-hidden aspect-[3/4]">
                            <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                                class="w-full h-full object-cover filter grayscale contrast-115 group-hover:scale-105 transition-all duration-700">
                        </div>
                    @endif
                </div>
                <div class="md:col-span-7 md:pl-8 text-left relative">
                    <span
                        class="absolute -top-16 -left-4 text-9xl font-bold font-serif text-white/[0.02] select-none pointer-events-none">THE
                        GROOM</span>
                    <h3 class="serif-premium text-5xl text-white font-light tracking-wide mb-2">
                        {{ $invitation->profile->first_name }}
                    </h3>
                    <span class="display-royal text-[10px] text-[#d4af37] tracking-[0.3em] block mb-6">PUTRA
                        KEKASIH</span>
                    <p class="text-sm text-gray-400 leading-loose max-w-md font-light">
                        Putra tercinta dari pasangan mulia Bapak <span
                            class="text-white font-medium">{{ $invitation->profile->first_father }}</span> dan Ibu
                        <span class="text-white font-medium">{{ $invitation->profile->first_mother }}</span>.
                    </p>
                </div>
            </div>

            <div class="grid md:grid-cols-12 gap-12 items-center md:direction-rtl">
                <div class="md:col-span-7 md:pr-8 text-right order-2 md:order-1 relative">
                    <span
                        class="absolute -top-16 -right-4 text-9xl font-bold font-serif text-white/[0.02] select-none pointer-events-none">THE
                        BRIDE</span>
                    <h3 class="serif-premium text-5xl text-white font-light tracking-wide mb-2">
                        {{ $invitation->profile->second_name }}
                    </h3>
                    <span class="display-royal text-[10px] text-[#d4af37] tracking-[0.3em] block mb-6">PUTRI
                        KEKASIH</span>
                    <p class="text-sm text-gray-400 leading-loose max-w-md ml-auto font-light">
                        Putri tercinta dari pasangan mulia Bapak <span
                            class="text-white font-medium">{{ $invitation->profile->second_father }}</span> dan Ibu
                        <span class="text-white font-medium">{{ $invitation->profile->second_mother }}</span>.
                    </p>
                </div>
                <div class="md:col-span-5 order-1 md:order-2 relative group">
                    <div
                        class="absolute -inset-4 border border-[#d4af37]/30 -translate-x-2 translate-y-2 group-hover:translate-x-0 group-hover:translate-y-0 transition-all duration-500">
                    </div>
                    @if ($invitation->secondPersonPhoto)
                        <div
                            class="relative bg-[#111] p-3 border border-[#d4af37]/20 shadow-2xl overflow-hidden aspect-[3/4]">
                            <img src="{{ asset('storage/' . $invitation->secondPersonPhoto->file_path) }}"
                                class="w-full h-full object-cover filter grayscale contrast-115 group-hover:scale-105 transition-all duration-700">
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>


    <section class="py-36 px-6 bg-[#0a0a0a] relative overflow-hidden">
        <div class="absolute inset-0 bg-deco-overlay opacity-20"></div>

        <div class="max-w-5xl mx-auto relative z-10">
            <div class="text-center mb-24">
                <span class="display-royal text-[11px] tracking-[0.5em] text-[#d4af37] block mb-3">JOURNEY OF
                    CONTRACT</span>
                <h2 class="serif-premium text-4xl md:text-5xl text-white font-light tracking-wide">
                    The Wedding Schedule
                </h2>
                <div class="w-16 h-[1px] bg-[#d4af37] mx-auto mt-6"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-start">
                @foreach ($invitation->events as $index => $event)
                    <div
                        class="glass-gold-card p-8 md:p-12 relative shadow-2xl transition-all duration-500 hover:-translate-y-2 group">
                        <span
                            class="absolute top-6 right-8 text-5xl font-bold font-serif text-white/[0.02] group-hover:text-[#d4af37]/5 transition-all duration-500">0{{ $index + 1 }}</span>

                        <h3
                            class="display-royal text-lg text-white font-medium tracking-widest border-b border-[#d4af37]/20 pb-4 mb-6">
                            {{ $event->name }}
                        </h3>

                        <div class="space-y-6 text-left">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-[#d4af37]/10 flex items-center justify-center text-[#d4af37] text-xs shrink-0 mt-0.5">
                                    <i class="fa-regular fa-calendar-check"></i></div>
                                <div>
                                    <span class="text-[10px] uppercase text-gray-500 block tracking-wider">Day &
                                        Date</span>
                                    <span
                                        class="serif-premium text-base text-gray-200">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-[#d4af37]/10 flex items-center justify-center text-[#d4af37] text-xs shrink-0 mt-0.5">
                                    <i class="fa-regular fa-clock"></i></div>
                                <div>
                                    <span class="text-[10px] uppercase text-gray-500 block tracking-wider">Time
                                        Window</span>
                                    <span class="serif-premium text-base text-gray-200">{{ $event->start_time }} -
                                        Selesai</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-8 h-8 rounded-full bg-[#d4af37]/10 flex items-center justify-center text-[#d4af37] text-xs shrink-0 mt-0.5">
                                    <i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <span class="text-[10px] uppercase text-gray-500 block tracking-wider">The Pavilion
                                        Venue</span>
                                    <span
                                        class="serif-premium text-base text-white block font-medium">{{ $event->venue_name }}</span>
                                    <span
                                        class="text-xs text-gray-400 font-light mt-1 block leading-relaxed">{{ $event->address }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="bg-[#0d0d0d] py-36 px-6 relative overflow-hidden border-t border-b border-[#d4af37]/10">
        <div class="max-w-6xl mx-auto relative z-10">
            <div class="text-center mb-20">
                <span class="display-royal text-[11px] tracking-[0.5em] text-[#d4af37] block mb-3">VISUAL
                    EPISODE</span>
                <h2 class="serif-premium text-4xl md:text-5xl text-white font-light">
                    The Gallery Memoir
                </h2>
                <div class="w-16 h-[1px] bg-[#d4af37] mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-[250px]">
                @foreach ($invitation->galleries as $index => $gallery)
                    @php
                        // Mengatur variasi ukuran kotak mosaic berdasarkan urutan index loop
                        $gridClass = 'md:col-span-4';
                        if ($index % 3 == 0) {
                            $gridClass = 'md:col-span-8 md:row-span-2';
                        }
                        if ($index % 4 == 0) {
                            $gridClass = 'md:col-span-4 md:row-span-2';
                        }
                    @endphp
                    <div
                        class="{{ $gridClass }} overflow-hidden bg-[#111] p-2 border border-[#d4af37]/20 shadow-2xl group relative">
                        <div class="absolute inset-0 border border-[#d4af37]/10 z-10 pointer-events-none m-2"></div>
                        <img src="{{ asset('storage/' . $gallery->file_path) }}"
                            class="w-full h-full object-cover transition-all duration-1000 filter grayscale brightness-75 group-hover:grayscale-0 group-hover:brightness-100 group-hover:scale-105">
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="py-40 px-6 bg-[#0a0a0a] relative text-center">
        <div class="absolute inset-0 bg-deco-overlay opacity-20"></div>

        <div class="max-w-3xl mx-auto z-10 relative">
            <h2 class="serif-premium text-5xl md:text-6xl mb-8 gold-gradient-text font-light tracking-wide">
                Gratitude
            </h2>

            <p
                class="text-gray-400 font-light text-sm md:text-base leading-loose max-w-xl mx-auto mb-16 italic serif-premium">
                Merupakan suatu kehormatan dan kebahagiaan mendalam bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir
                dan memberikan restu suci pada penyatuan cinta kami.
            </p>

            <span class="display-royal text-[10px] tracking-[0.5em] text-[#d4af37] block mb-4">WASSALAM, KAMI YANG
                BERBAHAGIA</span>
            <div class="mt-4">
                <h3 class="serif-premium text-4xl md:text-6xl font-light text-white tracking-widest">
                    {{ $invitation->profile->first_name }} <span
                        class="gold-gradient-text font-serif text-3xl md:text-4xl">&</span>
                    {{ $invitation->profile->second_name }}
                </h3>
            </div>
        </div>
    </section>


    <script>
        const audio = document.getElementById('weddingMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        function openInvitation() {
            const envelope = document.getElementById('envelopeOverlay');
            envelope.classList.add('envelope-hidden');

            document.body.classList.remove('envelope-active');
            musicBtn.classList.remove('hidden');

            audio.play().catch(error => {
                console.log("Audio autoplay diamankan kebijakan privasi browser.");
            });

            setTimeout(() => {
                envelope.classList.add('hidden');
            }, 1000);
        }

        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                musicIcon.className = "fa-solid fa-compass-drafting fa-spin text-xl";
            } else {
                audio.pause();
                musicIcon.className = "fa-solid fa-pause text-xl text-red-400";
            }
        }
    </script>

</body>

</html>
