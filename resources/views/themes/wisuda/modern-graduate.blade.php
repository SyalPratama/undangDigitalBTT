<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,600;1,400&display=swap" rel="stylesheet">

    @php
        $projectData = [];
        if(isset($invitation->builder->project_data)) {
            $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        $musicMedia = $invitation->media->where('type', 'music')->first();
        $musicPath = $musicMedia ? asset($musicMedia->file_path) . '?t=' . time() : 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';

        $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : true;
        $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#3b82f6';

        $coverMedia = $invitation->media->where('type', 'cover')->first();
        $coverImage = ($coverMedia && file_exists(public_path($coverMedia->file_path)))
            ? asset($coverMedia->file_path) . '?t=' . time()
            : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2000';

        $defaultOrder = [
            ['id' => 'cover', 'visible' => true],
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
        :root { --primary-color: {{ $primaryColor }}; }
        body { font-family: 'Outfit', sans-serif; background-color: #F8FAFC; color: #334155; }
        .heading-font { font-family: 'Playfair Display', serif; }
        body.envelope-active { overflow: hidden; }
        body.is-editor #envelopeOverlay { display: none !important; }
        body.is-editor { overflow: auto !important; }
        .accent-color { color: var(--primary-color); }
        .accent-bg { background-color: var(--primary-color); }
        .accent-border { border-color: var(--primary-color); }
    </style>
    <script> if (window.self !== window.top) document.documentElement.classList.add('is-editor'); </script>
</head>
<body class="antialiased envelope-active selection:bg-slate-300">
    <script> if (window.self !== window.top) { document.body.classList.add('is-editor'); document.body.classList.remove('envelope-active'); } </script>

    <audio id="weddingMusic" loop><source src="{{ $musicPath }}" type="audio/mpeg"></audio>

    @if(!request()->has('preview'))
    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#0F172A] transition-all duration-1000">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#334155 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="max-w-xl text-center px-6 z-10 bg-[#1E293B] p-12 rounded-3xl border border-slate-700 shadow-2xl">
            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-graduation-cap text-slate-300 text-2xl"></i>
            </div>
            <p class="tracking-[0.4em] uppercase text-xs text-slate-400 mb-2 font-semibold">You're Invited To</p>
            <h2 class="heading-font text-4xl md:text-5xl text-white mb-8">
                <span data-preview="first_name">{{ $firstName }}</span>'s Graduation
                @if($hasSecondPerson)
                    <br>&amp; <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </h2>
            <div class="bg-[#0F172A] py-4 px-8 rounded-xl border border-slate-800 mb-8">
                <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Proudly Inviting:</p>
                <p class="text-slate-200 font-bold text-lg">{{ request()->get('to') ?? 'Bapak/Ibu/Saudara/i' }}</p>
            </div>
            <button onclick="openInvitation()" class="w-full py-4 bg-slate-200 hover:bg-white text-slate-900 text-xs uppercase tracking-[0.2em] font-extrabold rounded-xl transition-all">
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
        <div class="absolute top-0 w-full h-1/2 bg-slate-50 transform -skew-y-6 origin-top-left -z-10"></div>
        <div class="z-10 py-12 max-w-4xl">
            <div class="w-48 h-48 mx-auto overflow-hidden rounded-full shadow-lg border-8 border-white mb-8">
                <img src="{{ $firstPhotoPath }}" class="w-full h-full object-cover">
            </div>
            <p class="text-sm uppercase tracking-[0.3em] font-bold text-slate-400 mb-2" data-preview="headline">{{ $invitation->profile->headline ?? 'Class of 2026' }}</p>

            <h1 class="heading-font text-5xl md:text-7xl text-slate-800 mb-4">
                <span data-preview="first_name">{{ $firstName }}</span>
                @if($hasSecondPerson)
                    <span class="accent-color italic text-3xl font-light mx-2">&amp;</span>
                    <span data-preview="second_name">{{ $secondName }}</span>
                @endif
            </h1>

            <p class="text-lg text-slate-500 mb-10 max-w-xl mx-auto leading-relaxed" data-preview="quote">
                "{{ $invitation->profile->quote ?? 'Bukan tentang seberapa cepat, tapi tentang seberapa kuat bertahan hingga garis akhir.' }}"
            </p>
            <div class="inline-block bg-slate-900 text-white py-3 px-10 rounded-full shadow-md">
                <p class="text-sm tracking-widest font-bold uppercase" data-preview="event_date">
                    {{ isset($invitation->event_date) ? \Carbon\Carbon::parse($invitation->event_date)->translatedFormat('l, d F Y') : 'Segera' }}
                </p>
            </div>
        </div>
    </section>
    @endif

    @if ($section['id'] == 'profile')
    <section class="py-24 px-6 bg-white border-t border-slate-100">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-center gap-12">

            <div class="bg-slate-50 p-10 rounded-3xl border border-slate-100 text-center max-w-sm w-full">
                <div class="w-36 h-36 mx-auto overflow-hidden rounded-full shadow-md border-4 border-white mb-6">
                    <img src="{{ $firstPhotoPath }}" class="w-full h-full object-cover">
                </div>
                <h3 class="heading-font text-3xl text-slate-800 mb-4" data-preview="first_name">{{ $firstName }}</h3>

                @if($showParents)
                <p class="text-xs text-slate-500 mb-6 leading-relaxed">Putra/Putri dari <br>
                    <span class="font-semibold text-slate-700" data-preview="first_father">{{ !empty($invitation->profile->first_father) ? $invitation->profile->first_father : 'Nama Ayah' }}</span> &amp;
                    <span class="font-semibold text-slate-700" data-preview="first_mother">{{ !empty($invitation->profile->first_mother) ? $invitation->profile->first_mother : 'Nama Ibu' }}</span>
                </p>
                @endif
                <div class="w-12 h-[1px] bg-slate-300 mx-auto mb-4"></div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">Akademik</p>
                <p class="text-sm font-semibold text-slate-700" data-preview="program_studi">{{ $programStudi }}</p>
                <p class="text-xs text-slate-500" data-preview="universitas">{{ $universitas }}</p>
            </div>

            @if($hasSecondPerson)
            <div class="bg-slate-50 p-10 rounded-3xl border border-slate-100 text-center max-w-sm w-full">
                <div class="w-36 h-36 mx-auto overflow-hidden rounded-full shadow-md border-4 border-white mb-6">
                    <img src="{{ $secondPhotoPath }}" class="w-full h-full object-cover">
                </div>
                <h3 class="heading-font text-3xl text-slate-800 mb-4" data-preview="second_name">{{ $secondName }}</h3>

                @if($showParents)
                <p class="text-xs text-slate-500 mb-6 leading-relaxed">Putra/Putri dari <br>
                    <span class="font-semibold text-slate-700" data-preview="second_father">{{ !empty($invitation->profile->second_father) ? $invitation->profile->second_father : 'Nama Ayah' }}</span> &amp;
                    <span class="font-semibold text-slate-700" data-preview="second_mother">{{ !empty($invitation->profile->second_mother) ? $invitation->profile->second_mother : 'Nama Ibu' }}</span>
                </p>
                @endif
                <div class="w-12 h-[1px] bg-slate-300 mx-auto mb-4"></div>
                <p class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">Akademik</p>
                <p class="text-sm font-semibold text-slate-700" data-preview="program_studi">{{ $programStudi }}</p>
                <p class="text-xs text-slate-500" data-preview="universitas">{{ $universitas }}</p>
            </div>
            @endif

        </div>
    </section>
    @endif

    @if ($section['id'] == 'event')
    <section class="py-24 px-6 bg-slate-50">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8">
            @forelse ($invitation->events as $index => $event)
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-regular fa-calendar-check text-slate-600"></i>
                    </div>
                    <h3 class="heading-font text-3xl text-slate-800 mb-4" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    <p class="font-bold text-slate-600 mb-2" data-event-preview="event_date_{{ $index }}">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-slate-500 mb-6">
                        <span data-event-preview="start_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}</span>
                        @if($event->end_time)
                            - <span data-event-preview="end_time_{{ $index }}">{{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                        @else
                            - Selesai
                        @endif
                    </p>
                    <div class="w-8 h-1 bg-slate-200 mx-auto mb-6"></div>
                    <p class="text-slate-800 font-bold mb-2" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>

                    @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank" class="inline-block mt-4 px-6 py-2 border accent-border accent-color hover:accent-bg hover:text-white text-xs uppercase tracking-wider transition-all rounded-lg font-bold">
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
    <section class="bg-white py-24 px-6 text-center">
        <h2 class="heading-font text-5xl accent-color mb-12">Gallery Kelulusan</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($invitation->galleries as $gallery)
                <div class="overflow-hidden rounded-2xl shadow-md border border-slate-100 p-2">
                    @if(file_exists(public_path($gallery->file_path)))
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-48 object-cover rounded-xl hover:scale-105 transition duration-500">
                    @else
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" class="w-full h-48 object-cover rounded-xl hover:scale-105 transition duration-500">
                    @endif
                </div>
            @empty
                @for ($i = 0; $i < 4; $i++)
                    <div class="overflow-hidden rounded-2xl shadow-md border border-slate-100 p-2">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800" class="w-full h-48 object-cover rounded-xl">
                    </div>
                @endfor
            @endforelse
        </div>
    </section>
    @endif

    @if ($section['id'] == 'closing')
    <section class="py-24 px-6 bg-slate-900 text-white text-center">
        <div class="max-w-xl mx-auto">
            <h2 class="heading-font text-4xl mb-6">Terima Kasih</h2>
            <p class="text-slate-400 font-light mb-8" data-preview="closing_text">{{ $invitation->profile->closing_text ?? 'Kehadiran serta doa restu Bapak/Ibu/Saudara/i sangat berarti bagi kami.' }}</p>
            <h3 class="heading-font text-2xl text-slate-300">
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