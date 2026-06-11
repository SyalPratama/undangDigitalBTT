<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Celebration | {{ $invitation->profile->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lato', sans-serif; background-color: #0A0A0A; color: #E5E5E5; }
        .heading-font { font-family: 'Playfair Display', serif; }
        .gold-text { color: #D4AF37; }
        .gold-bg { background-color: #D4AF37; }
        .gold-border { border-color: #D4AF37; }
        .hero-bg {
            background: linear-gradient(rgba(10, 10, 10, 0.8), rgba(10, 10, 10, 0.95)),
                url('{{ $invitation->cover?->file_path ? asset('storage/' . $invitation->cover->file_path) : 'https://images.unsplash.com/photo-1530103862676-de8892bf30b5?q=80&w=2000' }}');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        body.envelope-active { overflow: hidden; }
    </style>
</head>
<body class="antialiased selection:bg-[#D4AF37] selection:text-black envelope-active">

    <audio id="weddingMusic" loop><source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-12.mp3" type="audio/mpeg"></audio>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#111111] transition-all duration-1000">
        <div class="absolute inset-6 border gold-border opacity-30 pointer-events-none"></div>
        <div class="max-w-xl text-center px-6 z-10">
            <p class="tracking-[0.4em] uppercase text-xs gold-text mb-4 font-bold">Exclusive Invitation</p>
            <h2 class="heading-font text-5xl md:text-6xl gold-text mb-2 italic">The Milestone</h2>
            <h2 class="heading-font text-3xl text-white mb-8">Of {{ $invitation->profile->first_name }}</h2>
            
            <div class="border border-[#333] bg-[#0A0A0A] py-5 px-12 mb-10 shadow-2xl">
                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-2">Reserved For:</p>
                <p class="gold-text font-bold text-xl">{{ request()->get('to') ?? 'VIP Guest' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="px-10 py-3 gold-bg hover:bg-[#B5952F] text-black text-xs uppercase tracking-widest font-bold transition-all shadow-[0_0_15px_rgba(212,175,55,0.3)]">
                Open Invitation
            </button>
        </div>
    </div>

    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-6 relative">
        <div class="z-10 py-12 max-w-4xl border border-white/10 p-10 bg-black/40 backdrop-blur-sm">
            <h3 class="tracking-[0.3em] uppercase text-xs text-gray-400 mb-6 font-semibold">Join The Celebration</h3>
            <h1 class="heading-font text-6xl md:text-8xl gold-text leading-none mb-6">
                {{ $invitation->profile->first_name }}
            </h1>
            <p class="text-gray-300 font-light max-w-lg mx-auto italic mb-10 text-lg">
                "{{ $invitation->profile->quote ?? 'Cheers to another year of life, love, and unforgettable memories.' }}"
            </p>
            <div class="w-16 h-[1px] gold-bg mx-auto mb-6"></div>
            <p class="text-sm uppercase tracking-[0.2em] font-bold text-white">
                {{ optional($invitation->event_date)->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </section>

    <section class="py-24 px-6 bg-[#0A0A0A] border-t border-[#222]">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-10">
            @foreach ($invitation->events as $event)
                <div class="p-10 border border-[#333] text-center hover:border-[#D4AF37] transition-colors bg-[#111111]">
                    <h3 class="heading-font text-3xl gold-text mb-6 italic">{{ $event->name }}</h3>
                    <p class="font-bold text-white mb-2">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-400 mb-8"><i class="fa-regular fa-clock gold-text mr-2"></i> {{ $event->start_time }} - Selesai</p>
                    <p class="text-sm font-bold text-white mb-2">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $event->address }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-[#111111] py-24 px-6 text-center">
        <h2 class="heading-font text-4xl gold-text mb-12 italic">Moments to Remember</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-2 mb-16">
            @foreach ($invitation->galleries as $gallery)
                <div class="overflow-hidden"><img src="{{ asset($gallery->file_path) }}" class="w-full h-64 object-cover filter grayscale hover:grayscale-0 transition duration-700"></div>
            @endforeach
        </div>
        <h3 class="heading-font text-3xl text-white">See you at the party!</h3>
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