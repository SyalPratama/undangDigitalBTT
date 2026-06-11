<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Engagement | {{ $invitation->profile->first_name }} & {{ $invitation->profile->second_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;1,500&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FAFAFA; color: #111; }
        .heading-font { font-family: 'Playfair Display', serif; }
        body.envelope-active { overflow: hidden; }
    </style>
</head>
<body class="antialiased envelope-active selection:bg-black selection:text-white">

    <audio id="weddingMusic" loop><source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg"></audio>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-black text-white transition-all duration-1000">
        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.5em] uppercase text-xs text-gray-400 mb-6">Engagement Invitation</p>
            <h2 class="heading-font text-5xl md:text-6xl mb-8">{{ $invitation->profile->first_name }} & {{ $invitation->profile->second_name }}</h2>
            <div class="border border-white/20 py-4 px-10 mb-10">
                <p class="text-xs text-gray-400 uppercase mb-2">To:</p>
                <p class="font-semibold tracking-wide text-lg">{{ request()->get('to') ?? 'Special Guest' }}</p>
            </div>
            <button onclick="openInvitation()" class="px-10 py-4 bg-white text-black hover:bg-gray-200 text-xs uppercase tracking-widest font-bold transition-all">
                Open Invitation
            </button>
        </div>
    </div>

    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-white">
        <div class="z-10 py-12">
            <h1 class="heading-font text-6xl md:text-8xl leading-tight">{{ $invitation->profile->first_name }}</h1>
            <h1 class="heading-font text-6xl md:text-8xl leading-tight mb-8">{{ $invitation->profile->second_name }}</h1>
            <p class="text-xs uppercase tracking-[0.4em] font-semibold text-gray-500">
                {{ optional($invitation->event_date)->translatedFormat('F d, Y') }}
            </p>
        </div>
    </section>

    <section class="py-24 px-6 bg-black text-white">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10">
            @foreach ($invitation->events as $event)
                <div class="p-10 border border-white/20 text-center">
                    <h3 class="heading-font text-3xl mb-6">{{ $event->name }}</h3>
                    <p class="font-semibold tracking-widest uppercase text-sm mb-2">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-400 mb-6">{{ $event->start_time }} - Selesai</p>
                    <div class="w-10 h-[1px] bg-white/50 mx-auto mb-6"></div>
                    <p class="text-sm font-semibold mb-2">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $event->address }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white py-24 px-6 text-center">
        <h2 class="heading-font text-5xl mb-12">Gallery</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-2">
            @foreach ($invitation->galleries as $gallery)
                <div class="overflow-hidden"><img src="{{ asset($gallery->file_path) }}" class="w-full h-80 object-cover grayscale hover:grayscale-0 transition duration-700"></div>
            @endforeach
        </div>
    </section>

    <script>
        function openInvitation() {
            document.getElementById('envelopeOverlay').style.transform = 'translateY(-100%)';
            document.body.classList.remove('envelope-active');
            document.getElementById('weddingMusic').play();
        }
    </script>
</body>
</html>