<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3';
        
        $defaultOrder = [['id' => 'cover', 'visible' => true], ['id' => 'quote', 'visible' => true], ['id' => 'profile', 'visible' => true], ['id' => 'event', 'visible' => true], ['id' => 'gallery', 'visible' => true], ['id' => 'closing', 'visible' => true]];
        $sectionOrder = $projectData['section_order'] ?? $defaultOrder;
    @endphp

    <style>
        body { font-family: 'Lora', serif; background-color: #FDFBF7; color: #4A0E17; }
        .heading-font { font-family: 'Cinzel', serif; }
        .maroon-bg { background-color: #4A0E17; }
        .maroon-text { color: #4A0E17; }
        .gold-text { color: #C5A059; }
        .gold-border { border-color: #C5A059; }
        body.envelope-active { overflow: hidden; }
        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
    </style>
    <script> if (window.self !== window.top) document.documentElement.classList.add('is-editor'); </script>
</head>
<body class="antialiased envelope-active">
    <script> if (window.self !== window.top) { document.body.classList.add('is-editor'); document.body.classList.remove('envelope-active'); } </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center maroon-bg transition-all duration-1000">
        <div class="absolute inset-6 border-4 double gold-border opacity-60 pointer-events-none"></div>
        <div class="max-w-xl text-center px-6 z-10">
            <i class="fa-solid fa-award text-6xl gold-text mb-6"></i>
            <h2 class="heading-font text-3xl md:text-4xl text-white mb-2 tracking-widest">Tasyakuran Wisuda</h2>
            <h1 class="heading-font text-5xl gold-text mb-8" data-preview="first_name">{{ $invitation->profile->first_name }}</h1>
            
            <div class="bg-[#3A0A11] border gold-border py-4 px-12 mb-10 shadow-xl">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-2 font-sans">Disampaikan Kepada:</p>
                <p class="gold-text font-bold text-xl">{{ request()->get('to') ?? 'Tamu Kehormatan' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="px-12 py-3 bg-[#C5A059] hover:bg-[#A38242] text-[#4A0E17] text-xs uppercase tracking-[0.2em] font-bold transition-all font-sans">
                Buka Undangan
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-[#FDFBF7]">
        <div class="absolute inset-4 border border-[#4A0E17] opacity-20 pointer-events-none"></div>
        <div class="z-10 py-12 max-w-4xl border border-[#C5A059] p-10 md:p-20 bg-white shadow-sm">
            <p class="text-xs uppercase tracking-[0.4em] maroon-text mb-8 font-sans font-bold" data-preview="headline">{{ $invitation->profile->headline ?? 'Pelepasan Wisudawan' }}</p>
            <h1 class="heading-font text-6xl md:text-8xl maroon-text leading-none mb-6" data-preview="first_name">
                {{ $invitation->profile->first_name }}
            </h1>
            <p class="text-gray-600 italic mb-10 leading-relaxed max-w-lg mx-auto" data-preview="quote">
                "{{ $invitation->profile->quote ?? 'Sebuah perjalanan panjang yang diakhiri dengan rasa syukur tak terhingga.' }}"
            </p>
            <div class="w-24 h-[1px] bg-[#C5A059] mx-auto mb-6"></div>
            <p class="heading-font text-xl maroon-text font-bold" data-preview="event_date">
                {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y') : 'Segera' }}
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-24 px-6 maroon-bg text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12">
            @foreach ($invitation->events as $index => $event)
                <div class="p-10 border gold-border text-center bg-[#3A0A11] relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-[#3A0A11] px-4">
                        <i class="fa-solid fa-scroll gold-text text-2xl"></i>
                    </div>
                    <h3 class="heading-font text-3xl gold-text mb-6 mt-4" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-bold text-white mb-2 font-sans tracking-widest uppercase text-sm" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-400 mb-8 font-sans">
                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span> - Selesai
                    </p>
                    <p class="text-lg font-bold text-white mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-sm text-gray-400 leading-relaxed" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="bg-[#FDFBF7] py-24 px-6 text-center">
        <h2 class="heading-font text-4xl maroon-text mb-12">Galeri Kelulusan</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($invitation->galleries as $gallery)
                <div class="border-4 border-white shadow-md"><img src="{{ asset($gallery->file_path) }}" class="w-full h-64 object-cover filter sepia-[30%] hover:sepia-0 transition duration-700"></div>
            @endforeach
        </div>
    </section>
    @endif
    @endif
    @endforeach

    <script>
        function openInvitation() {
            const el = document.getElementById('envelopeOverlay');
            if(el) {
                el.style.opacity = '0';
                setTimeout(() => el.classList.add('hidden'), 1000);
            }
            document.body.classList.remove('envelope-active');
            document.getElementById('weddingMusic').play();
        }
    </script>
</body>
</html>