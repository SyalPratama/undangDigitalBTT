<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $invitation->title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        :root {
            --bg-color: #0b132b; 
            --bg-secondary: #1c2541; 
            --gold: var(--primary-color, #d4af37); 
            --gold-light: var(--primary-color, #f3e5ab); 
            --text-main: #f8f9fa; 
            --text-muted: #adb5bd; 
            
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Montserrat', sans-serif;
            --font-accent: 'Great Vibes', cursive;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        h1, h2, h3, h4, .font-heading { font-family: var(--font-heading); }
        .font-accent { font-family: var(--font-accent); }
        
        .text-gold { color: var(--gold); }
        .bg-gold { background-color: var(--gold); }
        .border-gold { border-color: var(--gold); }

        #cover-screen {
            position: fixed; inset: 0; z-index: 9999;
            background: var(--bg-color);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            text-align: center;
            transition: transform 1s cubic-bezier(0.77, 0, 0.17, 1), opacity 1s ease-in-out;
            overflow: hidden;
        }
        
        .cover-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            opacity: 0.3; z-index: -1;
            filter: blur(3px) brightness(0.6);
        }

        .cover-content {
            z-index: 10;
            padding: 2rem;
            max-width: 500px;
            background: rgba(11, 19, 43, 0.7);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            animation: fadeIn 2s ease-out;
        }

        .btn-open {
            display: inline-block;
            margin-top: 2rem;
            padding: 12px 36px;
            background: linear-gradient(135deg, #d4af37 0%, #aa8c2c 100%);
            color: #000;
            border: none;
            border-radius: 30px;
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        .btn-open:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.6);
        }

        #audio-control {
            position: fixed; bottom: 80px; right: 20px; z-index: 999;
            width: 45px; height: 45px;
            background: rgba(212, 175, 55, 0.2);
            border: 1px solid var(--gold);
            border-radius: 50%;
            color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; backdrop-filter: blur(5px);
            transition: all 0.3s;
            opacity: 0; visibility: hidden;
        }
        #audio-control.visible { opacity: 1; visibility: visible; }
        .spin { animation: spin 4s linear infinite; }

        .section {
            position: relative;
            min-height: 100vh;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 4rem 1.5rem;
            overflow: hidden;
        }

        .container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center; background-attachment: fixed;
            opacity: 0.25; z-index: 1;
        }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, transparent 0%, var(--bg-color) 100%);
            z-index: 1;
        }

        .countdown-wrapper {
            display: flex; gap: 10px; justify-content: center; margin-top: 2rem;
        }
        .cd-box {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: 8px;
            width: 70px; height: 75px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .cd-num { font-size: 1.8rem; font-weight: 700; color: var(--gold); font-family: var(--font-heading); line-height: 1; }
        .cd-label { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin-top: 4px; }

        .divider {
            display: flex; align-items: center; justify-content: center; gap: 15px;
            margin: 2rem 0; width: 100%;
        }
        .divider-line { height: 1px; background: linear-gradient(90deg, transparent, var(--gold), transparent); flex: 1; }
        .divider-icon { color: var(--gold); font-size: 1.2rem; }

        .glass-card {
            background: rgba(28, 37, 65, 0.6);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 16px;
            padding: 2.5rem 1.5rem;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .glass-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px;
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
            border-radius: 30px;
            font-size: 0.85rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-outline:hover { background: rgba(212, 175, 55, 0.1); transform: translateY(-2px); }

        .btn-solid {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 32px; width: 100%;
            background: var(--gold); color: #000;
            border: none; border-radius: 30px;
            font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;
            cursor: pointer; transition: all 0.3s;
        }
        .btn-solid:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212,175,55,0.3); }

        .swiper-slide { border-radius: 12px; overflow: hidden; position: relative; aspect-ratio: 4/5; }
        .swiper-slide img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
        .swiper-slide:hover img { transform: scale(1.05); }
        .swiper-pagination-bullet { background: var(--text-muted); }
        .swiper-pagination-bullet-active { background: var(--gold); }

        .form-group { margin-bottom: 1.2rem; text-align: left; }
        .form-label { display: block; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: var(--gold); margin-bottom: 8px; }
        .form-control {
            width: 100%; padding: 12px 16px;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: var(--text-main); font-family: var(--font-body);
            transition: all 0.3s;
        }
        .form-control:focus { outline: none; border-color: var(--gold); background: rgba(255,255,255,0.06); }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }

        .comments-list { max-height: 350px; overflow-y: auto; padding-right: 10px; margin-top: 2rem; scrollbar-width: thin; scrollbar-color: var(--gold) transparent; }
        .comments-list::-webkit-scrollbar { width: 4px; }
        .comments-list::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        .comment-item {
            background: rgba(0,0,0,0.2); border-left: 2px solid var(--gold);
            padding: 12px 15px; border-radius: 0 8px 8px 0;
            margin-bottom: 12px; text-align: left;
        }
        .comment-name { font-weight: 600; font-size: 0.9rem; color: var(--gold-light); display: flex; justify-content: space-between; }
        .comment-time { font-size: 0.7rem; color: var(--text-muted); font-weight: 400; }
        .comment-text { font-size: 0.85rem; color: var(--text-main); margin-top: 6px; line-height: 1.5; font-style: italic; }
        .badge-kehadiran { font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; background: rgba(212,175,55,0.2); color: var(--gold); margin-left: 8px; }

        .particles { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 1; pointer-events: none; }
        .particle { position: absolute; background: radial-gradient(circle, rgba(212,175,55,0.8) 0%, rgba(212,175,55,0) 70%); border-radius: 50%; animation: floatUp linear infinite; }

        @keyframes floatUp {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            20% { opacity: 0.6; }
            80% { opacity: 0.6; }
            100% { transform: translateY(-20vh) scale(1); opacity: 0; }
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 15px rgba(212,175,55,0.2); } 50% { box-shadow: 0 0 30px rgba(212,175,55,0.5); } }

        .bottom-nav {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 990;
            background: rgba(11, 19, 43, 0.9); backdrop-filter: blur(10px);
            border-top: 1px solid rgba(212,175,55,0.2);
            display: flex; justify-content: space-around; padding: 10px 0;
            padding-bottom: calc(10px + env(safe-area-inset-bottom));
            transform: translateY(100%); transition: transform 0.5s;
        }
        .bottom-nav.visible { transform: translateY(0); }
        .nav-item {
            color: var(--text-muted); text-decoration: none;
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; transition: color 0.3s;
        }
        .nav-item i { font-size: 1.2rem; margin-bottom: 2px; }
        .nav-item.active, .nav-item:hover { color: var(--gold); }
    </style>
</head>
<body>

    <audio id="bg-music" loop preload="auto">
        @if($invitation->music?->file_path)
            <source src="{{ asset('storage/'.$invitation->music->file_path) }}">
        @endif
    </audio>

    <div class="particles" id="particles-container"></div>

    <div id="audio-control" onclick="toggleAudio()">
        <i class="fa-solid fa-music" id="audio-icon"></i>
    </div>

    <div id="cover-screen">
        @if($invitation->cover?->file_path)
            <div class="cover-bg" style="background-image: url('{{ asset('storage/'.$invitation->cover->file_path) }}')"></div>
        @else
            @if($invitation->galleries->isNotEmpty())
                <div class="cover-bg" style="background-image: url('{{ asset('storage/'.$invitation->galleries->first()->file_path) }}')"></div>
            @endif
        @endif

        <div class="cover-content">
            <p data-preview="headline" style="font-family: var(--font-body); font-size: 0.85rem; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 1rem;">
                {{ $invitation->profile->headline ?? 'Undangan Spesial' }}
            </p>
            <h1 style="font-size: 3rem; line-height: 1.1; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 2px;">
                Reuni Akbar
            </h1>
            <h2 data-preview="first_name" class="font-heading" style="font-size: 1.8rem; font-weight: 400; color: var(--gold-light); margin-bottom: 2rem;">
                {{ $invitation->profile->first_name }}
            </h2>
            
            <div class="divider" style="margin: 1.5rem 0;">
                <div class="divider-line"></div>
                <i class="fa-solid fa-star divider-icon" style="font-size: 0.8rem;"></i>
                <div class="divider-line"></div>
            </div>

            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">Kepada Yth. Bapak/Ibu/Saudara/i</p>
            <h3 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 1.5rem; padding: 10px; background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px dashed rgba(212,175,55,0.4);">
                {{ request()->get('to', 'Tamu Undangan') }}
            </h3>

            <button class="btn-open" onclick="openInvitation()">
                Buka Undangan <i class="fa-solid fa-envelope-open-text" style="margin-left: 8px;"></i>
            </button>
        </div>
    </div>

    <main id="main-content" style="display: none; opacity: 0; transition: opacity 1s;">

        <section id="hero" class="section" style="padding-top: 0;">
            @if($invitation->firstPersonPhoto)
                <div class="hero-bg" style="background-image: url('{{ asset('storage/'.$invitation->firstPersonPhoto->file_path) }}')"></div>
            @endif
            <div class="hero-overlay"></div>
            
            <div class="container" style="text-align: center; margin-top: 10vh;" data-aos="zoom-in" data-aos-duration="1500">
                <p data-preview="headline" style="font-size: 0.9rem; letter-spacing: 4px; text-transform: uppercase; color: var(--gold); margin-bottom: 1.5rem;">
                    {{ $invitation->profile->headline ?? 'Temu Kangen & Malam Keakraban' }}
                </p>
                
                <h1 data-preview="first_name" class="font-heading text-gold" style="font-size: clamp(3rem, 10vw, 5rem); line-height: 1; text-transform: uppercase; margin-bottom: 1rem; text-shadow: 0 5px 15px rgba(0,0,0,0.5);">
                    {{ $invitation->profile->first_name }}
                </h1>
                
                <p data-preview="first_nickname" class="font-accent" style="font-size: 2.5rem; color: var(--text-main); margin-bottom: 2rem;">
                    {{ $invitation->profile->first_nickname ?? '' }}
                </p>

                @if($invitation->events->isNotEmpty())
                    <div style="background: rgba(11,19,43,0.6); padding: 15px 30px; border-radius: 50px; border: 1px solid rgba(212,175,55,0.3); display: inline-block; backdrop-filter: blur(5px);">
                        <p style="font-size: 1.1rem; letter-spacing: 1px; font-weight: 500;">
                            {{ \Carbon\Carbon::parse($invitation->events->first()->event_date)->isoFormat('D MMMM YYYY') }}
                        </p>
                    </div>
                @endif
                
                <div style="margin-top: 4rem; animation: floatUp 2s infinite alternate ease-in-out;">
                    <p style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 10px;">Geser ke bawah</p>
                    <i class="fa-solid fa-chevron-down text-gold" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </section>

        <section id="about" class="section bg-secondary">
            <div class="container" data-aos="fade-up" data-aos-duration="1000">
                <div class="glass-card">
                    <i class="fa-solid fa-quote-left text-gold" style="font-size: 2.5rem; margin-bottom: 1.5rem; opacity: 0.5;"></i>
                    
                    <h2 class="font-heading" style="font-size: 1.8rem; margin-bottom: 1.5rem; color: var(--gold-light);">
                        Sebuah Panggilan untuk Kembali
                    </h2>
                    
                    <p data-preview="quote" style="font-size: 1rem; line-height: 1.8; color: var(--text-muted); margin-bottom: 2rem;">
                        @if($invitation->profile->quote)
                            "{{ $invitation->profile->quote }}"
                        @else
                            "Waktu mungkin telah membawa kita melangkah jauh ke berbagai arah. Namun, kenangan indah masa lalu akan selalu menjadi kompas yang menuntun kita kembali untuk berkumpul bersama. Mari rajut kembali kisah yang sempat tertunda."
                        @endif
                    </p>

                    <div class="divider">
                        <div class="divider-line"></div>
                        <i class="fa-solid fa-handshake-angle divider-icon"></i>
                        <div class="divider-line"></div>
                    </div>

                    <div style="display: flex; justify-content: center; gap: 3rem; margin-top: 2rem;">
                        @if($invitation->profile->first_father)
                        <div style="text-align: center;">
                            <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--gold); margin-bottom: 5px;">Ketua Panitia</p>
                            <p data-preview="first_father" style="font-weight: 600;">{{ $invitation->profile->first_father }}</p>
                        </div>
                        @endif
                        
                        @if($invitation->profile->first_mother)
                        <div style="text-align: center;">
                            <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--gold); margin-bottom: 5px;">Sekretaris</p>
                            <p data-preview="first_mother" style="font-weight: 600;">{{ $invitation->profile->first_mother }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section id="event" class="section">
            <div class="container">
                <div style="text-align: center; margin-bottom: 3rem;" data-aos="fade-down">
                    <h2 class="font-heading text-gold" style="font-size: 2.5rem; text-transform: uppercase; letter-spacing: 2px;">Rangkaian Acara</h2>
                    <p style="color: var(--text-muted); margin-top: 10px;">Momen kebersamaan yang telah dinantikan</p>
                </div>

                @if($invitation->events->isNotEmpty())
                    @php $mainEvent = $invitation->events->first(); @endphp

                    <div style="text-align: center; margin-bottom: 4rem;" data-aos="zoom-in">
                        <p style="font-family: var(--font-accent); font-size: 2rem; color: var(--gold-light); margin-bottom: 1rem;">Menghitung Waktu</p>
                        <div class="countdown-wrapper" id="countdown-timer" data-date="{{ \Carbon\Carbon::parse($mainEvent->event_date)->format('Y-m-d') }}T{{ \Carbon\Carbon::parse($mainEvent->start_time ?? '09:00:00')->format('H:i:s') }}">
                            <div class="cd-box"><span class="cd-num" id="cd-d">00</span><span class="cd-label">Hari</span></div>
                            <div class="cd-box"><span class="cd-num" id="cd-h">00</span><span class="cd-label">Jam</span></div>
                            <div class="cd-box"><span class="cd-num" id="cd-m">00</span><span class="cd-label">Menit</span></div>
                            <div class="cd-box"><span class="cd-num" id="cd-s">00</span><span class="cd-label">Detik</span></div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 2rem;">
                        @foreach($invitation->events as $index => $event)
                        <div class="glass-card" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}" style="padding: 2rem; animation: pulseGlow 6s infinite alternate;">
                            <div style="position: absolute; top: 0; right: 0; background: var(--gold); color: #000; padding: 5px 20px; border-bottom-left-radius: 12px; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">
                                Acara {{ $index + 1 }}
                            </div>
                            
                            <h3 class="font-heading" style="font-size: 1.6rem; color: var(--gold-light); margin-bottom: 1.5rem; text-transform: uppercase;">
                                {{ $event->name }}
                            </h3>
                            
                            <div style="display: grid; grid-template-columns: 1fr; gap: 15px; text-align: left; margin-bottom: 2rem;">
                                <div style="display: flex; align-items: flex-start; gap: 15px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(212,175,55,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fa-regular fa-calendar-check text-gold" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Tanggal</p>
                                        <p style="font-weight: 500; font-size: 1.1rem;">{{ \Carbon\Carbon::parse($event->event_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                    </div>
                                </div>
                                
                                <div style="display: flex; align-items: flex-start; gap: 15px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(212,175,55,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fa-regular fa-clock text-gold" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Waktu</p>
                                        <p style="font-weight: 500; font-size: 1.1rem;">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB - Selesai</p>
                                    </div>
                                </div>
                                
                                <div style="display: flex; align-items: flex-start; gap: 15px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(212,175,55,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fa-solid fa-location-dot text-gold" style="font-size: 1.2rem;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Lokasi</p>
                                        <p style="font-weight: 600; color: var(--gold-light); font-size: 1.1rem;">{{ $event->venue_name }}</p>
                                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-top: 4px; line-height: 1.5;">{{ $event->address }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                                <a href="https://maps.google.com/?q={{ urlencode($event->address) }}" target="_blank" class="btn-solid" style="flex: 1; min-width: 200px;">
                                    <i class="fa-solid fa-map-location-dot"></i> Buka Google Maps
                                </a>
                                <button onclick="addToCalendar('{{ addslashes($event->name) }}', '{{ $event->event_date }}', '{{ $event->start_time }}', '{{ addslashes($event->venue_name) }}')" class="btn-outline" style="flex: 1; justify-content: center; min-width: 200px;">
                                    <i class="fa-regular fa-calendar-plus"></i> Simpan Tanggal
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section id="gallery" class="section bg-secondary">
            <div class="container" style="max-width: 800px;">
                <div style="text-align: center; margin-bottom: 3rem;" data-aos="fade-down">
                    <h2 class="font-heading text-gold" style="font-size: 2.5rem; text-transform: uppercase; letter-spacing: 2px;">Memori Indah</h2>
                    <p style="color: var(--text-muted); margin-top: 10px;">Jejak langkah dan senyum yang tertinggal dalam kenangan</p>
                </div>

                @if($invitation->galleries->isNotEmpty())
                    <div class="swiper gallery-slider" data-aos="zoom-in" data-aos-duration="1200">
                        <div class="swiper-wrapper">
                            @foreach($invitation->galleries as $gallery)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/'.$gallery->file_path) }}" alt="Galeri Reuni">
                                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(11,19,43,0.8), transparent); pointer-events: none;"></div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination" style="bottom: -5px;"></div>
                    </div>
                @else
                    <div class="glass-card" style="text-align: center; padding: 4rem 2rem;">
                        <i class="fa-regular fa-images text-muted" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <p style="color: var(--text-muted);">Belum ada foto kenangan yang ditambahkan.</p>
                    </div>
                @endif
            </div>
        </section>

        <section id="rsvp" class="section">
            <div class="container">
                <div class="glass-card" data-aos="fade-up" style="padding: 3rem 2rem;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <h2 class="font-heading text-gold" style="font-size: 2.2rem; text-transform: uppercase; letter-spacing: 2px;">Konfirmasi Kehadiran</h2>
                        <p style="color: var(--text-muted); margin-top: 10px;">Kehadiran Anda adalah kebahagiaan bagi kami</p>
                    </div>

                    <form id="rsvp-form" onsubmit="submitRsvp(event)">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ request()->get('to') }}" required placeholder="Masukkan nama Anda">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Kehadiran</label>
                            <select name="attendance" class="form-control" required style="appearance: none;">
                                <option value="" disabled selected>Pilih status kehadiran...</option>
                                <option value="Hadir">InsyaAllah Hadir</option>
                                <option value="Tidak Hadir">Maaf, Tidak Bisa Hadir</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Pesan & Kesan</label>
                            <textarea name="message" class="form-control" rows="4" required placeholder="Tulis pesan, kesan, atau doa untuk kebersamaan kita..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn-solid" style="margin-top: 1rem;">
                            Kirim Konfirmasi <i class="fa-solid fa-paper-plane" style="margin-left: 5px;"></i>
                        </button>
                    </form>

                    <div class="divider" style="margin: 3rem 0;">
                        <div class="divider-line"></div>
                        <i class="fa-regular fa-comments divider-icon"></i>
                        <div class="divider-line"></div>
                    </div>

                    <h3 class="font-heading" style="font-size: 1.5rem; text-align: center; margin-bottom: 1.5rem; color: var(--gold-light);">Pesan dari Teman-teman</h3>
                    
                    <div class="comments-list">
                        @forelse($invitation->wishes ?? [] as $comment)
                            <div class="comment-item" data-aos="fade-right" data-aos-offset="0">
                                <div class="comment-name">
                                    <span>
                                        {{ $comment->name ?? 'Tamu' }}
                                        @if(isset($comment->attendance))
                                        <span class="badge-kehadiran" style="background: {{ $comment->attendance == 'Hadir' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(231, 76, 60, 0.2)' }}; color: {{ $comment->attendance == 'Hadir' ? '#2ecc71' : '#e74c3c' }};">
                                            {{ $comment->attendance == 'Hadir' ? '✓ Hadir' : '✗ Tidak Hadir' }}
                                        </span>
                                        @endif
                                    </span>
                                    @if(isset($comment->created_at))
                                    <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                                <p class="comment-text">"{{ $comment->message ?? '' }}"</p>
                            </div>
                        @empty
                            <p style="text-align: center; color: var(--text-muted); font-size: 0.9rem; font-style: italic;">Belum ada pesan. Jadilah yang pertama memberikan pesan!</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section id="closing" class="section bg-secondary" style="min-height: 60vh; padding-bottom: 100px;">
            <div class="container" style="text-align: center;" data-aos="zoom-in">
                <i class="fa-brands fa-envira text-gold" style="font-size: 3rem; margin-bottom: 1.5rem;"></i>
                <h2 class="font-accent" style="font-size: 3.5rem; color: var(--text-main); margin-bottom: 1.5rem; line-height: 1.2;">
                    Terima Kasih
                </h2>
                <p style="font-size: 1rem; line-height: 1.8; color: var(--text-muted); max-width: 450px; margin: 0 auto 2rem;">
                    Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk menyambung kembali tali silaturahmi yang telah terjalin.
                </p>
                <p style="font-family: var(--font-heading); font-size: 1.2rem; color: var(--gold-light); text-transform: uppercase; letter-spacing: 2px;">
                    Panitia Pelaksana<br>Reuni Akbar
                </p>
            </div>
        </section>

    </main>

    <nav class="bottom-nav" id="bottom-nav">
        <a href="#hero" class="nav-item active">
            <i class="fa-solid fa-house"></i>
            <span>Beranda</span>
        </a>
        <a href="#about" class="nav-item">
            <i class="fa-solid fa-users"></i>
            <span>Kisah</span>
        </a>
        <a href="#event" class="nav-item">
            <i class="fa-solid fa-calendar-day"></i>
            <span>Acara</span>
        </a>
        <a href="#gallery" class="nav-item">
            <i class="fa-solid fa-images"></i>
            <span>Galeri</span>
        </a>
        <a href="#rsvp" class="nav-item">
            <i class="fa-solid fa-envelope-open-text"></i>
            <span>RSVP</span>
        </a>
    </nav>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>

        const particleContainer = document.getElementById('particles-container');
        const particleCount = 30;

        for (let i = 0; i < particleCount; i++) {
            createParticle();
        }

        function createParticle() {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            const size = Math.random() * 8 + 2;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            particle.style.left = `${Math.random() * 100}vw`;
            
            const duration = Math.random() * 10 + 10;
            particle.style.animationDuration = `${duration}s`;
            
            particle.style.animationDelay = `${Math.random() * 5}s`;
            
            particleContainer.appendChild(particle);
        }

        function changeCount(d){ guestCount=Math.max(1,Math.min(20,guestCount+d)); document.getElementById('countDisplay').textContent=guestCount; document.getElementById('guestCountInput').value=guestCount; }
        
        function submitRsvp(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
            btn.disabled = true;
            
            setTimeout(() => {
                btn.innerHTML = '<i class="fa-solid fa-check"></i> Berhasil Terkirim';
                btn.style.background = '#2ecc71';
                btn.style.color = 'white';
                e.target.reset();
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.style.color = '';
                    btn.disabled = false;
                }, 3000);
            }, 1500);
        }

        const audio = document.getElementById('bg-music');
        const audioControl = document.getElementById('audio-control');
        const audioIcon = document.getElementById('audio-icon');
        let isPlaying = false;

        function openInvitation() {
            document.getElementById('cover-screen').style.transform = 'translateY(-100vh)';
            document.getElementById('cover-screen').style.opacity = '0';
            
            setTimeout(() => {
                document.getElementById('cover-screen').style.display = 'none';
                document.getElementById('main-content').style.display = 'block';
                document.getElementById('bottom-nav').classList.add('visible');

                void document.getElementById('main-content').offsetWidth;
                document.getElementById('main-content').style.opacity = '1';

                AOS.init({
                    once: true,
                    offset: 50,
                    duration: 1000,
                    easing: 'ease-out-cubic',
                });

                if(audio.querySelector('source').src !== window.location.href) {
                    audio.play().then(() => {
                        isPlaying = true;
                        audioControl.classList.add('visible');
                        audioIcon.classList.add('spin');
                    }).catch(e => console.log("Audio play failed:", e));
                }
            }, 800);
        }

        function toggleAudio() {
            if (isPlaying) {
                audio.pause();
                audioIcon.classList.remove('spin');
                audioIcon.classList.remove('fa-music');
                audioIcon.classList.add('fa-volume-xmark');
            } else {
                audio.play();
                audioIcon.classList.add('spin');
                audioIcon.classList.remove('fa-volume-xmark');
                audioIcon.classList.add('fa-music');
            }
            isPlaying = !isPlaying;
        }

        const swiper = new Swiper('.gallery-slider', {
            effect: 'cards',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        const countdownEl = document.getElementById('countdown-timer');
        if (countdownEl) {
            const targetDate = new Date(countdownEl.dataset.date).getTime();
            
            const timer = setInterval(() => {
                const now = new Date().getTime();
                const distance = targetDate - now;
                
                if (distance < 0) {
                    clearInterval(timer);
                    document.getElementById('cd-d').innerText = '00';
                    document.getElementById('cd-h').innerText = '00';
                    document.getElementById('cd-m').innerText = '00';
                    document.getElementById('cd-s').innerText = '00';
                    return;
                }
                
                document.getElementById('cd-d').innerText = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                document.getElementById('cd-h').innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                document.getElementById('cd-m').innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                document.getElementById('cd-s').innerText = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
            }, 1000);
        }

        function addToCalendar(title, date, time, location) {
            const startStr = date.replace(/-/g, '') + 'T' + time.replace(/:/g, '') + '00';

            let endHour = parseInt(time.split(':')[0]) + 2;
            let endStr = date.replace(/-/g, '') + 'T' + endHour.toString().padStart(2, '0') + time.split(':')[1] + '00';
            
            const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${startStr}/${endStr}&details=${encodeURIComponent('Reuni Akbar')}&location=${encodeURIComponent(location)}`;
            window.open(googleCalendarUrl, '_blank');
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
