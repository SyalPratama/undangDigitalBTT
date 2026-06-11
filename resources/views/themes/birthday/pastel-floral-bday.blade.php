<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Invitation | {{ $invitation->profile->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #FFF5F7; color: #4A5568; }
        .heading-font { font-family: 'Dancing Script', cursive; }
        .accent-color { color: #D53F8C; }
        .accent-bg { background-color: #D53F8C; }
        .soft-bg {
            background: linear-gradient(rgba(255, 245, 247, 0.8), rgba(255, 245, 247, 0.95)),
                url('{{ $invitation->cover?->file_path ? asset('storage/' . $invitation->cover->file_path) : 'https://images.unsplash.com/photo-1508169351866-777fc0047ac5?q=80&w=2000' }}');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        .polaroid { background: white; padding: 10px 10px 30px 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        body.envelope-active { overflow: hidden; }
    </style>
</head>
<body class="antialiased envelope-active selection:bg-pink-200">

    <audio id="weddingMusic" loop><source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3" type="audio/mpeg"></audio>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#FFF5F7] transition-all duration-1000">
        <div class="absolute top-10 left-10 w-48 h-48 bg-pink-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 bg-purple-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
        
        <div class="max-w-xl text-center px-6 z-10">
            <h2 class="heading-font text-6xl md:text-7xl accent-color mb-6">{{ $invitation->profile->first_name }}'s</h2>
            <p class="tracking-[0.3em] uppercase text-sm text-gray-500 mb-8 font-bold">Birthday Celebration</p>
            
            <div class="bg-white/60 backdrop-blur-md border border-pink-200 py-4 px-10 rounded-3xl mb-10 shadow-sm">
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Hello,</p>
                <p class="text-gray-800 font-bold text-lg">{{ request()->get('to') ?? 'Beautiful Soul' }}</p>
            </div>
            
            <button onclick="openInvitation()" class="px-10 py-3 accent-bg hover:bg-[#B83280] text-white text-xs uppercase tracking-widest font-bold rounded-full transition-all shadow-md transform hover:scale-105">
                Open Invitation
            </button>
        </div>
    </div>

    <section class="soft-bg min-h-screen flex flex-col items-center justify-center text-center px-6 relative">
        <div class="z-10 py-12 max-w-3xl">
            @if ($invitation->firstPersonPhoto)
                <div class="w-48 h-48 md:w-56 md:h-56 mx-auto overflow-hidden rounded-full border-4 border-white shadow-xl mb-8">
                    <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover">
                </div>
            @endif
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-4 font-semibold">Please join us for a</p>
            <h1 class="heading-font text-6xl md:text-8xl accent-color mb-4 leading-tight">Birthday Party</h1>
            <p class="text-lg text-gray-600 mb-8">Honoring <span class="font-bold text-gray-800">{{ $invitation->profile->first_name }}</span></p>
            
            <div class="inline-block border-t-2 border-b-2 border-pink-300 py-2 px-8">
                <p class="text-sm uppercase tracking-widest font-bold text-gray-700">
                    {{ optional($invitation->event_date)->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 bg-white">
        <div class="max-w-4xl mx-auto text-center mb-16">
            <h2 class="heading-font text-5xl accent-color mb-4">Event Details</h2>
            <div class="w-12 h-1 bg-pink-300 mx-auto rounded-full"></div>
        </div>
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8">
            @foreach ($invitation->events as $event)
                <div class="bg-[#FFF5F7] p-10 text-center rounded-3xl shadow-sm border border-pink-100 hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="heading-font text-4xl accent-color mb-4">{{ $event->name }}</h3>
                    <p class="font-bold text-gray-800 mb-2">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-500 mb-6"><i class="fa-regular fa-clock text-pink-400 mr-2"></i> {{ $event->start_time }} - End</p>
                    <p class="text-sm font-bold text-gray-800 mb-2"><i class="fa-solid fa-location-dot text-pink-400 mr-2"></i> {{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-500 leading-relaxed max-w-xs mx-auto">{{ $event->address }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-[#FFF5F7] py-24 px-6 text-center">
        <h2 class="heading-font text-5xl accent-color mb-12">Gallery</h2>
        <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            @foreach ($invitation->galleries as $gallery)
                <div class="polaroid transform rotate-{{ rand(-3, 3) }} hover:rotate-0 transition-transform duration-300">
                    <img src="{{ asset($gallery->file_path) }}" class="w-full h-48 object-cover mb-3">
                    <p class="heading-font text-xl text-gray-400">{{ $invitation->profile->first_name }}</p>
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
</body>
</html>