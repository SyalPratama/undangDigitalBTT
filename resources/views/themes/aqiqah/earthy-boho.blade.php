<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syukuran Aqiqah | {{ $invitation->profile->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #FDFBF7; }
        .heading-font { font-family: 'Playfair Display', serif; }
        .accent-color { color: #C68B59; }
        .accent-bg { background-color: #C68B59; }
        .arch-image { border-radius: 120px 120px 0 0; }
        body.envelope-active { overflow: hidden; }
    </style>
</head>
<body class="text-[#4A403A] antialiased envelope-active">

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3" type="audio/mpeg">
    </audio>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#FDFBF7] transition-all duration-1000">
        <div class="max-w-xl text-center px-6">
            <div class="w-20 h-20 bg-[#E8E0D5] rounded-full mx-auto flex items-center justify-center mb-8">
                <i class="fa-solid fa-heart accent-color text-2xl"></i>
            </div>
            <p class="tracking-[0.4em] uppercase text-[10px] text-gray-400 mb-4">The Aqiqah Celebration Of</p>
            <h2 class="heading-font text-5xl accent-color mb-10">{{ $invitation->profile->first_name }}</h2>
            <button onclick="openInvitation()" class="px-12 py-3 bg-[#4A403A] hover:accent-bg text-white text-xs uppercase tracking-[0.3em] font-bold transition-all shadow-xl">
                Open Invitation
            </button>
        </div>
    </div>

    <section class="min-h-screen flex items-center justify-center text-center px-6 relative">
        <div class="max-w-4xl border border-[#E8E0D5] p-10 md:p-20 relative">
            <div class="absolute -top-4 -left-4 w-12 h-12 border-t-2 border-l-2 border-[#C68B59]"></div>
            <div class="absolute -bottom-4 -right-4 w-12 h-12 border-b-2 border-r-2 border-[#C68B59]"></div>
            
            <p class="tracking-[0.5em] uppercase text-xs mb-8">Syukuran & Aqiqah</p>
            <h1 class="heading-font text-6xl md:text-8xl accent-color mb-8 leading-none">
                {{ $invitation->profile->first_name }}
            </h1>
            <p class="text-sm italic text-gray-500 mb-12">"A gift from heaven, a joy for our hearts."</p>
            <p class="font-bold tracking-widest text-lg">{{ optional($invitation->event_date)->translatedFormat('l, d . m . Y') }}</p>
        </div>
    </section>

    <section class="py-32 px-6 bg-white">
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1">
                <h2 class="heading-font text-4xl mb-6 accent-color">Assalamu'alaikum Wr. Wb.</h2>
                <p class="leading-relaxed text-sm text-gray-600 mb-6">Tiada kata yang paling indah selain ungkapan rasa syukur kepada Allah SWT atas lahirnya putra/putri kami tercinta:</p>
                <h3 class="text-2xl font-bold mb-2">{{ $invitation->profile->first_name }}</h3>
                <p class="text-sm text-gray-500">Lahir pada: {{ optional($invitation->event_date)->translatedFormat('d F Y') }}</p>
                <div class="w-16 h-1 accent-bg my-6"></div>
                <p class="text-sm font-semibold uppercase tracking-widest">Kami yang berbahagia,</p>
                <p class="text-lg">Keluarga Bpk. {{ $invitation->profile->first_father }}</p>
            </div>
            <div class="order-1 md:order-2">
                @if ($invitation->firstPersonPhoto)
                    <div class="w-full h-[500px] arch-image overflow-hidden shadow-2xl border-4 border-[#FDFBF7]">
                        <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover">
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="py-24 px-6 bg-[#F9F6F2]">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <h2 class="heading-font text-4xl accent-color mb-4">Agenda Acara</h2>
            <div class="w-20 h-[1px] bg-gray-300 mx-auto"></div>
        </div>
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10">
            @foreach ($invitation->events as $event)
                <div class="bg-white p-12 shadow-sm border border-[#E8E0D5] relative group hover:border-[#C68B59] transition-all">
                    <h3 class="heading-font text-2xl mb-6">{{ $event->name }}</h3>
                    <p class="text-sm mb-2"><i class="fa-regular fa-clock accent-color mr-2"></i> {{ $event->start_time }} - Selesai</p>
                    <p class="text-sm mb-6"><i class="fa-solid fa-location-dot accent-color mr-2"></i> {{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-400 italic leading-relaxed">{{ $event->address }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <script>
        function openInvitation() {
            document.getElementById('envelopeOverlay').style.opacity = '0';
            setTimeout(() => document.getElementById('envelopeOverlay').classList.add('hidden'), 1000);
            document.body.classList.remove('envelope-active');
            document.getElementById('weddingMusic').play();
        }
    </script>

    @include('themes.partials.universal-sections')
</body>
</html>