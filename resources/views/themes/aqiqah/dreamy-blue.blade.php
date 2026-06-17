<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aqiqah | {{ $invitation->profile->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;500;700&family=Lora:ital@0;1&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #F0F7FF; }
        .heading-font { font-family: 'Lora', serif; }
        .hero-bg {
            background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(235, 244, 255, 0.9)),
                url('https://www.transparenttextures.com/patterns/clouds.png');
            background-attachment: fixed;
        }
        .arch-card { border-radius: 100px 100px 20px 20px; }
        body.envelope-active { overflow: hidden; }
    </style>
</head>
<body class="text-[#2D3E50] antialiased envelope-active">

    <audio id="weddingMusic" loop>
        <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-8.mp3" type="audio/mpeg">
    </audio>

    <div id="envelopeOverlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-all duration-1000">
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/pinstriped-suit.png');"></div>
        <div class="max-w-xl text-center px-6 z-10">
            <i class="fa-solid fa-baby text-[#7DA0CA] text-4xl mb-6"></i>
            <p class="tracking-[0.3em] uppercase text-xs text-gray-400 mb-2">Undangan Syukuran Aqiqah</p>
            <h2 class="heading-font text-4xl md:text-5xl text-[#3A5A8C] mb-8 italic">
                {{ $invitation->profile->first_name }}
            </h2>
            <div class="bg-[#F8FAFC] border border-[#D1E2FF] py-4 px-10 rounded-2xl shadow-sm mb-10">
                <p class="text-xs text-gray-400 uppercase mb-2">Kepada Yth:</p>
                <p class="text-[#3A5A8C] font-bold text-lg">{{ request()->get('to') ?? 'Tamu Undangan' }}</p>
            </div>
            <button onclick="openInvitation()" class="px-10 py-3.5 bg-[#7DA0CA] hover:bg-[#3A5A8C] text-white text-xs uppercase tracking-widest font-bold rounded-full transition-all shadow-lg transform hover:scale-105">
                Buka Undangan
            </button>
        </div>
    </div>

    <section class="hero-bg min-h-screen flex items-center justify-center text-center px-6 relative overflow-hidden">
        <div class="z-10 py-12">
            <div class="w-16 h-1 bg-[#7DA0CA] mx-auto mb-8 rounded-full"></div>
            <p class="tracking-[0.5em] uppercase text-xs text-gray-500 mb-6">Walimatul Aqiqah</p>
            <h1 class="heading-font text-5xl md:text-7xl text-[#3A5A8C] leading-tight mb-4 italic">
                {{ $invitation->profile->first_name }}
            </h1>
            <p class="text-lg text-[#7DA0CA] font-medium mb-12">Putra tercinta kami</p>
            <div class="inline-block border-2 border-[#D1E2FF] py-3 px-10 rounded-full bg-white/50 backdrop-blur-sm">
                <p class="heading-font text-xl text-[#3A5A8C]">{{ optional($invitation->event_date)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </section>

    <section class="py-24 px-6 bg-white text-center">
        <div class="max-w-2xl mx-auto italic text-gray-500 leading-relaxed">
            <p>"Aqiqah adalah bentuk rasa syukur kami atas amanah yang Allah titipkan. Semoga kelak ia menjadi anak yang sholeh, berbakti kepada orang tua, dan berguna bagi sesama."</p>
        </div>
    </section>

    <section class="py-32 px-6 relative">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col items-center">
                @if ($invitation->firstPersonPhoto)
                    <div class="w-64 h-80 mx-auto overflow-hidden arch-card border-8 border-white shadow-2xl mb-8 transform -rotate-2">
                        <img src="{{ asset('storage/' . $invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover">
                    </div>
                @endif
                <h3 class="heading-font text-4xl text-[#3A5A8C] mb-4 italic">{{ $invitation->profile->first_name }}</h3>
                <p class="text-sm text-gray-400 uppercase tracking-widest mb-2">Putra dari Pasangan</p>
                <p class="text-lg font-bold text-[#2D3E50]">Bpk. {{ $invitation->profile->first_father }} & Ibu {{ $invitation->profile->first_mother }}</p>
            </div>
        </div>
    </section>

    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto grid md:grid-cols-2 gap-8">
            @foreach ($invitation->events as $event)
                <div class="bg-[#F0F7FF] p-10 text-center rounded-[40px] border border-white shadow-sm hover:shadow-xl transition-all">
                    <i class="fa-solid fa-calendar-check text-[#7DA0CA] text-3xl mb-4"></i>
                    <h3 class="heading-font text-2xl text-[#3A5A8C] mb-6 italic">{{ $event->name }}</h3>
                    <p class="font-bold text-[#2D3E50] mb-1">{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('l, d F Y') }}</p>
                    <p class="text-sm text-gray-500 mb-6">{{ $event->start_time }} - Selesai</p>
                    <div class="w-10 h-[1px] bg-[#7DA0CA] mx-auto mb-6"></div>
                    <p class="text-sm font-bold text-[#3A5A8C]">{{ $event->venue_name }}</p>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $event->address }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-white py-32 px-6">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="heading-font text-4xl text-[#3A5A8C] mb-12 italic">Galeri Kecil Kami</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($invitation->galleries as $gallery)
                    <div class="overflow-hidden rounded-3xl group">
                        <img src="{{ asset($gallery->file_path) }}" class="w-full h-64 object-cover transition duration-700 group-hover:scale-110">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="py-20 px-6 bg-[#3A5A8C] text-white text-center">
        <h2 class="heading-font text-4xl mb-6 italic">Terima Kasih</h2>
        <p class="font-light opacity-80 mb-10">Kebahagiaan kami akan lengkap dengan kehadiran Doa Restu Bapak/Ibu/Saudara/i.</p>
        <p class="text-xs uppercase tracking-widest opacity-60">Keluarga Berbahagia</p>
        <p class="font-bold text-xl mt-2">Keluarga Bpk. {{ $invitation->profile->first_father }}</p>
    </footer>

    <script>
        function openInvitation() {
            document.getElementById('envelopeOverlay').style.transform = 'translateY(-100%)';
            document.body.classList.remove('envelope-active');
            document.getElementById('weddingMusic').play();
        }
    </script>

    @include('themes.partials.universal-sections')
</body>
</html>