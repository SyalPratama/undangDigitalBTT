<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;1,500&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';
        
        $defaultOrder = [['id' => 'cover', 'visible' => true], ['id' => 'quote', 'visible' => true], ['id' => 'profile', 'visible' => true], ['id' => 'event', 'visible' => true], ['id' => 'gallery', 'visible' => true], ['id' => 'closing', 'visible' => true]];
        $sectionOrder = $projectData['section_order'] ?? $defaultOrder;
    @endphp

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; color: #111; }
        .heading-font { font-family: 'Playfair Display', serif; }
        body.envelope-active { overflow: hidden; }
        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
    </style>
    <script> if (window.self !== window.top) document.documentElement.classList.add('is-editor'); </script>
</head>
<body class="antialiased envelope-active selection:bg-black selection:text-white">
    <script> if (window.self !== window.top) { document.body.classList.add('is-editor'); document.body.classList.remove('envelope-active'); } </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-black text-white transition-all duration-1000">
        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.5em] uppercase text-xs text-gray-400 mb-6" data-preview="headline">{{ $invitation->profile->headline ?? 'Engagement Invitation' }}</p>
            <h2 class="heading-font text-5xl md:text-6xl mb-8">
                <span data-preview="first_name">{{ $invitation->profile->first_name }}</span> & <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
            </h2>
            <div class="border border-white/20 py-4 px-10 mb-10">
                <p class="text-xs text-gray-400 uppercase mb-2">To:</p>
                <p class="font-semibold tracking-wide text-lg">{{ request()->get('to') ?? 'Special Guest' }}</p>
            </div>
            <button onclick="openInvitation()" class="px-10 py-4 bg-white text-black hover:bg-gray-200 text-xs uppercase tracking-widest font-bold transition-all">
                Open Invitation
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-white">
        <div class="z-10 py-12">
            <h1 class="heading-font text-6xl md:text-8xl leading-tight" data-preview="first_name">{{ $invitation->profile->first_name }}</h1>
            <h1 class="heading-font text-6xl md:text-8xl leading-tight mb-8" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
            <p class="text-xs uppercase tracking-[0.4em] font-semibold text-gray-500" data-preview="event_date">
                {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('F d, Y') : 'Segera' }}
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="py-20 px-6 bg-gray-50 text-center">
        <div class="max-w-xl mx-auto italic text-gray-600" data-preview="quote">
            "{{ $invitation->profile->quote ?? 'Ketik kata-kata mutiara di sini...' }}"
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-white text-center">
        <h2 class="heading-font text-4xl mb-12">The Couple</h2>
        <div class="flex flex-wrap justify-center gap-12">
            <div class="w-48">
                @if ($invitation->firstPersonPhoto) <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-48 h-48 rounded-full mb-4 object-cover mx-auto"> @endif
                <h3 class="heading-font text-2xl" data-preview="first_name">{{ $invitation->profile->first_name }}</h3>
            </div>
            <div class="w-48">
                @if ($invitation->secondPersonPhoto) <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-48 h-48 rounded-full mb-4 object-cover mx-auto"> @endif
                <h3 class="heading-font text-2xl" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-24 px-6 bg-black text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10">
            @forelse ($invitation->events as $index => $event)
                <div class="p-10 border border-white/20 text-center">
                    <h3 class="heading-font text-3xl mb-6" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-semibold tracking-widest uppercase text-sm mb-2" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-400 mb-6" data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - Selesai</p>
                    <div class="w-10 h-[1px] bg-white/50 mx-auto mb-6"></div>
                    <p class="text-sm font-semibold mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-400 leading-relaxed" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-500">Belum ada event.</p>
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="bg-white py-24 px-6 text-center">
        <h2 class="heading-font text-5xl mb-12">Gallery</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-2">
            @foreach ($invitation->galleries as $gallery)
                <div class="overflow-hidden"><img src="{{ asset($gallery->file_path) }}" class="w-full h-80 object-cover grayscale hover:grayscale-0 transition duration-700"></div>
            @endforeach
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="bg-gray-50 py-24 px-6 text-center">
        <p class="text-gray-600 italic" data-preview="closing_text">{{ $invitation->profile->closing_text ?? 'Terima kasih atas doa restunya.' }}</p>
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