@php
    $projectData = [];
    if (isset($invitation->builder->project_data)) {
        $raw = $invitation->builder->project_data;
        $projectData = is_string($raw) ? json_decode($raw, true) : (array) $raw;
    }

    $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#E07A5F';
    
    $profile = $invitation->profile;
    $firstName = $profile->first_name ?? 'NAMA';
    $nickname = $profile->first_nickname ?? '';
    $fatherName = $profile->first_father ?? '';
    $motherName = $profile->first_mother ?? '';

    $headline = !empty($profile->headline) ? $profile->headline : 'Reuni Kawan Lama';
    $quote = !empty($profile->quote) ? $profile->quote : 'Mari merajut kembali kisah lama dan menciptakan memori baru bersama.';
    
    $firstEvent = $invitation->events->sortBy('event_date')->first();
    $countdownDate = $firstEvent 
        ? \Carbon\Carbon::parse($firstEvent->event_date)->format('Y-m-d') . 'T' . \Carbon\Carbon::parse($firstEvent->start_time ?? '09:00:00')->format('H:i:s')
        : '2026-12-31T10:00:00';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title ?? 'Undangan Reuni' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Nunito:wght@300;400;600;700&family=Caveat:wght@600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--primary-color)',
                        bgbase: '#F4F1DE',
                        bgcard: '#FEFAE0',
                        textmain: '#3D405B',
                    },
                    fontFamily: {
                        serif: ['Lora', 'serif'],
                        sans: ['Nunito', 'sans-serif'],
                        hand: ['Caveat', 'cursive'],
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary-color: {{ $primaryColor }};
        }

        body {
            background-color: #F4F1DE;
            color: #3D405B;
            font-family: 'Nunito', sans-serif;
            overflow-x: hidden;
            background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png');
        }

        h1, h2, h3, .font-serif {
            font-family: 'Lora', serif;
        }

        .polaroid {
            background: #fff;
            padding: 10px 10px 40px 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #eee;
            transform: rotate(-2deg);
            transition: transform 0.3s;
        }
        .polaroid:nth-child(even) {
            transform: rotate(3deg);
        }
        .polaroid:hover {
            transform: scale(1.05) rotate(0deg);
            z-index: 10;
        }

        #cover-screen {
            position: fixed; inset: 0; z-index: 9999;
            background-color: #F4F1DE;
            background-image: url('https://www.transparenttextures.com/patterns/cream-paper.png');
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: transform 1s ease-in-out, opacity 1s ease;
        }

        .cover-content {
            background: #FEFAE0;
            padding: 2.5rem 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 2px dashed var(--primary-color);
            text-align: center;
            max-width: 90%;
            width: 400px;
            animation: bounceIn 1.5s ease;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.8); opacity: 0; }
            60% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1); }
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(224, 122, 95, 0.3);
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .countdown-box {
            background: #FEFAE0;
            border: 1px solid rgba(61, 64, 91, 0.1);
            border-radius: 12px;
            padding: 15px 10px;
            width: 70px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 990;
            background: #FEFAE0;
            border-top: 1px solid rgba(0,0,0,0.05);
            display: flex; justify-content: space-around; padding: 10px 0;
            padding-bottom: calc(10px + env(safe-area-inset-bottom));
            transform: translateY(100%); transition: transform 0.5s;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
        }
        .bottom-nav.visible { transform: translateY(0); }
        .nav-item {
            color: #adb5bd; text-decoration: none;
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            font-size: 0.7rem; font-weight: 600; transition: color 0.3s;
        }
        .nav-item.active, .nav-item:hover { color: var(--primary-color); }

        #audio-control {
            position: fixed; bottom: 80px; right: 20px; z-index: 995;
            background: var(--primary-color); color: white;
            width: 45px; height: 45px; border-radius: 50%;
            display: none; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); cursor: pointer;
        }
        #audio-control.visible { display: flex; }
        .spin { animation: spin 4s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #FEFAE0; }
        ::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 4px; }
    </style>
</head>
<body class="antialiased selection:bg-primary selection:text-white pb-24">

    <audio id="bg-music" loop preload="auto">
        @if($invitation->music?->file_path)
            <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
        @endif
    </audio>

    <div id="audio-control" onclick="toggleAudio()">
        <i class="fa-solid fa-music" id="audio-icon"></i>
    </div>

    <div id="cover-screen">
        <div class="cover-content">
            <p data-preview="headline" class="text-primary font-bold tracking-widest uppercase text-sm mb-2">
                {{ $headline }}
            </p>
            <h1 class="text-4xl font-serif text-textmain mb-4">
                Undangan
            </h1>
            <h2 data-preview="first_name" class="text-2xl font-serif text-textmain italic mb-6 border-b border-primary pb-4 inline-block">
                {{ $firstName }}
            </h2>
            <div class="mb-6 text-sm text-gray-500">
                <p>Kepada Yth.</p>
                <p class="font-bold text-lg text-textmain mt-1 bg-gray-100 rounded py-2 px-4 mx-auto w-4/5">{{ request()->get('to', 'Tamu Undangan') }}</p>
            </div>
            <button class="btn-primary w-full justify-center" onclick="openInvitation()">
                Buka Undangan <i class="fa-solid fa-envelope-open-text"></i>
            </button>
        </div>
    </div>

    <main id="main-content" style="display: none; opacity: 0; transition: opacity 1s;">

        <section id="home" class="min-h-screen flex flex-col items-center justify-center p-6 text-center relative pt-12">
            
            <div class="absolute top-10 left-[-50px] w-48 h-48 bg-primary opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-20 right-[-50px] w-64 h-64 bg-primary opacity-10 rounded-full blur-2xl"></div>

            <div data-aos="fade-down" data-aos-duration="1500" class="relative z-10">
                <p data-preview="headline" class="text-primary tracking-widest font-bold text-sm uppercase mb-3">{{ $headline }}</p>
                <h1 data-preview="first_name" class="text-5xl md:text-6xl font-serif text-textmain mb-2 leading-tight">
                    {{ $firstName }}
                </h1>
                @if($nickname)
                <p data-preview="first_nickname" class="font-hand text-4xl text-primary mt-2 transform -rotate-2">
                    {{ $nickname }}
                </p>
                @endif
            </div>

            @if($invitation->firstPersonPhoto)
            <div class="mt-10 mb-8 z-10" data-aos="zoom-in" data-aos-duration="1500">
                <div class="polaroid relative mx-auto" style="max-width: 250px;">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" class="w-full h-auto aspect-square object-cover grayscale hover:grayscale-0 transition duration-500">
                    <p class="font-hand text-2xl text-center mt-3 text-gray-700">See you there!</p>
                    <i class="fa-solid fa-thumbtack text-red-400 absolute -top-3 left-1/2 transform -translate-x-1/2 text-xl drop-shadow-md"></i>
                </div>
            </div>
            @endif

            <div class="mt-8 z-10 animate-bounce text-gray-400">
                <i class="fa-solid fa-arrow-down text-xl"></i>
            </div>
        </section>

        <section id="story" class="py-20 px-6 relative">
            <div class="max-w-3xl mx-auto bg-bgcard rounded-3xl p-8 md:p-12 shadow-lg border border-gray-100 relative z-10" data-aos="fade-up">
                <i class="fa-solid fa-quote-left text-4xl text-primary opacity-30 absolute top-6 left-6"></i>
                
                <h2 class="text-2xl font-serif text-center text-textmain mb-6 mt-4">Sebuah Panggilan Memori</h2>
                
                <p data-preview="quote" class="text-center text-gray-600 leading-relaxed italic text-lg mb-8">
                    "{{ $quote }}"
                </p>

                @if($fatherName || $motherName)
                <div class="border-t border-gray-200 pt-6 mt-4 flex justify-center gap-8 text-center">
                    @if($fatherName)
                    <div>
                        <p class="text-xs text-primary font-bold uppercase tracking-wider mb-1">Ketua Panitia</p>
                        <p data-preview="first_father" class="font-bold text-textmain">{{ $fatherName }}</p>
                    </div>
                    @endif
                    @if($motherName)
                    <div>
                        <p class="text-xs text-primary font-bold uppercase tracking-wider mb-1">Sekretaris</p>
                        <p data-preview="first_mother" class="font-bold text-textmain">{{ $motherName }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </section>

        <section id="event" class="py-20 px-6">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-serif text-primary mb-2">Rangkaian Acara</h2>
                <p class="text-gray-500 mb-10">Waktu yang terus berjalan menuju hari H</p>

                <div class="flex justify-center gap-3 md:gap-6 mb-16" data-aos="zoom-in" id="countdown-timer" data-date="{{ $countdownDate }}">
                    <div class="countdown-box">
                        <div id="cd-d" class="text-2xl md:text-3xl font-bold text-textmain font-serif">00</div>
                        <div class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Hari</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-h" class="text-2xl md:text-3xl font-bold text-textmain font-serif">00</div>
                        <div class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Jam</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-m" class="text-2xl md:text-3xl font-bold text-textmain font-serif">00</div>
                        <div class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Menit</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-s" class="text-2xl md:text-3xl font-bold text-textmain font-serif">00</div>
                        <div class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Detik</div>
                    </div>
                </div>

                <div class="space-y-6 text-left">
                    @foreach($invitation->events as $index => $event)
                    <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-primary relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                            Acara {{ $index + 1 }}
                        </div>
                        
                        <h3 class="text-xl font-serif text-textmain mb-4 pr-16">{{ $event->name }}</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-primary shrink-0">
                                    <i class="fa-regular fa-calendar"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Tanggal</p>
                                    <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-primary shrink-0">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Waktu</p>
                                    <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB - Selesai</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-50 flex items-center justify-center text-primary shrink-0">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase tracking-wider">Lokasi</p>
                                    <p class="font-semibold text-textmain">{{ $event->venue_name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ $event->address }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank" class="btn-primary flex-1 justify-center text-sm py-2">
                                <i class="fa-solid fa-map-location-dot"></i> Google Maps
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="gallery" class="py-20 px-6 bg-bgcard border-y border-gray-200">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-serif text-primary mb-2">Album Kenangan</h2>
                <p class="text-gray-500 mb-10">Momen yang tak lekang oleh waktu</p>

                @if($invitation->galleries->isNotEmpty())
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($invitation->galleries as $index => $gallery)
                        <div class="polaroid" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" style="transform: rotate({{ rand(-4, 4) }}deg);">
                            <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Galeri" class="w-full h-auto aspect-square object-cover mb-2 filter sepia-[0.3]">
                            <p class="font-hand text-xl text-gray-600">Memori #{{ $index + 1 }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-10 border-2 border-dashed border-gray-300 rounded-2xl text-gray-400">
                        <i class="fa-regular fa-image text-5xl mb-3"></i>
                        <p>Belum ada foto yang diunggah.</p>
                    </div>
                @endif
            </div>
        </section>

        <section id="rsvp" class="py-20 px-6">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100" data-aos="fade-up">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-serif text-primary mb-2">RSVP & Buku Tamu</h2>
                        <p class="text-gray-500">Konfirmasi kehadiran dan tinggalkan pesan manis</p>
                    </div>

                    <form id="rsvp-form" onsubmit="submitRsvp(event)" class="mb-12">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-textmain mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" value="{{ request()->get('to') }}" required placeholder="Nama Anda">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-textmain mb-2">Kehadiran</label>
                            <select name="attendance" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" required>
                                <option value="" disabled selected>Pilih kehadiran...</option>
                                <option value="Hadir">InsyaAllah Hadir</option>
                                <option value="Tidak Hadir">Maaf, Berhalangan Hadir</option>
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-textmain mb-2">Pesan & Kesan</label>
                            <textarea name="message" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" rows="4" required placeholder="Tulis sesuatu untuk teman-teman..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full justify-center">
                            Kirim Pesan <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>

                    <div class="border-t border-gray-200 pt-8">
                        <h3 class="font-serif text-xl text-center text-textmain mb-6">Pesan Teman-teman</h3>
                        <div class="max-h-80 overflow-y-auto pr-2 space-y-4">
                            @forelse($invitation->wishes ?? [] as $comment)
                                <div class="bg-bgcard p-4 rounded-xl border border-gray-100">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-bold text-textmain">{{ $comment->name ?? 'Tamu' }}</p>
                                            @if(isset($comment->attendance))
                                            <span class="text-[10px] uppercase tracking-wider font-bold px-2 py-1 rounded {{ $comment->attendance == 'Hadir' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $comment->attendance == 'Hadir' ? '✓ Hadir' : '✗ Tidak Hadir' }}
                                            </span>
                                            @endif
                                        </div>
                                        @if(isset($comment->created_at))
                                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed font-hand text-lg mt-2">"{{ $comment->message ?? '' }}"</p>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-400 italic">Belum ada pesan.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-6 text-center bg-textmain text-bgbase relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="relative z-10" data-aos="zoom-in">
                <i class="fa-solid fa-camera-retro text-4xl text-primary mb-6"></i>
                <h2 class="font-serif text-4xl mb-6">Terima Kasih</h2>
                <p class="text-gray-300 max-w-md mx-auto mb-8 leading-relaxed">
                    Kami sangat menantikan kehadiran teman-teman untuk berbagi tawa dan mengenang masa lalu yang indah.
                </p>
                <p class="font-bold text-primary tracking-widest uppercase text-sm">
                    Sampai Jumpa!
                </p>
            </div>
        </section>

    </main>

    <nav class="bottom-nav" id="bottom-nav">
        <a href="#home" class="nav-item active">
            <i class="fa-solid fa-house text-lg"></i>
            <span>Beranda</span>
        </a>
        <a href="#story" class="nav-item">
            <i class="fa-solid fa-book-open text-lg"></i>
            <span>Kisah</span>
        </a>
        <a href="#event" class="nav-item">
            <i class="fa-solid fa-calendar-check text-lg"></i>
            <span>Acara</span>
        </a>
        <a href="#gallery" class="nav-item">
            <i class="fa-solid fa-images text-lg"></i>
            <span>Galeri</span>
        </a>
        <a href="#rsvp" class="nav-item">
            <i class="fa-solid fa-envelope-open-text text-lg"></i>
            <span>RSVP</span>
        </a>
    </nav>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>

        const audio = document.getElementById('bg-music');
        const audioControl = document.getElementById('audio-control');
        const audioIcon = document.getElementById('audio-icon');
        let isPlaying = false;

        function openInvitation() {
            const cover = document.getElementById('cover-screen');
            cover.style.transform = 'translateY(-100vh)';
            cover.style.opacity = '0';
            
            setTimeout(() => {
                cover.style.display = 'none';
                document.getElementById('main-content').style.display = 'block';
                document.getElementById('bottom-nav').classList.add('visible');
                
                void document.getElementById('main-content').offsetWidth;
                document.getElementById('main-content').style.opacity = '1';
                
                AOS.init({ once: true, offset: 50, duration: 1000, easing: 'ease-out-cubic' });
                
                if(audio.querySelector('source') && audio.querySelector('source').src) {
                    audio.play().then(() => {
                        isPlaying = true;
                        audioControl.classList.add('visible');
                        audioIcon.classList.add('spin');
                    }).catch(e => console.log("Audio play failed"));
                }
            }, 800);
        }

        function toggleAudio() {
            if (isPlaying) {
                audio.pause();
                audioIcon.classList.remove('spin', 'fa-music');
                audioIcon.classList.add('fa-volume-xmark');
            } else {
                audio.play();
                audioIcon.classList.add('spin', 'fa-music');
                audioIcon.classList.remove('fa-volume-xmark');
            }
            isPlaying = !isPlaying;
        }

        const countdownEl = document.getElementById('countdown-timer');
        if (countdownEl) {
            const targetDate = new Date(countdownEl.dataset.date).getTime();
            
            const timer = setInterval(() => {
                const now = new Date().getTime();
                const distance = targetDate - now;
                
                if (distance < 0) {
                    clearInterval(timer);
                    ['d','h','m','s'].forEach(id => document.getElementById('cd-'+id).innerText = '00');
                    return;
                }
                
                document.getElementById('cd-d').innerText = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                document.getElementById('cd-h').innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                document.getElementById('cd-m').innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                document.getElementById('cd-s').innerText = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
            }, 1000);
        }

        function submitRsvp(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Berhasil Terkirim';
                btn.classList.replace('bg-primary', 'bg-green-500');
                e.target.reset();
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.replace('bg-green-500', 'bg-primary');
                    btn.disabled = false;
                }, 3000);
            }, 1500);
        }

        const sections = document.querySelectorAll('section');
        const navItems = document.querySelectorAll('.nav-item');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - sectionHeight / 3)) {
                    current = section.getAttribute('id');
                }
            });

            navItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href').includes(current)) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
