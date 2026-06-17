<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3';

        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#D53F8C';

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = ($coverMedia && file_exists(public_path($coverMedia->file_path)))
            ? asset($coverMedia->file_path)
            : 'https://images.unsplash.com/photo-1508169351866-777fc0047ac5?q=80&w=2000';

        $defaultOrder = [
            ['id' => 'cover', 'visible' => true],
            ['id' => 'profile', 'visible' => true],
            ['id' => 'event', 'visible' => true],
            ['id' => 'gallery', 'visible' => true],
            ['id' => 'closing', 'visible' => true]
        ];
        $sectionOrder = $projectData['section_order'] ?? $defaultOrder;

        $firstPhoto = $invitation->firstPersonPhoto;
        $firstPhotoPath = ($firstPhoto && file_exists(public_path($firstPhoto->file_path)))
            ? asset($firstPhoto->file_path)
            : 'https://images.unsplash.com/photo-1530103862676-de8892bf30b5?q=80&w=800';

        $firstName = !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama';
    @endphp

    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #FFF5F7; color: #4A5568; }
        .heading-font { font-family: 'Dancing Script', cursive; }
        .accent-color { color: {{ $primaryColor }}; }
        .accent-bg { background-color: {{ $primaryColor }}; }
        .accent-border { border-color: {{ $primaryColor }}; }
        .soft-bg {
            background: linear-gradient(rgba(255, 245, 247, 0.8), rgba(255, 245, 247, 0.95)), url('{{ $coverImage }}');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        .polaroid { background: white; padding: 10px 10px 30px 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        body.envelope-active { overflow: hidden; }
        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
    </style>
    <script> if (window.self !== window.top) document.documentElement.classList.add('is-editor'); </script>
</head>
<body class="antialiased envelope-active selection:bg-pink-200">
    <script> if (window.self !== window.top) { document.body.classList.add('is-editor'); document.body.classList.remove('envelope-active'); } </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#FFF5F7] transition-all duration-1000">
        <div class="absolute top-10 left-10 w-48 h-48 bg-pink-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 bg-purple-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

        <div class="max-w-xl text-center px-6 z-10">
            <h2 class="heading-font text-6xl md:text-7xl accent-color mb-6" data-preview="first_name">{{ $firstName }}'s</h2>
            <p class="tracking-[0.3em] uppercase text-sm text-gray-500 mb-8 font-bold">Birthday Celebration</p>
            <div class="bg-white/60 backdrop-blur-md border border-pink-200 py-4 px-10 rounded-3xl mb-10 shadow-sm">
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Hello,</p>
                <p class="text-gray-800 font-bold text-lg">{{ request()->get('to') ?? 'Beautiful Soul' }}</p>
            </div>
            <button onclick="openInvitation()" class="px-10 py-3 accent-bg hover:opacity-90 text-white text-xs uppercase tracking-widest font-bold rounded-full transition-all shadow-md transform hover:scale-105">
                Open Invitation
            </button>
        </div>
    </div>
    @endif

    @foreach ($sectionOrder as $section)
    @if ($section['visible'])
    @if (in_array(($section['id'] ?? $section['type'] ?? ''), ['univ_countdown', 'univ_maps', 'univ_rsvp', 'univ_comments']))
        @include('themes.partials.universal-sections', ['renderOnly' => ($section['id'] ?? $section['type'] ?? '')])
    @endif


    @if ($section['id'] == 'cover')
    <section class="soft-bg min-h-screen flex flex-col items-center justify-center text-center px-6 relative">
        <div class="z-10 py-12 max-w-3xl">
            <div class="w-48 h-48 mx-auto overflow-hidden rounded-full border-4 border-white shadow-xl mb-8">
                <img src="{{ $firstPhotoPath }}" class="w-full h-full object-cover">
            </div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-4 font-semibold" data-preview="headline">{{ $invitation->profile->headline ?? 'Please join us for a' }}</p>
            <h1 class="heading-font text-6xl md:text-8xl accent-color mb-4 leading-tight">Birthday Party</h1>
            <p class="text-lg text-gray-600 mb-8">Honoring <span class="font-bold text-gray-800" data-preview="first_name">{{ $firstName }}</span></p>
            <div class="inline-block border-t-2 border-b-2 border-pink-300 py-2 px-8">
                <p class="text-sm uppercase tracking-widest font-bold text-gray-700" data-preview="event_date">
                    {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') : 'Segera' }}
                </p>
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-white border-t border-b border-pink-100">
        <div class="max-w-3xl mx-auto text-center">
            <div class="w-40 h-40 mx-auto overflow-hidden rounded-full border-4 border-white shadow-lg mb-6">
                <img src="{{ $firstPhotoPath }}" class="w-full h-full object-cover">
            </div>
            <h2 class="heading-font text-5xl accent-color mb-4" data-preview="first_name">{{ $firstName }}</h2>

            @if($showParents)
            <p class="text-sm text-gray-500 leading-relaxed mb-6">Putra/Putri tercinta dari <br>
                <span class="font-bold text-gray-700" data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Bapak' }}</span> &amp;
                <span class="font-bold text-gray-700" data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Ibu' }}</span>
            </p>
            @endif

            <p class="text-gray-500 italic max-w-md mx-auto" data-preview="quote">
                "{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Ilmu yang bermanfaat adalah bekal terbaik untuk kehidupan.' }}"
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-24 px-6 bg-white">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <h2 class="heading-font text-5xl accent-color mb-4">Event Details</h2>
        </div>
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8">
            @forelse ($invitation->events as $index => $event)
                <div class="bg-[#FFF5F7] p-10 text-center rounded-3xl shadow-sm border border-pink-100 hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="heading-font text-4xl accent-color mb-4" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-bold text-gray-800 mb-2" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-500 mb-6"><i class="fa-regular fa-clock text-pink-400 mr-2"></i>
                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                        @if($event->end_time)
                            - <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                        @else
                            - Selesai
                        @endif
                    </p>
                    <p class="text-sm font-bold text-gray-800 mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed max-w-xs mx-auto" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>

                    @if($event->google_maps_url)
                        <div class="mt-6">
                            <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block px-6 py-2 accent-bg text-white text-xs uppercase tracking-wider font-bold rounded-full transition-all">
                                Buka Google Maps
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-500">Belum ada event ditambahkan.</p>
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="bg-[#FFF5F7] py-24 px-6 text-center">
        <h2 class="heading-font text-5xl accent-color mb-12">Gallery</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($invitation->galleries as $index => $gallery)
                <div class="polaroid transform rotate-{{ ($index % 2 == 0) ? '2' : '-2' }} hover:rotate-0 transition-transform">
                    @if(file_exists(public_path($gallery->file_path)))
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-48 object-cover mb-3 rounded-lg">
                    @else
                        <img src="https://images.unsplash.com/photo-1530103862676-de8892bf30b5?q=80&w=800" class="w-full h-48 object-cover mb-3 rounded-lg">
                    @endif
                    <p class="heading-font text-xl text-gray-400" data-preview="first_name">{{ $firstName }}</p>
                </div>
            @empty
                @for ($i = 0; $i < 4; $i++)
                    <div class="polaroid transform rotate-{{ ($i % 2 == 0) ? '2' : '-2' }}">
                        <img src="https://images.unsplash.com/photo-1530103862676-de8892bf30b5?q=80&w=800" class="w-full h-48 object-cover mb-3 rounded-lg">
                        <p class="heading-font text-xl text-gray-400" data-preview="first_name">{{ $firstName }}</p>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="py-24 px-6 bg-[#FFF5F7] text-center border-t border-pink-100">
        <div class="max-w-2xl mx-auto">
            <h2 class="heading-font text-5xl accent-color mb-6">See You at The Party</h2>
            <p class="text-gray-500 font-light mb-8" data-preview="closing_text">{{ !empty($invitation->profile->closing_text) ? $invitation->profile->closing_text : 'Kehadiranmu sangat berarti bagiku.' }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-400 mb-2">With Love,</p>
            <h3 class="heading-font text-4xl accent-color" data-preview="first_name">{{ $firstName }}</h3>
        </div>
    </section>
    @endif

    @endif
    @endforeach

    <script>
        function openInvitation() {
            const el = document.getElementById('envelopeOverlay');
            if (el) {
                el.style.opacity = '0';
                setTimeout(() => el.classList.add('hidden'), 1000);
            }
            document.body.classList.remove('envelope-active');
            document.getElementById('weddingMusic').play().catch(() => {});
        }
    </script>
</body>
</html>