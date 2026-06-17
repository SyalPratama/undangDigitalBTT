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

        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#C5A059';

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = ($coverMedia && file_exists(public_path($coverMedia->file_path)))
            ? asset($coverMedia->file_path) . '?t=' . time()
            : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2000';

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
            : 'https://images.unsplash.com/photo-1539269071019-8bc6d57b0205?q=80&w=800';

        $secondPhoto = $invitation->secondPersonPhoto;
        $secondPhotoPath = ($secondPhoto && file_exists(public_path($secondPhoto->file_path)))
            ? asset($secondPhoto->file_path)
            : 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800';

        $firstName = !empty($invitation->profile->first_name) ? $invitation->profile->first_name : 'Nama Wisudawan';
        $secondName = $invitation->profile->second_name;

        $programStudi = !empty($projectData['program_studi']) ? $projectData['program_studi'] : 'Teknik Informatika';
        $universitas = !empty($projectData['universitas']) ? $projectData['universitas'] : 'Universitas XYZ';
    @endphp

    <style>
        body { font-family: 'Lora', serif; background-color: #FDFBF7; color: #4A0E17; }
        .heading-font { font-family: 'Cinzel', serif; }
        .maroon-bg { background-color: #4A0E17; }
        .maroon-text { color: #4A0E17; }
        .gold-text { color: {{ $primaryColor }}; }
        .gold-border { border-color: {{ $primaryColor }}; }
        .gold-bg { background-color: {{ $primaryColor }}; }
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
            <h1 class="heading-font text-4xl gold-text mb-8">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span class="text-2xl text-white block my-2">&amp;</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </h1>

            <div class="bg-[#3A0A11] border gold-border py-4 px-12 mb-10 shadow-xl">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-2 font-sans">Disampaikan Kepada:</p>
                <p class="gold-text font-bold text-xl">{{ request()->get('to') ?? 'Tamu Kehormatan' }}</p>
            </div>

            <button onclick="openInvitation()" class="px-12 py-3 bg-[#C5A059] gold-bg hover:opacity-90 text-[#4A0E17] text-xs uppercase tracking-[0.2em] font-bold transition-all font-sans">
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
    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-[#FDFBF7]">
        <div class="absolute inset-4 border border-[#4A0E17] opacity-20 pointer-events-none"></div>
        <div class="z-10 py-12 max-w-4xl border gold-border p-10 md:p-20 bg-white shadow-sm">
            <p class="text-xs uppercase tracking-[0.4em] maroon-text mb-8 font-sans font-bold" data-preview="headline">{{ $invitation->profile->headline ?? 'Pelepasan Wisudawan' }}</p>

            <h1 class="heading-font text-5xl md:text-7xl maroon-text leading-none mb-6">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <div class="text-2xl gold-text my-2">&amp;</div>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </h1>

            <p class="text-gray-600 italic mb-10 leading-relaxed max-w-lg mx-auto" data-preview="quote">
                "{{ $invitation->profile->quote ?? 'Sebuah perjalanan panjang yang diakhiri dengan rasa syukur tak terhingga.' }}"
            </p>
            <div class="w-24 h-[1px] gold-bg mx-auto mb-6"></div>
            <p class="heading-font text-xl maroon-text font-bold" data-preview="event_date">
                {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('d F Y') : 'Segera' }}
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'quote')
    <section class="py-24 px-6 bg-white text-center border-t border-b border-[#F5EFE6]">
        <div class="max-w-2xl mx-auto border-4 double gold-border p-10 bg-[#FDFBF7]">
            <i class="fa-solid fa-quote-left text-3xl gold-text mb-6"></i>
            <p class="text-gray-700 italic leading-relaxed text-lg" data-preview="quote">
                "{{ $invitation->profile->quote ?? 'Ilmu adalah cahaya penuntun langkah. Kelulusan ini bukanlah akhir, melainkan awal dari pengabdian nyata kepada masyarakat.' }}"
            </p>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-[#FDFBF7]">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-center gap-12">

            <div class="border gold-border p-8 md:p-12 text-center bg-white relative max-w-sm w-full shadow-sm">
                <div class="w-40 h-40 mx-auto overflow-hidden rounded-full border-4 gold-border mb-6">
                    <img src="{{ $firstPhotoPath }}" class="w-full h-full object-cover">
                </div>
                <h3 class="heading-font text-2xl maroon-text font-bold mb-4" data-preview="first_name">{{ $firstName }}</h3>

                @if($showParents)
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Putra/Putri dari <br>
                    <span class="font-semibold maroon-text" data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Ayah' }}</span> &amp;
                    <span class="font-semibold maroon-text" data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                </p>
                @endif
                <div class="w-16 h-[1px] gold-bg mx-auto mb-4"></div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Program Studi</p>
                <p class="text-sm font-semibold maroon-text mb-2" data-preview="program_studi">{{ $programStudi }}</p>
                <p class="text-xs text-gray-500" data-preview="universitas">{{ $universitas }}</p>
            </div>

            @if($hasSecondPerson)
            <div class="border gold-border p-8 md:p-12 text-center bg-white relative max-w-sm w-full shadow-sm">
                <div class="w-40 h-40 mx-auto overflow-hidden rounded-full border-4 gold-border mb-6">
                    <img src="{{ $secondPhotoPath }}" class="w-full h-full object-cover">
                </div>
                <h3 class="heading-font text-2xl maroon-text font-bold mb-4" data-preview="second_name">{{ $secondName }}</h3>

                @if($showParents)
                <p class="text-xs text-gray-500 mb-6 leading-relaxed">Putra/Putri dari <br>
                    <span class="font-semibold maroon-text" data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Ayah' }}</span> &amp;
                    <span class="font-semibold maroon-text" data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
                </p>
                @endif
                <div class="w-16 h-[1px] gold-bg mx-auto mb-4"></div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Program Studi</p>
                <p class="text-sm font-semibold maroon-text mb-2" data-preview="program_studi">{{ $programStudi }}</p>
                <p class="text-xs text-gray-500" data-preview="universitas">{{ $universitas }}</p>
            </div>
            @endif

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
                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                        @if($event->end_time)
                            - <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                        @else
                            - Selesai
                        @endif
                    </p>
                    <p class="text-lg font-bold text-white mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-sm text-gray-400 leading-relaxed mb-6" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>

                    @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block px-8 py-2 border gold-border gold-text hover:gold-bg hover:text-[#4A0E17] text-xs uppercase tracking-widest font-bold transition-all">
                            Buka Peta Lokasi
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if ($section['id'] == 'gallery')
    <section class="bg-[#FDFBF7] py-24 px-6 text-center">
        <h2 class="heading-font text-4xl maroon-text mb-12">Galeri Kelulusan</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse ($invitation->galleries as $index => $gallery)
                <div class="border-4 border-white shadow-md overflow-hidden bg-white p-1">
                    @if(file_exists(public_path($gallery->file_path)))
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-64 object-cover filter sepia-[20%] hover:sepia-0 transition duration-700 hover:scale-105">
                    @else
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" class="w-full h-64 object-cover filter sepia-[20%] hover:sepia-0 transition duration-700 hover:scale-105">
                    @endif
                </div>
            @empty
                @for ($i = 0; $i < 4; $i++)
                    <div class="border-4 border-white shadow-md overflow-hidden bg-white p-1">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" class="w-full h-64 object-cover filter sepia-[20%]">
                    </div>
                @endfor
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="py-24 px-6 bg-white text-center border-t border-[#F5EFE6]">
        <div class="max-w-xl mx-auto">
            <h2 class="heading-font text-3xl maroon-text mb-6">Ungkapan Terima Kasih</h2>
            <p class="text-gray-600 italic mb-8 leading-relaxed" data-preview="closing_text">{{ $invitation->profile->closing_text ?? 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.' }}</p>
            <h3 class="heading-font text-2xl gold-text font-bold">
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