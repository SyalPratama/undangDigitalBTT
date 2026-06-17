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

        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#000000';

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = ($coverMedia && file_exists(public_path($coverMedia->file_path)))
            ? asset($coverMedia->file_path)
            : 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=2000';

        $defaultOrder = [
            ['id' => 'cover', 'visible' => true],
            ['id' => 'quote', 'visible' => true],
            ['id' => 'profile', 'visible' => true],
            ['id' => 'event', 'visible' => true],
            ['id' => 'gallery', 'visible' => true],
            ['id' => 'closing', 'visible' => true]
        ];
        $sectionOrder = $projectData['section_order'] ?? $defaultOrder;

        $hasSecondPerson = !empty($invitation->profile->second_name);

        $firstPhoto = $invitation->firstPersonPhoto;
        $firstPhotoPath = ($firstPhoto && file_exists(public_path($firstPhoto->file_path)))
            ? asset($firstPhoto->file_path)
            : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=800';

        $secondPhoto = $invitation->secondPersonPhoto;
        $secondPhotoPath = ($secondPhoto && file_exists(public_path($secondPhoto->file_path)))
            ? asset($secondPhoto->file_path)
            : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=800';

        $firstName = !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Mempelai Pria';
        $secondName = !empty($invitation->profile->second_name) ? $invitation->profile->second_name : 'Mempelai Wanita';
    @endphp

    <style>
        :root { --primary-color: {{ $primaryColor }}; }
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; color: #111; }
        .heading-font { font-family: 'Playfair Display', serif; }
        body.envelope-active { overflow: hidden; }
        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
        .accent-bg { background-color: var(--primary-color); }
        .accent-color { color: var(--primary-color); }
        .accent-border { border-color: var(--primary-color); }
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
            <h2 class="heading-font text-5xl md:text-6xl mb-8 leading-tight">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span class="text-3xl font-light italic text-gray-400 block my-2">&amp;</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
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
    @if (in_array(($section['id'] ?? $section['type'] ?? ''), ['univ_countdown', 'univ_maps', 'univ_rsvp', 'univ_comments']))
        @include('themes.partials.universal-sections', ['renderOnly' => ($section['id'] ?? $section['type'] ?? '')])
    @endif


    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-white">
        <div class="z-10 py-12">
            @if($coverImage)
                <div class="max-w-md mx-auto mb-8 overflow-hidden rounded-xl border border-gray-200 p-2 bg-gray-50 shadow-sm">
                    <img src="{{ $coverImage }}" class="w-full h-80 object-cover rounded-lg filter grayscale">
                </div>
            @endif
            <h1 class="heading-font text-5xl md:text-7xl leading-tight" data-preview="first_name">{{ $firstName }}</h1>
            @if($hasSecondPerson)
                <div class="heading-font text-3xl font-light italic my-2">&amp;</div>
                <h1 class="heading-font text-5xl md:text-7xl leading-tight mb-8" data-preview="second_name">{{ $secondName }}</h1>
            @endif
            <p class="text-xs uppercase tracking-[0.4em] font-semibold text-gray-500" data-preview="event_date">
                {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('F d, Y') : 'Segera' }}
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 bg-gray-50 text-center border-t border-b border-gray-200/50">
        <div class="max-w-2xl mx-auto italic text-gray-600 text-lg leading-relaxed" data-preview="quote">
            "{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Dua hati yang dipersatukan dalam janji suci pertunangan, menuju gerbang pelaminan.' }}"
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-white text-center">
        <h2 class="heading-font text-4xl mb-16">The Couple</h2>
        <div class="flex flex-wrap justify-center gap-16">
            <div class="w-64">
                <div class="w-48 h-48 rounded-full overflow-hidden mb-6 mx-auto border-2 border-gray-100 p-1 bg-white shadow-sm">
                    <img src="{{ $firstPhotoPath }}" class="w-full h-full rounded-full object-cover filter grayscale hover:grayscale-0 transition duration-500">
                </div>
                <h3 class="heading-font text-2xl" data-preview="first_name">{{ $firstName }}</h3>
                @if($showParents)
                    <p class="text-xs text-gray-500 mt-3 leading-relaxed">Putra dari <br>
                        <span class="font-semibold text-gray-800" data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Ayah' }}</span> &amp;
                        <span class="font-semibold text-gray-800" data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                    </p>
                @endif
            </div>

            @if($hasSecondPerson)
            <div class="w-64">
                <div class="w-48 h-48 rounded-full overflow-hidden mb-6 mx-auto border-2 border-gray-100 p-1 bg-white shadow-sm">
                    <img src="{{ $secondPhotoPath }}" class="w-full h-full rounded-full object-cover filter grayscale hover:grayscale-0 transition duration-500">
                </div>
                <h3 class="heading-font text-2xl" data-preview="second_name">{{ $secondName }}</h3>
                @if($showParents)
                    <p class="text-xs text-gray-500 mt-3 leading-relaxed">Putri dari <br>
                        <span class="font-semibold text-gray-800" data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Ayah' }}</span> &amp;
                        <span class="font-semibold text-gray-800" data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
                    </p>
                @endif
            </div>
            @endif
        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-24 px-6 bg-black text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10">
            @forelse ($invitation->events as $index => $event)
                <div class="p-10 border border-white/20 text-center hover:border-white transition-colors bg-[#080808]">
                    <h3 class="heading-font text-3xl mb-6" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-semibold tracking-widest uppercase text-sm mb-2" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-400 mb-6">
                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                        @if($event->end_time)
                            - <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                        @else
                            - Selesai
                        @endif
                    </p>
                    <div class="w-10 h-[1px] bg-white/50 mx-auto mb-6"></div>
                    <p class="text-sm font-semibold mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-400 leading-relaxed mb-6" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>

                    @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block px-8 py-2 bg-white text-black hover:bg-gray-200 text-xs uppercase tracking-widest font-bold transition-all">
                            Buka Peta Lokasi
                        </a>
                    @endif
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-500">Belum ada event.</p>
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="bg-white py-24 px-6 text-center border-t border-b border-gray-100">
        <h2 class="heading-font text-5xl mb-12">Our Moments</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($invitation->galleries as $gallery)
                <div class="overflow-hidden bg-gray-50 border p-1 rounded-xl shadow-sm">
                    @if(file_exists(public_path($gallery->file_path)))
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-80 object-cover rounded-lg filter grayscale hover:grayscale-0 transition duration-700">
                    @else
                        <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=800" class="w-full h-80 object-cover rounded-lg filter grayscale hover:grayscale-0 transition duration-700">
                    @endif
                </div>
            @empty
                @for ($i = 0; $i < 3; $i++)
                    <div class="overflow-hidden bg-gray-50 border p-1 rounded-xl shadow-sm">
                        <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=800" class="w-full h-80 object-cover rounded-lg filter grayscale">
                    </div>
                @endfor
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="bg-gray-50 py-24 px-6 text-center">
        <div class="max-w-xl mx-auto">
            <p class="text-gray-600 italic mb-8 leading-relaxed" data-preview="closing_text">{{ $invitation->profile->closing_text ?? 'Terima kasih atas doa restu Anda semua.' }}</p>
            <p class="text-xs uppercase tracking-widest text-gray-400 mb-4">Kami Yang Berbahagia,</p>
            <h3 class="heading-font text-3xl font-bold">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    &amp; <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </h3>
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
            document.getElementById('weddingMusic').play().catch(() => {});
        }
    </script>
</body>
</html>