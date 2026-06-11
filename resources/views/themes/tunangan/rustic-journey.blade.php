<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Engagement | {{ $invitation->profile->first_name }} & {{ $invitation->profile->second_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', sans-serif; background-color: #FDFBF7; color: #5C4B3C; }
        .heading-font { font-family: 'Cormorant Garamond', serif; }
        .rustic-bg { background-color: #A67C52; }
        .rustic-text { color: #A67C52; }
        .border-rustic { border-color: #D4B895; }
        body.envelope-active { overflow: hidden; }
    </style>
</head>
<body class="antialiased envelope-active">

    <audio id="weddingMusic" loop><source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3" type="audio/mpeg"></audio>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#FDFBF7] transition-all duration-1000">
        <div class="absolute inset-4 border border-rustic opacity-50 rounded-lg pointer-events-none"></div>
        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.4em] uppercase text-xs rustic-text mb-4 font-bold">We Are Engaged</p>
            <h2 class="heading-font text-5xl md:text-7xl text-[#5C4B3C] mb-8">
                {{ $invitation->profile->first_name }} <span class="text-4xl italic rustic-text mx-2">&</span> {{ $invitation->profile->second_name }}
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

    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-[#F5EFE6]">
        <div class="z-10 py-12 max-w-4xl">
            <h1 class="heading-font text-6xl md:text-8xl text-[#5C4B3C] leading-none mb-2">{{ $invitation->profile->first_name }}</h1>
            <h2 class="heading-font text-4xl rustic-text mb-2 italic">and</h2>
            <h1 class="heading-font text-6xl md:text-8xl text-[#5C4B3C] leading-none mb-10">{{ $invitation->profile->second_name }}</h1>
            <div class="w-16 h-[1px] rustic-bg mx-auto mb-6"></div>
            <p class="text-sm uppercase tracking-widest font-bold rustic-text">
                {{ optional($invitation->event_date)->translatedFormat('d F Y') }}
            </p>
        </div>
    </section>

    <section class="py-24 px-6 bg-white border-t border-rustic">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-12">
            @foreach ($invitation->events as $event)
                <div class="p-10 border border-[#F5EFE6] text-center hover:border-[#D4B895] transition-all bg-[#FDFBF7]">
                    <h3 class="heading-font text-4xl rustic-text mb-4">{{ $event->name }}</h3>
                    <p class="font-bold text-[#5C4B3C] mb-1">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-500 mb-6">{{ $event->start_time }} - Selesai</p>
                    <p class="text-sm font-bold text-[#5C4B3C] mb-2">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-500 italic">{{ $event->address }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-[#F5EFE6] py-24 px-6 text-center">
        <h2 class="heading-font text-5xl text-[#5C4B3C] mb-12">Our Moments</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 gap-4 mb-20">
            @foreach ($invitation->galleries as $gallery)
                <div class="overflow-hidden"><img src="{{ asset($gallery->file_path) }}" class="w-full h-72 object-cover filter sepia-[20%] hover:sepia-0 transition duration-700"></div>
            @endforeach
        </div>
        <h2 class="heading-font text-4xl rustic-text">Terima Kasih</h2>
    </section>

    <script>
        function openInvitation() {
            document.getElementById('envelopeOverlay').style.opacity = '0';
            setTimeout(() => document.getElementById('envelopeOverlay').classList.add('hidden'), 1000);
            document.body.classList.remove('envelope-active');
            document.getElementById('weddingMusic').play();
        }
    </script>
</body>
</html>