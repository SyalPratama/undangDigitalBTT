@php
    $projectData = [];
    if (isset($invitation->builder->project_data)) {
        $raw = $invitation->builder->project_data;
        $projectData = is_string($raw) ? json_decode($raw, true) : (array) $raw;
    }

    $primaryColor = !empty($projectData['primary_color']) ? $projectData['primary_color'] : '#D4AF37';
    
    $profile = $invitation->profile;
    $firstName = $profile->first_name ?? 'NAMA KELUARGA / ANAK';
    $nickname = $profile->first_nickname ?? '';
    $fatherName = $profile->first_father ?? '';
    $motherName = $profile->first_mother ?? '';

    $headline = !empty($profile->headline) ? $profile->headline : 'Syukuran & Doa Bersama';
    $quote = !empty($profile->quote) ? $profile->quote : 'Dengan memanjatkan puji syukur ke hadirat Allah SWT, yang telah melimpahkan rahmat, taufiq, dan hidayah-Nya. Kami bermaksud memohon doa restu Bapak/Ibu/Saudara/i dalam acara syukuran kami.';
    
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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: 'var(--primary-color)',
                        bgdark: '#0A0F1C',
                        bgcard: '#111827',
                        textlight: '#E5E7EB',
                    },
                    fontFamily: {
                        cinzel: ['Cinzel', 'serif'],
                        montserrat: ['Montserrat', 'sans-serif'],
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
            background-color: #0A0F1C;
            color: #E5E7EB;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4af37' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .text-gradient-gold {
            background: linear-gradient(to right, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        .border-gradient-gold {
            position: relative;
            background: #0A0F1C;
            background-clip: padding-box;
            border: 1px solid transparent;
        }
        .border-gradient-gold::before {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            z-index: -1;
            margin: -1px;
            border-radius: inherit;
            background: linear-gradient(to bottom right, #BF953F, transparent, #AA771C);
        }

        .gold-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-color), transparent);
            width: 80%;
            margin: 0 auto;
            opacity: 0.5;
        }

        .gold-divider-vertical {
            width: 1px;
            background: linear-gradient(to bottom, transparent, var(--primary-color), transparent);
            height: 40px;
            margin: 0 auto;
            opacity: 0.5;
        }

        #cover-screen {
            position: fixed; inset: 0; z-index: 9999;
            background-color: #0A0F1C;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: transform 1.5s cubic-bezier(0.65, 0, 0.35, 1);
            background-image: radial-gradient(circle at center, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        }

        .cover-content {
            padding: 3rem 2rem;
            text-align: center;
            max-width: 90%;
            width: 400px;
            animation: zoomIn 2s ease-out;
            position: relative;
        }
        .cover-content::before, .cover-content::after {
            content: ''; position: absolute;
            width: 40px; height: 40px;
            border: 2px solid var(--primary-color);
            opacity: 0.7;
        }
        .cover-content::before { top: 0; left: 0; border-right: none; border-bottom: none; }
        .cover-content::after { bottom: 0; right: 0; border-left: none; border-top: none; }

        @keyframes zoomIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .btn-gold {
            background: transparent;
            color: var(--primary-color);
            padding: 12px 30px;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            letter-spacing: 2px;
            transition: all 0.4s ease;
            border: 1px solid var(--primary-color);
            display: inline-flex; align-items: center; gap: 10px;
            text-transform: uppercase;
            font-size: 0.85rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.1) inset;
        }
        .btn-gold:hover {
            background: var(--primary-color);
            color: #0A0F1C;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
        }

        .countdown-box {
            background: rgba(17, 24, 39, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 15px;
            width: 70px;
            text-align: center;
            position: relative;
            backdrop-filter: blur(5px);
        }
        .countdown-box::before {
            content: ''; position: absolute; top: -1px; left: 50%; transform: translateX(-50%);
            width: 20px; height: 1px; background: var(--primary-color);
        }
        .countdown-box::after {
            content: ''; position: absolute; bottom: -1px; left: 50%; transform: translateX(-50%);
            width: 20px; height: 1px; background: var(--primary-color);
        }

        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 990;
            background: rgba(10, 15, 28, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            display: flex; justify-content: space-around; padding: 12px 0;
            padding-bottom: calc(12px + env(safe-area-inset-bottom));
            transform: translateY(100%); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .bottom-nav.visible { transform: translateY(0); }
        .nav-item {
            color: #6B7280; text-decoration: none;
            display: flex; flex-direction: column; align-items: center; gap: 5px;
            font-size: 0.65rem; font-weight: 500; transition: all 0.3s;
            font-family: 'Cinzel', serif; letter-spacing: 1px;
        }
        .nav-item.active, .nav-item:hover { color: var(--primary-color); text-shadow: 0 0 5px rgba(212, 175, 55, 0.5); }

        #audio-control {
            position: fixed; bottom: 90px; right: 20px; z-index: 995;
            background: rgba(10, 15, 28, 0.8); color: var(--primary-color);
            border: 1px solid var(--primary-color);
            width: 45px; height: 45px; border-radius: 50%;
            display: none; align-items: center; justify-content: center;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2); cursor: pointer;
            transition: all 0.3s;
            backdrop-filter: blur(5px);
        }
        #audio-control:hover { background: var(--primary-color); color: #0A0F1C; }
        #audio-control.visible { display: flex; }
        .spin { animation: spin 4s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #0A0F1C; }
        ::-webkit-scrollbar-thumb { background: rgba(212, 175, 55, 0.3); }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary-color); }

        input, select, textarea {
            background: rgba(255,255,255,0.02) !important;
            border: 1px solid rgba(212, 175, 55, 0.2) !important;
            color: #E5E7EB !important;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--primary-color) !important;
            outline: none !important;
            box-shadow: 0 0 5px rgba(212, 175, 55, 0.3) !important;
        }
        select option { background: #0A0F1C; color: #E5E7EB; }
    </style>
</head>
<body class="antialiased selection:bg-gold selection:text-bgdark pb-24">

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
            <i class="fa-solid fa-star-and-crescent text-3xl text-gold opacity-80 mb-6 text-shadow-md"></i>
            
            <p class="text-gray-400 font-montserrat tracking-[0.3em] uppercase text-xs mb-2">
                Undangan
            </p>
            <h1 data-preview="headline" class="text-xl md:text-2xl font-cinzel text-gradient-gold mb-8 leading-relaxed tracking-widest">
                {{ $headline }}
            </h1>
            
            <h2 data-preview="first_name" class="text-3xl font-cinzel text-white mb-10 leading-snug tracking-wider">
                {{ $firstName }}
            </h2>
            
            <div class="mb-10 text-xs text-gray-400 font-montserrat tracking-widest">
                <p class="mb-3">KEPADA YTH.</p>
                <p class="font-bold text-lg text-gold mt-1">{{ request()->get('to', 'Bapak/Ibu/Saudara/i') }}</p>
            </div>
            
            <button class="btn-gold w-full justify-center" onclick="openInvitation()">
                Buka Undangan
            </button>
        </div>
    </div>

    <main id="main-content" style="display: none; opacity: 0; transition: opacity 2s ease-in-out;">

        <section id="home" class="min-h-screen flex flex-col items-center justify-center p-6 text-center relative pt-12">
            
            <div data-aos="fade-up" data-aos-duration="2000" class="relative z-10 w-full max-w-2xl border-gradient-gold p-8 md:p-12">
                <div class="gold-divider-vertical mb-6"></div>
                
                <h1 data-preview="headline" class="text-xl md:text-2xl font-cinzel text-gradient-gold mb-6 tracking-widest uppercase">
                    {{ $headline }}
                </h1>
                
                <h2 data-preview="first_name" class="text-4xl md:text-5xl font-cinzel text-white mb-4 leading-tight tracking-wider">
                    {{ $firstName }}
                </h2>
                
                @if($nickname)
                <p data-preview="first_nickname" class="font-cinzel text-lg text-gray-400 mt-2 tracking-[0.3em]">
                    {{ $nickname }}
                </p>
                @endif
                
                <div class="gold-divider-vertical mt-8 mb-6"></div>
                
                <p class="text-xs text-gold tracking-[0.2em] uppercase font-montserrat">
                    Memohon Doa Restu
                </p>
            </div>

            @if($invitation->firstPersonPhoto)
            <div class="mt-12 z-10 relative" data-aos="zoom-in" data-aos-duration="2000">
                <div class="relative w-48 h-48 md:w-64 md:h-64 mx-auto rounded-none p-1 border border-gold opacity-80">
                    <img src="{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}" class="w-full h-full object-cover filter grayscale sepia-[0.3]">
                </div>
            </div>
            @endif

            <div class="mt-12 z-10 animate-pulse text-gold opacity-50">
                <p class="text-[10px] tracking-[0.4em] uppercase mb-3 font-cinzel">Scroll</p>
                <i class="fa-solid fa-chevron-down text-sm"></i>
            </div>
        </section>

        <section id="story" class="py-24 px-6 relative">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade-up" data-aos-duration="1500">
                
                <div class="gold-divider mb-12"></div>
                
                <i class="fa-solid fa-book-quran text-4xl text-gold mb-8 opacity-70"></i>
                
                <p data-preview="quote" class="text-gray-300 leading-[2.5] text-sm md:text-base mb-12 font-montserrat font-light tracking-wide px-4">
                    "{{ $quote }}"
                </p>

                @if($fatherName || $motherName)
                <div class="pt-8">
                    <p class="text-[10px] text-gold tracking-[0.3em] uppercase mb-6 font-cinzel">Kami Yang Berbahagia</p>
                    <div class="flex flex-col md:flex-row justify-center items-center gap-6 md:gap-16">
                        @if($fatherName)
                        <div>
                            <p data-preview="first_father" class="text-lg text-white font-cinzel tracking-wider">{{ $fatherName }}</p>
                        </div>
                        @endif
                        @if($fatherName && $motherName)
                        <div class="text-gold font-cinzel text-xl opacity-50">&amp;</div>
                        @endif
                        @if($motherName)
                        <div>
                            <p data-preview="first_mother" class="text-lg text-white font-cinzel tracking-wider">{{ $motherName }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <div class="gold-divider mt-16"></div>
            </div>
        </section>

        <section id="event" class="py-24 px-6 relative">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-[10px] text-gold tracking-[0.3em] uppercase mb-4 font-cinzel">Waktu Pelaksanaan</p>
                <h2 class="text-3xl font-cinzel text-white mb-16 tracking-widest">Rangkaian Acara</h2>

                <div class="flex justify-center gap-4 md:gap-8 mb-24" data-aos="zoom-in" id="countdown-timer" data-date="{{ $countdownDate }}">
                    <div class="countdown-box">
                        <div id="cd-d" class="text-2xl font-light text-white font-cinzel">00</div>
                        <div class="text-[9px] text-gold mt-2 uppercase tracking-widest font-montserrat">Hari</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-h" class="text-2xl font-light text-white font-cinzel">00</div>
                        <div class="text-[9px] text-gold mt-2 uppercase tracking-widest font-montserrat">Jam</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-m" class="text-2xl font-light text-white font-cinzel">00</div>
                        <div class="text-[9px] text-gold mt-2 uppercase tracking-widest font-montserrat">Menit</div>
                    </div>
                    <div class="countdown-box">
                        <div id="cd-s" class="text-2xl font-light text-white font-cinzel">00</div>
                        <div class="text-[9px] text-gold mt-2 uppercase tracking-widest font-montserrat">Detik</div>
                    </div>
                </div>

                <div class="space-y-12">
                    @foreach($invitation->events as $index => $event)
                    <div class="border-gradient-gold p-8 md:p-12 relative overflow-hidden text-center" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        
                        <p class="text-[10px] text-gold tracking-[0.3em] uppercase mb-4 font-cinzel">Sesi {{ $index + 1 }}</p>
                        <h3 class="text-2xl font-cinzel text-white mb-8 tracking-widest">{{ $event->name }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm mb-10 font-montserrat font-light text-gray-300">
                            <div>
                                <i class="fa-regular fa-clock text-gold mb-3 text-xl"></i>
                                <p class="mb-1 text-white font-medium">{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                <p>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB - Selesai</p>
                            </div>
                            <div>
                                <i class="fa-solid fa-location-dot text-gold mb-3 text-xl"></i>
                                <p class="mb-1 text-white font-medium tracking-wide">{{ $event->venue_name }}</p>
                                <p class="text-xs leading-relaxed opacity-80">{{ $event->address }}</p>
                            </div>
                        </div>
                        
                        <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank" class="btn-gold text-xs">
                            Buka Peta Lokasi
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="gallery" class="py-24 px-6 relative bg-bgcard">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-[10px] text-gold tracking-[0.3em] uppercase mb-4 font-cinzel">Memori</p>
                <h2 class="text-3xl font-cinzel text-white mb-16 tracking-widest">Galeri Foto</h2>

                @if($invitation->galleries->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($invitation->galleries as $index => $gallery)
                        <div class="overflow-hidden border border-gray-800 p-2" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                            <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Galeri" class="w-full h-64 object-cover filter grayscale transition duration-700 hover:grayscale-0 hover:scale-105">
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-16 border border-dashed border-gray-800 text-gray-600">
                        <i class="fa-regular fa-image text-4xl mb-4 opacity-50"></i>
                        <p class="font-cinzel text-sm tracking-widest">Belum ada potret.</p>
                    </div>
                @endif
            </div>
        </section>

        <section id="rsvp" class="py-24 px-6 relative">
            <div class="max-w-2xl mx-auto">
                <div class="border-gradient-gold p-8 md:p-12" data-aos="fade-up">
                    <div class="text-center mb-12">
                        <h2 class="text-2xl font-cinzel text-white mb-4 tracking-widest">Reservasi & Doa</h2>
                        <p class="text-gray-400 text-xs font-montserrat font-light tracking-wide leading-relaxed">Merupakan suatu kebahagiaan apabila Bapak/Ibu berkenan mengonfirmasi kehadiran dan memberikan doa restu.</p>
                    </div>

                    <form id="rsvp-form" onsubmit="submitRsvp(event)" class="mb-16 font-montserrat">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-[10px] font-medium text-gold uppercase tracking-[0.2em] mb-3">Nama Lengkap</label>
                            <input type="text" name="name" class="w-full rounded-none px-4 py-3 text-sm" value="{{ request()->get('to') }}" required placeholder="Masukkan Nama Anda">
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-[10px] font-medium text-gold uppercase tracking-[0.2em] mb-3">Kehadiran</label>
                            <select name="attendance" class="w-full rounded-none px-4 py-3 text-sm" required>
                                <option value="" disabled selected>Pilih Status Kehadiran</option>
                                <option value="Hadir">Berkenan Hadir</option>
                                <option value="Tidak Hadir">Mohon Maaf, Belum Bisa Hadir</option>
                            </select>
                        </div>
                        
                        <div class="mb-10">
                            <label class="block text-[10px] font-medium text-gold uppercase tracking-[0.2em] mb-3">Untaian Doa</label>
                            <textarea name="message" class="w-full rounded-none px-4 py-3 text-sm" rows="5" required placeholder="Tuliskan doa dan harapan..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-gold w-full justify-center">
                            Kirim Konfirmasi
                        </button>
                    </form>

                    <div class="border-t border-gray-800 pt-12">
                        <h3 class="font-cinzel text-center text-gold mb-10 tracking-widest text-sm">Buku Tamu</h3>
                        <div class="max-h-80 overflow-y-auto pr-4 space-y-6 scrollbar-thin">
                            @forelse($invitation->wishes ?? [] as $comment)
                                <div class="border-l border-gold pl-4 pb-4">
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="font-cinzel text-white text-sm tracking-wider">{{ $comment->name ?? 'Tamu' }}</p>
                                        @if(isset($comment->created_at))
                                        <span class="text-[10px] text-gray-500 font-montserrat">{{ $comment->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    @if(isset($comment->attendance))
                                    <span class="text-[9px] uppercase tracking-widest font-montserrat {{ $comment->attendance == 'Hadir' ? 'text-gold' : 'text-gray-500' }} block mb-3">
                                        {{ $comment->attendance == 'Hadir' ? '• Akan Hadir' : '• Berhalangan' }}
                                    </span>
                                    @endif
                                    <p class="text-xs text-gray-400 leading-relaxed font-montserrat font-light">"{{ $comment->message ?? '' }}"</p>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 text-xs font-montserrat tracking-widest uppercase">Belum ada catatan kehadiran.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-32 px-6 text-center bg-bgcard relative">
            <div class="max-w-xl mx-auto" data-aos="fade-up">
                <i class="fa-solid fa-hands-praying text-3xl text-gold mb-8 opacity-70"></i>
                <p class="text-gray-400 mb-8 leading-relaxed text-xs font-montserrat font-light tracking-widest uppercase">
                    Terima kasih atas doa restu<br>dan kehadiran Anda.
                </p>
                <h2 class="font-cinzel text-2xl text-white mb-2 tracking-widest">Wassalamu'alaikum</h2>
                <h2 class="font-cinzel text-xl text-gold tracking-widest mb-16">Wr. Wb.</h2>
                
                <h2 data-preview="first_name" class="text-xl font-cinzel text-white tracking-[0.3em] uppercase">
                    {{ $firstName }}
                </h2>
            </div>
        </section>

    </main>

    <nav class="bottom-nav" id="bottom-nav">
        <a href="#home" class="nav-item active">
            <i class="fa-solid fa-home text-base mb-1"></i>
            <span>Beranda</span>
        </a>
        <a href="#story" class="nav-item">
            <i class="fa-solid fa-scroll text-base mb-1"></i>
            <span>Doa</span>
        </a>
        <a href="#event" class="nav-item">
            <i class="fa-regular fa-calendar-alt text-base mb-1"></i>
            <span>Acara</span>
        </a>
        <a href="#gallery" class="nav-item">
            <i class="fa-regular fa-images text-base mb-1"></i>
            <span>Galeri</span>
        </a>
        <a href="#rsvp" class="nav-item">
            <i class="fa-regular fa-envelope text-base mb-1"></i>
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
            
            setTimeout(() => {
                cover.style.display = 'none';
                document.getElementById('main-content').style.display = 'block';
                document.getElementById('bottom-nav').classList.add('visible');
                
                void document.getElementById('main-content').offsetWidth;
                document.getElementById('main-content').style.opacity = '1';
                
                AOS.init({ once: true, offset: 50, duration: 1500, easing: 'ease-out-cubic' });
                
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
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Konfirmasi Terkirim';
                btn.style.background = '#D4AF37';
                btn.style.color = '#0A0F1C';
                e.target.reset();
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = 'transparent';
                    btn.style.color = 'var(--primary-color)';
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
