<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&family=Playfair+Display:ital,wght@1,400;1,600&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #09090b;
            letter-spacing: 0.02em;
        }

        .font-header {
            font-family: 'Syne', sans-serif;
        }

        .font-accent {
            font-family: 'Playfair Display', serif;
        }

        /* Neon & Gold Glow Effect */
        .neon-gold-text {
            background: linear-gradient(135deg, #f59e0b 0%, #fef08a 50%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .neon-gold-border {
            border: 1px solid rgba(245, 158, 11, 0.3);
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.08);
        }

        /* Confetti / Half-tone Grid Overlay */
        .bg-party-overlay {
            background-image: radial-gradient(rgba(245, 158, 11, 0.1) 1.5px, transparent 1.5px);
            background-size: 32px 32px;
        }

        .envelope-hidden {
            transform: scale(0.9) translateY(-100vh);
            opacity: 0;
            pointer-events: none;
        }

        body.envelope-active {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-[#09090b] text-[#f4f4f5] antialiased envelope-active">

    <audio id="birthdayMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3" type="audio/mpeg">
    </audio>

    <button id="musicToggle" onclick="toggleMusic()"
        class="fixed bottom-8 right-8 z-50 w-14 h-14 bg-[#18181b]/90 text-[#f59e0b] rounded-full border border-[#f59e0b]/40 shadow-[0_0_20px_rgba(245,158,11,0.2)] flex items-center justify-center hidden hover:scale-110 transition-all duration-300">
        <i id="musicIcon" class="fa-solid fa-music fa-spin text-lg"></i>
    </button>

    <div id="envelopeOverlay"
        class="fixed inset-0 z-50 flex items-center justify-center bg-[#09090b] transition-all duration-1000 cubic-bezier(0.77, 0, 0.175, 1) overflow-hidden">

        <div class="absolute inset-0 bg-party-overlay opacity-50"></div>

        <div class="absolute top-6 left-6 right-6 bottom-6 border border-[#f59e0b]/10 pointer-events-none"></div>
        <div class="absolute top-10 left-10 right-10 bottom-10 border border-[#f59e0b]/20 pointer-events-none"></div>

        <div class="max-w-xl text-center px-6 z-10">
            <span
                class="font-header text-xs tracking-[0.4em] text-[#f59e0b] bg-[#f59e0b]/10 px-4 py-1.5 rounded-full mb-8 inline-block">WALIMATUL
                AQIQAH</span>

            <h2
                class="font-header text-4xl md:text-5xl font-extrabold text-white uppercase tracking-tight leading-none mb-4">
                Tasyakuran Aqiqah
                <span
                    class="block neon-gold-text font-accent lowercase italic font-normal tracking-normal py-2">{{ $invitation->profile->first_name ?? 'Putra/Putri Kami' }}</span>
            </h2>

            <div class="w-16 h-[2px] bg-gradient-to-r from-transparent via-[#f59e0b] to-transparent mx-auto my-8"></div>

            <p class="text-[11px] uppercase tracking-[0.2em] text-zinc-500 mb-3">Kepada Yth. Bapak/Ibu/Saudara/i:</p>

            <div
                class="bg-[#18181b] border-2 border-dashed border-[#f59e0b]/30 py-5 px-8 mb-10 max-w-sm mx-auto rounded-xl shadow-2xl relative overflow-hidden">
                <div
                    class="absolute -left-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-[#09090b] rounded-full border-r border-[#f59e0b]/30">
                </div>
                <div
                    class="absolute -right-3 top-1/2 -translate-y-1/2 w-6 h-6 bg-[#09090b] rounded-full border-l border-[#f59e0b]/30">
                </div>
                <span class="text-[10px] text-zinc-500 font-bold tracking-widest block uppercase mb-1">Tamu
                    Undangan</span>
                <p class="font-header text-xl font-bold text-white tracking-wide uppercase">
                    {{ request()->get('to') ?? 'Keluarga & Sahabat Tercinta' }}
                </p>
            </div>

            <button onclick="openInvitation()"
                class="group relative inline-flex items-center justify-center px-10 py-4 overflow-hidden rounded-full bg-gradient-to-r from-[#f59e0b] to-[#d97706] text-black font-header text-xs font-bold tracking-widest uppercase transition-all duration-300 hover:shadow-[0_0_30px_rgba(245,158,11,0.4)] hover:scale-105">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open text-xs"></i> Buka Undangan
                </span>
            </button>
        </div>
    </div>

    <section class="relative min-h-screen grid md:grid-cols-12 items-stretch overflow-hidden">
        <div
            class="md:col-span-6 bg-[#141416] flex flex-col justify-between p-8 md:p-20 relative z-10 border-b md:border-b-0 md:border-r border-zinc-800">
            <div class="absolute inset-0 bg-party-overlay opacity-30"></div>

            <div class="flex justify-between items-center">
                <span class="font-header text-xs text-[#f59e0b] tracking-widest font-bold">AQIQAH CELEBRATION</span>
                <span class="text-xs text-zinc-500 font-medium">EST.
                    {{ optional($invitation->event_date)->format('Y') }}</span>
            </div>

            <div class="my-auto py-16 md:py-0 relative">
                <h1
                    class="font-header text-8xl font-black text-white/[0.02] tracking-tighter absolute -left-10 top-0 select-none">
                    AQIQAH</h1>
                <p class="font-accent text-3xl italic text-[#f59e0b] mb-4">Masyasykur atas kelahiran...</p>
                <h2
                    class="font-header text-4xl md:text-6xl font-extrabold text-white uppercase tracking-tight leading-none mb-2">
                    {{ $invitation->profile->first_name }}
                </h2>
                <h2
                    class="font-header text-2xl md:text-3xl font-extrabold text-zinc-500 uppercase tracking-tight leading-none mb-6">
                    {{ $invitation->profile->second_name ?? 'Anak Tercinta' }}
                </h2>
                <p class="text-sm text-zinc-400 font-light max-w-sm leading-relaxed">
                    Tiada kata yang lebih indah selain ungkapan rasa syukur atas kehadiran buah hati tercinta yang
                    menjadi amanah dan pelengkap kebahagiaan keluarga kami.
                </p>
            </div>

            <div class="border-t border-zinc-800 pt-8 grid grid-cols-2 gap-4">
                <div>
                    <span
                        class="text-[10px] block uppercase text-zinc-500 tracking-wider font-semibold mb-1">Pelaksanaan</span>
                    <span
                        class="font-header text-lg text-white font-bold tracking-wider">{{ optional($invitation->event_date)->format('d . M . Y') }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] block uppercase text-zinc-500 tracking-wider font-semibold mb-1">Dress
                        Code</span>
                    <span class="text-sm text-[#f59e0b] font-bold uppercase tracking-wider">Busana Muslim / Bebas
                        Rapi</span>
                </div>
            </div>
        </div>

        <div class="md:col-span-6 relative min-h-[40vh] md:min-h-screen flex items-end p-8 md:p-16">
            <div class="absolute inset-0 bg-cover bg-center filter contrast-[105%] brightness-[45%]"
                style="background-image: url('{{ $invitation->cover?->file_path ? asset('storage/' . $invitation->cover->file_path) : 'https://images.unsplash.com/photo-1555252333-9f8e92e65df9?q=80&w=2000' }}');">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#09090b] via-transparent to-transparent"></div>

            <div class="relative z-10 max-w-sm neon-gold-border bg-[#09090b]/80 backdrop-blur-md p-6 rounded-2xl">
                <i class="fa-solid fa-quote-left text-2xl text-[#f59e0b]/30 mb-2 block"></i>
                <p class="font-accent text-sm text-zinc-200 leading-relaxed italic">
                    "{{ $invitation->profile->quote ?? 'Setiap anak tergadai dengan aqiqahnya, maka disembelihkan hewan untuknya pada hari ketujuh, dicukur rambutnya, dan diberikan nama.' }}"
                </p>
            </div>
        </div>
    </section>

    <section class="bg-[#09090b] py-36 px-6 relative overflow-hidden text-center">
        <div class="max-w-xl mx-auto relative">
            <div class="mb-8 relative inline-block group">
                <div
                    class="absolute -inset-3 border-2 border-dashed border-[#f59e0b]/30 rounded-full group-hover:rotate-45 transition-all duration-1000">
                </div>
                @if ($invitation->firstPersonPhoto)
                    <div
                        class="w-48 h-48 mx-auto rounded-full p-2 bg-[#141416] border border-zinc-800 shadow-2xl overflow-hidden">
                        <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}"
                            class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-all duration-500">
                    </div>
                @else
                    <div
                        class="w-48 h-48 mx-auto rounded-full p-2 bg-[#141416] border border-zinc-800 shadow-2xl flex items-center justify-center text-5xl text-[#f59e0b]">
                        <i class="fa-solid fa-baby"></i>
                    </div>
                @endif
            </div>

            <span class="font-header text-[10px] text-[#f59e0b] tracking-[0.4em] block uppercase mb-2">Putra / Putri
                Tercinta</span>
            <h3 class="font-header text-3xl text-white font-extrabold uppercase tracking-tight">
                {{ $invitation->profile->first_name }} {{ $invitation->profile->second_name ?? '' }}
            </h3>

            <div class="w-12 h-[2px] bg-[#f59e0b] mx-auto my-6"></div>

            <p class="text-sm text-zinc-400 leading-relaxed font-light">
                Ungkapan rasa syukur yang tak terhingga kepada Allah SWT atas kelahiran buah hati kami tercinta. Bersama
                kedua orang tua: Bapak <span
                    class="text-white font-semibold">{{ $invitation->profile->first_father ?? 'Ayah' }}</span> & Ibu
                <span class="text-white font-semibold">{{ $invitation->profile->first_mother ?? 'Ibu' }}</span>, kami
                sangat mengharapkan kehadiran serta doa restu Bapak/Ibu sekalian untuk mengiringi tumbuh kembang buah
                hati kami.
            </p>
        </div>
    </section>

    <section class="py-36 px-6 bg-[#141416] relative overflow-hidden border-t border-b border-zinc-800">
        <div class="absolute inset-0 bg-party-overlay opacity-20"></div>

        <div class="max-w-5xl mx-auto relative z-10">
            <div class="text-center mb-24">
                <span class="font-header text-[11px] tracking-[0.4em] text-[#f59e0b] block uppercase mb-2">WAKTU &
                    TEMPAT</span>
                <h2 class="font-header text-4xl md:text-5xl text-white font-extrabold uppercase tracking-tight">
                    AGENDA TASYAKURAN
                </h2>
                <div class="w-16 h-[2px] bg-[#f59e0b] mx-auto mt-4"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-stretch">
                @foreach ($invitation->events as $index => $event)
                    <div
                        class="neon-gold-border bg-[#09090b]/90 p-8 md:p-12 rounded-2xl relative shadow-2xl transition-all duration-500 hover:-translate-y-2 group flex flex-col justify-between">
                        <span
                            class="absolute top-6 right-8 font-header text-4xl font-black text-zinc-800/40 group-hover:text-[#f59e0b]/10 transition-all duration-500 select-none">0{{ $index + 1 }}</span>

                        <div>
                            <h3
                                class="font-header text-xl text-white font-bold tracking-wide border-b border-zinc-800 pb-4 mb-6 uppercase flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-[#f59e0b]"></span> {{ $event->name }}
                            </h3>

                            <div class="space-y-6 text-left">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-zinc-800 flex items-center justify-center text-[#f59e0b] text-sm shrink-0">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </div>
                                    <div>
                                        <span
                                            class="text-[10px] uppercase text-zinc-500 block tracking-wider font-semibold">Hari
                                            & Tanggal</span>
                                        <span
                                            class="text-sm text-zinc-200 font-medium">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-zinc-800 flex items-center justify-center text-[#f59e0b] text-sm shrink-0">
                                        <i class="fa-regular fa-clock"></i>
                                    </div>
                                    <div>
                                        <span
                                            class="text-[10px] uppercase text-zinc-500 block tracking-wider font-semibold">Waktu
                                            Acara</span>
                                        <span class="text-sm text-zinc-200 font-medium">{{ $event->start_time }} -
                                            Selesai</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-zinc-800 flex items-center justify-center text-[#f59e0b] text-sm shrink-0 mt-0.5">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </div>
                                    <div>
                                        <span
                                            class="text-[10px] uppercase text-zinc-500 block tracking-wider font-semibold">Lokasi
                                            Kediaman / Venue</span>
                                        <span
                                            class="text-sm text-white block font-bold tracking-wide uppercase">{{ $event->venue_name }}</span>
                                        <span
                                            class="text-xs text-zinc-400 font-light mt-1 block leading-relaxed">{{ $event->address }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-zinc-900 text-left">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->address) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 text-xs text-[#f59e0b] font-semibold tracking-wider uppercase hover:underline">
                                <i class="fa-solid fa-diamond-turn-right text-[10px]"></i> Buka Google Maps
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#09090b] py-36 px-6 relative overflow-hidden">
        <div class="max-w-6xl mx-auto relative z-10">
            <div class="text-center mb-20">
                <span class="font-header text-[11px] tracking-[0.4em] text-[#f59e0b] block uppercase mb-2">GALERI
                    ALBUM</span>
                <h2 class="font-header text-4xl md:text-5xl text-white font-extrabold uppercase tracking-tight">
                    MOMENT BAHAGIA
                </h2>
                <div class="w-16 h-[2px] bg-[#f59e0b] mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 auto-rows-[240px]">
                @foreach ($invitation->galleries as $index => $gallery)
                    @php
                        $gridClass = 'md:col-span-4';
                        if ($index % 3 == 0) {
                            $gridClass = 'md:col-span-8 md:row-span-2';
                        }
                        if ($index % 4 == 0) {
                            $gridClass = 'md:col-span-4 md:row-span-2';
                        }
                    @endphp
                    <div
                        class="{{ $gridClass }} overflow-hidden rounded-2xl bg-[#141416] p-2 border border-zinc-800 shadow-2xl group relative">
                        <div class="absolute inset-0 border border-white/5 rounded-xl z-10 pointer-events-none m-2">
                        </div>
                        <img src="{{ asset('storage/' . $gallery->file_path) }}"
                            class="w-full h-full object-cover rounded-xl transition-all duration-1000 filter brightness-90 group-hover:scale-105 group-hover:brightness-100">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-40 px-6 bg-[#141416] relative text-center border-t border-zinc-800">
        <div class="absolute inset-0 bg-party-overlay opacity-20"></div>

        <div class="max-w-3xl mx-auto z-10 relative">
            <h2 class="font-header text-5xl md:text-7xl font-black neon-gold-text tracking-tighter uppercase mb-6">
                TERIMA KASIH
            </h2>

            <p class="text-zinc-400 font-light text-sm md:text-base leading-loose max-w-xl mx-auto mb-12">
                Kehadiran dan untaian doa tulus dari Bapak/Ibu/Saudara/i sekalian adalah hadiah paling mulia yang
                mengiringi awal perjalanan hidup buah hati kami. Semoga keberkahan senantiasa menyelimuti kita semua.
            </p>

            <span class="font-header text-[10px] tracking-[0.3em] text-[#f59e0b] block uppercase mb-3">Kami Yang
                Berbahagia,</span>
            <div class="mt-2">
                <h3 class="font-header text-2xl md:text-4xl font-extrabold text-white uppercase tracking-tight">
                    Keluarga {{ $invitation->profile->first_father ?? 'Kedua Orang Tua' }}
                </h3>
            </div>
        </div>
    </section>

    <script>
        const audio = document.getElementById('birthdayMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        function openInvitation() {
            const envelope = document.getElementById('envelopeOverlay');
            envelope.classList.add('envelope-hidden');

            document.body.classList.remove('envelope-active');
            musicBtn.classList.remove('hidden');

            audio.play().catch(error => {
                console.log("Audio autoplay didukung penuh setelah interaksi tombol klik.");
            });

            setTimeout(() => {
                envelope.classList.add('hidden');
            }, 1000);
        }

        function toggleMusic() {
            if (audio.paused) {
                audio.play();
                musicIcon.className = "fa-solid fa-music fa-spin text-lg";
            } else {
                audio.pause();
                musicIcon.className = "fa-solid fa-pause text-lg text-red-500";
            }
        }
    </script>

</body>

</html>
