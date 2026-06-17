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
            <h2 class="heading-font text-5xl md:text-7xl text-[#5C4B3C] mb-8 leading-tight">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span class="text-4xl italic rustic-text block my-2">&amp;</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
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
    @if (in_array(($section['id'] ?? $section['type'] ?? ''), ['univ_countdown', 'univ_maps', 'univ_rsvp', 'univ_comments']))
        @include('themes.partials.universal-sections', ['renderOnly' => ($section['id'] ?? $section['type'] ?? '')])
    @endif


    @if ($section['id'] == 'cover')
    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-[#F5EFE6]">
        <div class="z-10 py-12 max-w-4xl">
            @if($coverImage)
                <div class="max-w-sm mx-auto mb-8 overflow-hidden rounded-xl border border-rustic p-1 bg-white shadow-sm">
                    <img src="{{ $coverImage }}" class="w-full h-72 object-cover rounded-lg">
                </div>
            @endif
            <h1 class="heading-font text-5xl md:text-7xl text-[#5C4B3C] leading-none mb-2" data-preview="first_name">{{ $firstName }}</h1>
            @if($hasSecondPerson)
                <h2 class="heading-font text-3xl rustic-text mb-2 italic">&amp;</h2>
                <h1 class="heading-font text-5xl md:text-7xl text-[#5C4B3C] leading-none mb-10" data-preview="second_name">{{ $secondName }}</h1>
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
        <div class="max-w-2xl mx-auto text-center border-t border-b border-rustic/20 py-8">
            <p class="text-[#5C4B3C] italic font-serif text-xl" data-preview="quote">
                "{{ !empty($invitation->profile->quote) ? $invitation->profile->quote : 'Janji suci pertunangan telah terukir, menyatukan langkah kami berdua menuju penyempurnaan ibadah pernikahan.' }}"
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-white border-t border-b border-rustic">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-center gap-12">

            <div class="text-center w-full max-w-xs">
                <div class="w-48 h-48 mx-auto rounded-full border-2 border-rustic overflow-hidden mb-6 shadow-sm p-1 bg-white">
                    <img src="{{ $firstPhotoPath }}" class="w-full h-full rounded-full object-cover">
                </div>
                <h3 class="heading-font text-4xl rustic-text mb-4" data-preview="first_name">{{ $firstName }}</h3>
                @if($showParents)
                    <p class="text-xs text-gray-500 leading-relaxed">Putra dari <br>
                        <span class="font-bold text-[#5C4B3C]" data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Ayah' }}</span> &amp;
                        <span class="font-bold text-[#5C4B3C]" data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                    </p>
                @endif
            </div>

            @if($hasSecondPerson)
            <div class="text-center w-full max-w-xs">
                <div class="w-48 h-48 mx-auto rounded-full border-2 border-rustic overflow-hidden mb-6 shadow-sm p-1 bg-white">
                    <img src="{{ $secondPhotoPath }}" class="w-full h-full rounded-full object-cover">
                </div>
                <h3 class="heading-font text-4xl rustic-text mb-4" data-preview="second_name">{{ $secondName }}</h3>
                @if($showParents)
                    <p class="text-xs text-gray-500 leading-relaxed">Putri dari <br>
                        <span class="font-bold text-[#5C4B3C]" data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Ayah' }}</span> &amp;
                        <span class="font-bold text-[#5C4B3C]" data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
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
                <div class="p-10 border border-[#F5EFE6] text-center hover:border-[#D4B895] transition-all bg-white shadow-sm rounded-lg">
                    <h3 class="heading-font text-4xl rustic-text mb-4" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-bold text-[#5C4B3C] mb-1" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-500 mb-6">
                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                        @if($event->end_time)
                            - <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                        @else
                            - Selesai
                        @endif
                    </p>
                    <p class="text-sm font-bold text-[#5C4B3C] mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-500 italic mb-6" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>

                    @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block px-6 py-2 rustic-bg hover:opacity-90 text-white text-xs uppercase tracking-wider rounded transition-all font-bold">
                            Open Maps
                        </a>
                    @endif
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
            @forelse ($invitation->galleries as $index => $gallery)
                <div class="overflow-hidden rounded-xl border border-[#e5dccf] bg-white p-1 shadow-sm">
                    @if(file_exists(public_path($gallery->file_path)))
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-72 object-cover rounded-lg filter sepia-[20%] hover:sepia-0 transition duration-700">
                    @else
                        <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=800" class="w-full h-72 object-cover rounded-lg filter sepia-[20%] hover:sepia-0 transition duration-700">
                    @endif
                </div>
            @empty
                @for ($i = 0; $i < 3; $i++)
                    <div class="overflow-hidden rounded-xl border border-[#e5dccf] bg-white p-1 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=800" class="w-full h-72 object-cover rounded-lg filter sepia-[20%]">
                    </div>
                @endfor
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="py-24 px-6 text-center bg-white border-t border-rustic/20">
        <div class="max-w-xl mx-auto">
            <h2 class="heading-font text-4xl rustic-text mb-4">Terima Kasih</h2>
            <p class="text-gray-500 italic mb-8 leading-relaxed" data-preview="closing_text">{{ $invitation->profile->closing_text ?? 'Ungkapan terima kasih yang tulus kami hantarkan atas doa restu Bapak/Ibu/Saudara/i sekalian.' }}</p>
            <h3 class="heading-font text-2xl text-[#5C4B3C] font-bold">
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