@php
    $projectData = [];
    if (isset($invitation->builder->project_data)) {
        $raw = $invitation->builder->project_data;
        $projectData = is_string($raw) ? json_decode($raw, true) : (array) $raw;
    }

    $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#6B8E23';
    
    $profile = $invitation->profile;
    $firstName = $profile->first_name ?? 'NAMA LENGKAP';
    $nickname = $profile->first_nickname ?? '';
    $fatherName = $profile->first_father ?? '';
    $motherName = $profile->first_mother ?? '';

    $headline = !empty($profile->headline) ? $profile->headline : 'Tasyakuran & Doa Bersama';
    $quote = !empty($profile->quote) ? $profile->quote : 'Dan (ingatlah) ketika Tuhanmu memaklumkan: "Sesungguhnya jika kamu bersyukur, niscaya Aku akan menambah (nikmat) kepadamu..." (QS. Ibrahim: 7)';
    
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
    <title>{{ $invitation->title ?? 'Undangan Syukuran' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&family=Great+Vibes&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--primary-color)',
                        bgbase: '#F9FAF8',
                        bgcard: '#FFFFFF',
                        textmain: '#2C3E2D',
                        gold: '#D4AF37'
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['Lato', 'sans-serif'],
                        accent: ['"Great Vibes"', 'cursive'],
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
            background-color: #F9FAF8;
            color: #2C3E2D;
            font-family: 'Lato', sans-serif;
            overflow-x: hidden;
        }

        .leaf-top-left {
            position: absolute; top: -20px; left: -20px;
            width: 250px; opacity: 0.8; z-index: 0; pointer-events: none;
            transform: rotate(15deg);
        }
        .leaf-bottom-right {
            position: absolute; bottom: -20px; right: -20px;
            width: 250px; opacity: 0.8; z-index: 0; pointer-events: none;
            transform: rotate(195deg);
        }

        #cover-screen {
            position: fixed; inset: 0; z-index: 9999;
            background-color: #F9FAF8;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: transform 1.2s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .cover-frame {
            border: 1px solid var(--primary-color);
            padding: 8px;
            border-radius: 20px 100px 20px 100px;
            background: #fff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            text-align: center;
            width: 90%; max-width: 400px;
            position: relative;
            overflow: hidden;
            animation: fadeIn 2s ease;
        }
        
        .cover-content {
            border: 1px solid rgba(107, 142, 35, 0.3);
            border-radius: 12px 92px 12px 92px;
            padding: 3rem 2rem;
            background: #FAFAFA;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 28px;
            border-radius: 30px;
            font-family: 'Lato', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s;
            border: 1px solid var(--primary-color);
            display: inline-flex; align-items: center; gap: 10px;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .btn-primary:hover {
            background-color: white;
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .countdown-box {
            background: white;
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 50%;
            width: 75px; height: 75px;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            position: relative;
        }
        .countdown-box::after {
            content: ''; position: absolute; inset: 3px;
            border: 1px dashed var(--primary-color);
            border-radius: 50%; opacity: 0.5;
        }

        .leaves-container {
            position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
        }
        .falling-leaf {
            position: absolute; top: -10%;
            width: 20px; height: 20px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%236B8E23"><path d="M12,2C12,2 4,6 4,14C4,17.5 6.5,20 10,21L12,23L14,21C17.5,20 20,17.5 20,14C20,6 12,2 12,2M12,19C10,18.5 6,16 6,14C6,9.5 10,6.5 12,4.5C14,6.5 18,9.5 18,14C18,16 14,18.5 12,19Z"/></svg>');
            background-size: cover;
            animation: fall linear infinite;
            opacity: 0.3;
        }
        @keyframes fall {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(100px, 110vh) rotate(360deg); }
        }

        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 990;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0,0,0,0.05);
            display: flex; justify-content: space-around; padding: 12px 0;
            padding-bottom: calc(12px + env(safe-area-inset-bottom));
            transform: translateY(100%); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 -5px 30px rgba(0,0,0,0.05);
        }
        .bottom-nav.visible { transform: translateY(0); }
        .nav-item {
            color: #A0AAB2; text-decoration: none;
            display: flex; flex-direction: column; align-items: center; gap: 5px;
            font-size: 0.65rem; font-weight: 700; transition: color 0.3s;
            text-transform: uppercase; letter-spacing: 1px;
        }
        .nav-item.active, .nav-item:hover { color: var(--primary-color); }

        #audio-control {
            position: fixed; bottom: 90px; right: 20px; z-index: 995;
            background: white; color: var(--primary-color);
            border: 1px solid var(--primary-color);
            width: 45px; height: 45px; border-radius: 50%;
            display: none; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); cursor: pointer;
            transition: all 0.3s;
        }
        #audio-control:hover { background: var(--primary-color); color: white; }
        #audio-control.visible { display: flex; }
        .spin { animation: spin 4s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #F9FAF8; }
        ::-webkit-scrollbar-thumb { background: rgba(107, 142, 35, 0.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary-color); }

        .botanical-divider {
            display: block; width: 120px; height: 30px; margin: 0 auto;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20" fill="none" stroke="%236B8E23" stroke-width="1"><path d="M0,10 Q25,0 50,10 T100,10 M50,10 C45,5 55,5 50,0 M45,15 C40,10 50,10 50,10 M55,15 C60,10 50,10 50,10"/></svg>');
            background-repeat: no-repeat; background-position: center;
        }
    </style>
</head>
<body class="antialiased selection:bg-primary selection:text-white pb-24">

    <div class="leaves-container" id="leaves-container"></div>

    <audio id="bg-music" loop preload="auto">
        @if($invitation->music?->file_path)
            <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
        @endif
    </audio>

    <div id="audio-control" onclick="toggleAudio()">
        <i class="fa-solid fa-music" id="audio-icon"></i>
    </div>

    <div id="cover-screen">
        <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' fill='%236B8E23' opacity='0.1'><path d='M0,0 Q50,0 100,50 Q100,100 50,100 Q0,100 0,50 Z'/></svg>" class="leaf-top-left" alt="leaf">
        
        <div class="cover-frame">
            <div class="cover-content">
                <i class="fa-solid fa-dove text-3xl text-primary opacity-60 mb-6"></i>
                
                <p data-preview="headline" class="text-primary font-bold tracking-[0.2em] uppercase text-xs mb-4">
                    {{ $headline }}
                </p>
                <h1 class="text-3xl font-serif text-textmain mb-6 leading-tight border-b border-gray-200 pb-6">
                    Undangan
                </h1>
                <h2 data-preview="first_name" class="text-2xl font-serif text-primary mb-8 leading-snug">
                    {{ $firstName }}
                </h2>
                
                <div class="mb-8 text-sm text-gray-500">
                    <p class="mb-2 italic">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                    <p class="font-bold text-lg text-textmain mt-1">{{ request()->get('to', 'Tamu Undangan') }}</p>
                </div>
                
                <button class="btn-primary w-full justify-center" onclick="openInvitation()">
                    <i class="fa-solid fa-envelope-open-text"></i> Buka Undangan
                </button>
            </div>
        </div>
        
        <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' fill='%236B8E23' opacity='0.1'><path d='M0,0 Q50,0 100,50 Q100,100 50,100 Q0,100 0,50 Z'/></svg>" class="leaf-bottom-right" alt="leaf">
    </div>

    <main id="main-content" style="display: none; opacity: 0; transition: opacity 1.5s ease-in-out;">

        <section id="home" class="min-h-screen flex flex-col items-center justify-center p-6 text-center relative pt-12 overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary opacity-5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary opacity-5 rounded-full blur-3xl"></div>

            <div data-aos="fade-down" data-aos-duration="1500" class="relative z-10 w-full max-w-2xl">
                <i class="fa-solid fa-leaf text-2xl text-primary opacity-50 mb-6"></i>
                <p data-preview="headline" class="text-primary tracking-[0.3em] font-bold text-xs uppercase mb-4">{{ $headline }}</p>
                
                <h1 data-preview="first_name" class="text-4xl md:text-5xl font-serif text-textmain mb-4 leading-tight">
                    {{ $firstName }}
                </h1>
                
                @if($nickname)
                <p data-preview="first_nickname" class="font-accent text-3xl text-primary mt-2">
                    {{ $nickname }}
                </p>
                @endif
                
                <div class="botanical-divider my-8"></div>
            </div>

            @if($invitation->firstPersonPhoto)
            <div class="mt-4 mb-8 z-10 relative" data-aos="zoom-in" data-aos-duration="1500">
                <div class="relative w-48 h-48 md:w-64 md:h-64 mx-auto rounded-full p-2 border-2 border-dashed border-primary">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" class="w-full h-full rounded-full object-cover">
                </div>
            </div>
            @endif

            <div class="mt-8 z-10 animate-pulse text-primary opacity-60">
                <p class="text-xs tracking-widest uppercase mb-2">Geser ke atas</p>
                <i class="fa-solid fa-chevron-down text-lg"></i>
            </div>
        </section>

        <section id="story" class="py-24 px-6 relative bg-white">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
                
                <p class="text-sm font-bold text-primary tracking-widest uppercase mb-6">Ayat Suci & Doa</p>
                <h2 class="text-3xl font-serif text-textmain mb-10">Maha Suci Allah</h2>
                
                <div class="bg-bgbase p-8 md:p-12 rounded-[2rem] border border-gray-100 relative">
                    <i class="fa-solid fa-quote-left text-4xl text-primary opacity-10 absolute top-6 left-6"></i>
                    <i class="fa-solid fa-quote-right text-4xl text-primary opacity-10 absolute bottom-6 right-6"></i>
                    
                    <p data-preview="quote" class="text-gray-600 leading-loose italic text-lg mb-8 font-serif">
                        "{{ $quote }}"
                    </p>

                    @if($fatherName || $motherName)
                    <div class="border-t border-gray-200 pt-8 mt-4">
                        <p class="text-sm text-gray-500 mb-4">Atas Berkat & Rahmat-Nya, Kami yang berbahagia:</p>
                        <div class="flex flex-col md:flex-row justify-center gap-4 md:gap-12">
                            @if($fatherName)
                            <div>
                                <p data-preview="first_father" class="font-bold text-lg text-textmain font-serif">{{ $fatherName }}</p>
                            </div>
                            @endif
                            @if($fatherName && $motherName)
                            <div class="hidden md:block text-primary font-accent text-2xl">&amp;</div>
                            @endif
                            @if($motherName)
                            <div>
                                <p data-preview="first_mother" class="font-bold text-lg text-textmain font-serif">{{ $motherName }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="botanical-divider mt-12"></div>
            </div>
        </section>

        <section id="event" class="py-24 px-6 relative bg-bgbase">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-sm font-bold text-primary tracking-widest uppercase mb-4">Informasi</p>
                <h2 class="text-3xl font-serif text-textmain mb-4">Pelaksanaan Acara</h2>
                <p class="text-gray-500 mb-12">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir pada waktu:</p>

                <div class="flex justify-center gap-3 md:gap-5 mb-16" data-aos="zoom-in" id="countdown-timer" data-date="{{ $countdownDate }}">
                    <div class="countdown-box">
                        <div id="cd-d" class="text-2xl font-bold text-primary font-serif">00</div>
                        <div class="text-[0.6rem] text-gray-500 mt-1 uppercase tracking-widest font-bold">Hari</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-h" class="text-2xl font-bold text-primary font-serif">00</div>
                        <div class="text-[0.6rem] text-gray-500 mt-1 uppercase tracking-widest font-bold">Jam</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-m" class="text-2xl font-bold text-primary font-serif">00</div>
                        <div class="text-[0.6rem] text-gray-500 mt-1 uppercase tracking-widest font-bold">Menit</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-s" class="text-2xl font-bold text-primary font-serif">00</div>
                        <div class="text-[0.6rem] text-gray-500 mt-1 uppercase tracking-widest font-bold">Detik</div>
                    </div>
                </div>

                <div class="space-y-8">
                    @foreach($invitation->events as $index => $event)
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 relative overflow-hidden text-center" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        
                        <div class="w-12 h-12 bg-bgbase rounded-full flex items-center justify-center text-primary text-xl mx-auto mb-4 border border-gray-100">
                            <i class="fa-solid {{ $index == 0 ? 'fa-pray' : 'fa-utensils' }}"></i>
                        </div>
                        
                        <h3 class="text-2xl font-serif text-textmain mb-6">{{ $event->name }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-8 border-t border-b border-gray-50 py-6">
                            <div>
                                <p class="text-xs text-primary uppercase tracking-widest font-bold mb-2">Waktu</p>
                                <p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                <p class="text-gray-500 mt-1">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB - Selesai</p>
                            </div>
                            <div>
                                <p class="text-xs text-primary uppercase tracking-widest font-bold mb-2">Lokasi</p>
                                <p class="font-bold text-gray-700">{{ $event->venue_name }}</p>
                                <p class="text-gray-500 mt-1">{{ $event->address }}</p>
                            </div>
                        </div>
                        
                        <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank" class="btn-primary">
                            <i class="fa-solid fa-map-location-dot"></i> Buka Google Maps
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="gallery" class="py-24 px-6 bg-white">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-sm font-bold text-primary tracking-widest uppercase mb-4">Galeri</p>
                <h2 class="text-3xl font-serif text-textmain mb-12">Momen Berharga</h2>

                @if($invitation->galleries->isNotEmpty())
                    <div class="columns-2 md:columns-3 gap-4 space-y-4">
                        @foreach($invitation->galleries as $index => $gallery)
                        <div class="break-inside-avoid rounded-xl overflow-hidden shadow-sm" data-aos="zoom-in" data-aos-delay="{{ ($index % 3) * 100 }}">
                            <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Galeri" class="w-full h-auto object-cover transition duration-500 hover:scale-110">
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 border border-dashed border-gray-200 rounded-[2rem] text-gray-400 bg-bgbase">
                        <i class="fa-regular fa-image text-4xl mb-4 text-primary opacity-50"></i>
                        <p class="font-serif">Belum ada foto yang diunggah.</p>
                    </div>
                @endif
                
                <div class="botanical-divider mt-16"></div>
            </div>
        </section>

        <section id="rsvp" class="py-24 px-6 bg-bgbase">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-[2rem] p-8 md:p-12 shadow-sm border border-gray-100" data-aos="fade-up">
                    <div class="text-center mb-10">
                        <i class="fa-regular fa-envelope text-3xl text-primary opacity-50 mb-4"></i>
                        <h2 class="text-3xl font-serif text-textmain mb-2">Buku Tamu & RSVP</h2>
                        <p class="text-gray-500 text-sm">Konfirmasi kehadiran dan tinggalkan doa restu.</p>
                    </div>

                    <form id="rsvp-form" onsubmit="submitRsvp(event)" class="mb-12">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full bg-bgbase border-none rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-primary transition" value="{{ request()->get('to') }}" required placeholder="Tulis nama Anda">
                        </div>
                        
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">Konfirmasi Kehadiran</label>
                            <select name="attendance" class="w-full bg-bgbase border-none rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-primary transition" required>
                                <option value="" disabled selected>Apakah Anda akan hadir?</option>
                                <option value="Hadir">Ya, InsyaAllah Hadir</option>
                                <option value="Tidak Hadir">Maaf, Berhalangan Hadir</option>
                            </select>
                        </div>
                        
                        <div class="mb-8">
                            <label class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">Doa & Harapan</label>
                            <textarea name="message" class="w-full bg-bgbase border-none rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-primary transition" rows="4" required placeholder="Tuliskan doa terbaik..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-primary w-full justify-center">
                            Kirim Doa Restu <i class="fa-regular fa-paper-plane"></i>
                        </button>
                    </form>

                    <div class="border-t border-gray-100 pt-10">
                        <h3 class="font-serif text-lg text-textmain mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-comments text-primary"></i> Doa Teman-teman
                        </h3>
                        <div class="max-h-80 overflow-y-auto pr-2 space-y-4">
                            @forelse($invitation->wishes ?? [] as $comment)
                                <div class="p-4 rounded-xl border border-gray-50 bg-bgbase">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="font-bold text-textmain text-sm">{{ $comment->name ?? 'Tamu' }}</p>
                                            @if(isset($comment->attendance))
                                            <span class="text-[9px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-full {{ $comment->attendance == 'Hadir' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-500' }} mt-1 inline-block">
                                                {{ $comment->attendance == 'Hadir' ? '✓ Hadir' : '✗ Tidak Hadir' }}
                                            </span>
                                            @endif
                                        </div>
                                        @if(isset($comment->created_at))
                                        <span class="text-[10px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed mt-2 font-serif italic">"{{ $comment->message ?? '' }}"</p>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400 text-sm">Belum ada doa yang dikirimkan.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-6 text-center bg-white">
            <div class="max-w-xl mx-auto" data-aos="zoom-in">
                <div class="botanical-divider mb-8"></div>
                <h2 class="font-serif text-3xl text-textmain mb-6">Wassalamu'alaikum <br> Warahmatullahi Wabarakatuh</h2>
                <p class="text-gray-500 mb-8 leading-relaxed text-sm">
                    Kehadiran serta doa restu Bapak/Ibu/Saudara/i merupakan suatu kehormatan dan kebahagiaan bagi kami.
                </p>
                <p class="font-bold text-primary tracking-widest uppercase text-xs">
                    Terima Kasih
                </p>
                
                <h2 data-preview="first_name" class="text-2xl font-serif text-textmain mt-8 pt-8 border-t border-gray-100">
                    {{ $firstName }}
                </h2>
            </div>
        </section>

    </main>

    <nav class="bottom-nav" id="bottom-nav">
        <a href="#home" class="nav-item active">
            <i class="fa-solid fa-leaf text-lg mb-1"></i>
            <span>Beranda</span>
        </a>
        <a href="#story" class="nav-item">
            <i class="fa-solid fa-hands-praying text-lg mb-1"></i>
            <span>Ayat</span>
        </a>
        <a href="#event" class="nav-item">
            <i class="fa-regular fa-calendar-check text-lg mb-1"></i>
            <span>Acara</span>
        </a>
        <a href="#gallery" class="nav-item">
            <i class="fa-regular fa-images text-lg mb-1"></i>
            <span>Galeri</span>
        </a>
        <a href="#rsvp" class="nav-item">
            <i class="fa-regular fa-envelope text-lg mb-1"></i>
            <span>RSVP</span>
        </a>
    </nav>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>

        function createLeaf() {
            const leaf = document.createElement('div');
            leaf.classList.add('falling-leaf');
            leaf.style.left = Math.random() * 100 + 'vw';
            leaf.style.animationDuration = Math.random() * 5 + 10 + 's';
            leaf.style.animationDelay = Math.random() * 5 + 's';

            document.getElementById('leaves-container').appendChild(leaf);

            setTimeout(() => {
                leaf.remove();
            }, 15000);
        }

        setInterval(createLeaf, 2000);

        for(let i=0; i<5; i++) { setTimeout(createLeaf, i*500); }

        const audio = document.getElementById('bg-music');
        const audioControl = document.getElementById('audio-control');
        const audioIcon = document.getElementById('audio-icon');
        let isPlaying = false;

        function openInvitation() {
            const cover = document.getElementById('cover-screen');

            cover.style.transform = 'translateY(-100vh)';
            
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
            }, 1000);
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
                btn.style.backgroundColor = '#10B981';
                btn.style.borderColor = '#10B981';
                e.target.reset();
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.backgroundColor = '';
                    btn.style.borderColor = '';
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
