<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3';
        
        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#A67C52';
        $hasSecondPerson = !empty($invitation->profile->second_name);

        $defaultOrder = [['id' => 'cover', 'visible' => true], ['id' => 'quote', 'visible' => true], ['id' => 'profile', 'visible' => true], ['id' => 'event', 'visible' => true], ['id' => 'gallery', 'visible' => true], ['id' => 'closing', 'visible' => true]];
        $sectionOrder = $projectData['section_order'] ?? $defaultOrder;
    @endphp

    <style>
        :root { --primary-color: {{ $primaryColor }}; }
        body { font-family: 'Lato', sans-serif; background-color: #FDFBF7; color: #5C4B3C; }
        .heading-font { font-family: 'Cormorant Garamond', serif; }
        .rustic-bg { background-color: var(--primary-color); }
        .rustic-text { color: var(--primary-color); }
        .border-rustic { border-color: var(--primary-color); }
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
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#FDFBF7] transition-all duration-1000">
        <div class="absolute inset-4 border border-rustic opacity-50 rounded-lg pointer-events-none"></div>
        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.4em] uppercase text-xs rustic-text mb-4 font-bold" data-preview="headline">{{ $invitation->profile->headline ?? 'We Are Engaged' }}</p>
            <h2 class="heading-font text-5xl md:text-7xl text-[#5C4B3C] mb-8">
                <span data-preview="first_name">{{ $invitation->profile->first_name }}</span> 
                @if($hasSecondPerson)
                    <span class="text-4xl italic rustic-text mx-2">&</span> <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
                @endif
            </h2>
            <div class="bg-white border border-rustic py-4 px-10 shadow-sm mb-10">
                <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-2">Dear:</p>
                <p class="text-[#5C4B3C] font-bold text-lg">{{ request()->get('to') ?? 'Tamu Spesial' }}</p>
            </div>
            <button onclick="openInvitation()" class="px-10 py-3 rustic-bg hover:bg-[#8A633F] text-white text-xs uppercase tracking-widest rounded transition-all shadow-md">
                Buka Undangan
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])

    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-[#F5EFE6]">
        <div class="z-10 py-12 max-w-4xl">
            <h1 class="heading-font text-6xl md:text-8xl text-[#5C4B3C] leading-none mb-2" data-preview="first_name">{{ $invitation->profile->first_name }}</h1>
            @if($hasSecondPerson)
                <h2 class="heading-font text-4xl rustic-text mb-2 italic">and</h2>
                <h1 class="heading-font text-6xl md:text-8xl text-[#5C4B3C] leading-none mb-10" data-preview="second_name">{{ $invitation->profile->second_name }}</h1>
            @endif
            <div class="w-16 h-[1px] rustic-bg mx-auto mb-6"></div>
            <p class="text-sm uppercase tracking-widest font-bold rustic-text" data-preview="event_date">
                {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y') : 'Segera' }}
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 bg-[#FDFBF7]">
        <div class="max-w-2xl mx-auto text-center">
            <p class="text-[#5C4B3C] italic font-serif text-xl" data-preview="quote">
                "{{ $invitation->profile->quote ?? 'Ketik kata-kata mutiara di sini...' }}"
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-white border-t border-b border-rustic">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12">
            <div class="text-center">
                @if ($invitation->firstPersonPhoto)
                    <img src="{{ asset($invitation->firstPersonPhoto->file_path) }}" class="w-48 h-48 mx-auto rounded-full border-2 border-rustic mb-6 object-cover">
                @endif
                <h3 class="heading-font text-4xl rustic-text mb-4" data-preview="first_name">{{ $invitation->profile->first_name }}</h3>
                @if($showParents)
                    <p class="text-sm text-gray-500">Putra/Putri dari <br> 
                        <span data-preview="first_father">{{ $invitation->profile->first_father }}</span> & <span data-preview="first_mother">{{ $invitation->profile->first_mother }}</span>
                    </p>
                @endif
            </div>
            @if($hasSecondPerson)
            <div class="text-center">
                @if ($invitation->secondPersonPhoto)
                    <img src="{{ asset($invitation->secondPersonPhoto->file_path) }}" class="w-48 h-48 mx-auto rounded-full border-2 border-rustic mb-6 object-cover">
                @endif
                <h3 class="heading-font text-4xl rustic-text mb-4" data-preview="second_name">{{ $invitation->profile->second_name }}</h3>
                @if($showParents)
                    <p class="text-sm text-gray-500">Putra/Putri dari <br> 
                        <span data-preview="second_father">{{ $invitation->profile->second_father }}</span> & <span data-preview="second_mother">{{ $invitation->profile->second_mother }}</span>
                    </p>
                @endif
            </div>
            @endif
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-24 px-6 bg-[#FDFBF7]">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12">
            @forelse ($invitation->events as $index => $event)
                <div class="p-10 border border-[#F5EFE6] text-center hover:border-[#D4B895] transition-all bg-white">
                    <h3 class="heading-font text-4xl rustic-text mb-4" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-bold text-[#5C4B3C] mb-1" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-500 mb-6" data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - Selesai</p>
                    <p class="text-sm font-bold text-[#5C4B3C] mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-500 italic" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-400">Belum ada event.</p>
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="bg-[#F5EFE6] py-24 px-6 text-center">
        <h2 class="heading-font text-5xl text-[#5C4B3C] mb-12">Our Moments</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($invitation->galleries as $gallery)
                <div class="overflow-hidden"><img src="{{ asset($gallery->file_path) }}" class="w-full h-72 object-cover filter sepia-[20%] hover:sepia-0 transition duration-700"></div>
            @endforeach
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="py-24 px-6 text-center">
        <h2 class="heading-font text-4xl rustic-text mb-4">Terima Kasih</h2>
        <p class="text-gray-500 italic" data-preview="closing_text">{{ $invitation->profile->closing_text ?? 'Merupakan suatu kebahagiaan...' }}</p>
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