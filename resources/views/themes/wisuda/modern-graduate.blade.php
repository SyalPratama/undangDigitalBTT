<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduation | {{ $invitation->profile->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #F8FAFC; color: #334155; }
        .heading-font { font-family: 'Playfair Display', serif; }
        .silver-gradient {
            background: linear-gradient(135deg, #94A3B8, #E2E8F0, #94A3B8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        body.envelope-active { overflow: hidden; }
    </style>
</head>
<body class="antialiased envelope-active selection:bg-slate-300">

    <audio id="weddingMusic" loop><source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg"></audio>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-[#0F172A] transition-all duration-1000">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#334155 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="max-w-xl text-center px-6 z-10 bg-[#1E293B] p-12 rounded-3xl border border-slate-700 shadow-2xl">
            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-graduation-cap text-slate-300 text-2xl"></i>
            </div>
            <p class="tracking-[0.4em] uppercase text-xs text-slate-400 mb-2 font-semibold">You're Invited To</p>
            <h2 class="heading-font text-4xl md:text-5xl text-white mb-8">Graduation Party</h2>
            <div class="bg-[#0F172A] py-4 px-8 rounded-xl border border-slate-800 mb-8">
                <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Proudly Inviting:</p>
                <p class="text-slate-200 font-bold text-lg">{{ request()->get('to') ?? 'Bapak/Ibu/Saudara/i' }}</p>
            </div>
            <button onclick="openInvitation()" class="w-full py-4 bg-slate-200 hover:bg-white text-slate-900 text-xs uppercase tracking-[0.2em] font-extrabold rounded-xl transition-all">
                Open Invitation
            </button>
        </div>
    </div>

    <section class="min-h-screen flex items-center justify-center text-center px-6 relative bg-white">
        <div class="absolute top-0 w-full h-1/2 bg-slate-50 transform -skew-y-6 origin-top-left -z-10"></div>
        <div class="z-10 py-12 max-w-4xl">
            @if ($invitation->firstPersonPhoto)
                <div class="w-48 h-48 mx-auto overflow-hidden rounded-full shadow-lg border-8 border-white mb-8">
                    <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover filter grayscale-[20%]">
                </div>
            @endif
            <p class="text-sm uppercase tracking-[0.3em] font-bold text-slate-400 mb-2">Class of {{ optional($invitation->event_date)->format('Y') }}</p>
            <h1 class="heading-font text-6xl md:text-8xl text-slate-800 mb-4">{{ $invitation->profile->first_name }}</h1>
            <p class="text-lg text-slate-500 mb-10 max-w-xl mx-auto leading-relaxed">
                "{{ $invitation->profile->quote ?? 'Bukan tentang seberapa cepat, tapi tentang seberapa kuat bertahan hingga garis akhir. Terima kasih atas segala dukungannya.' }}"
            </p>
            <div class="inline-block bg-slate-900 text-white py-3 px-10 rounded-full shadow-md">
                <p class="text-sm tracking-widest font-bold uppercase">{{ optional($invitation->event_date)->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 bg-slate-50">
        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-8">
            @foreach ($invitation->events as $event)
                <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-regular fa-calendar-check text-slate-600"></i>
                    </div>
                    <h3 class="heading-font text-3xl text-slate-800 mb-4">{{ $event->name }}</h3>
                    <p class="font-bold text-slate-600 mb-2">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-slate-500 mb-6">{{ $event->start_time }} - Selesai</p>
                    <div class="w-8 h-1 bg-slate-200 mx-auto mb-6"></div>
                    <p class="text-slate-800 font-bold mb-2">{{ $event->venue_name }}</p>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $event->address }}</p>
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