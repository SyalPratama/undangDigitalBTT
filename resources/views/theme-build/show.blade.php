<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $invitation->title ?? 'Undangan' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @php
        $design = $invitation->design;
        $headingFont = $design->heading_font ?? 'Playfair Display';
        $bodyFont = $design->body_font ?? 'Montserrat';

        // Ambil data langsung dari model (Pastikan model sudah pakai 'sections' => 'array' cast)
        // Kita gunakan operator ?? [] untuk memastikan selalu array
        $allSections = $design->sections ?? [];

        // Sortir berdasarkan order
        usort($allSections, function ($a, $b) {
            return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
        });

        // Filter hanya yang visible
        $visibleSections = array_filter($allSections, function ($section) {
            return ($section['visible'] ?? true) == true;
        });
    @endphp

    <link
        href="https://fonts.googleapis.com/css2?family={{ urlencode($headingFont) }}&family={{ urlencode($bodyFont) }}&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: {{ $design->primary_color ?? '#000000' }};
            --bg: {{ $design->background_color ?? '#ffffff' }};
            --text: {{ $design->text_color ?? '#333333' }};
            --bg-opacity: {{ ($design->settings['bg_opacity'] ?? 30) / 100 }};
        }

        body {
            color: var(--text);
            font-family: '{{ $bodyFont }}', sans-serif;
        }

        .heading {
            font-family: '{{ $headingFont }}', serif;
        }

        .primary {
            color: var(--primary);
        }

        .bg-primary {
            background: var(--primary);
        }

        @if ($design && $design->background_image)
            .template-background::before {
                content: "";
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background-image: url('{{ asset($design->background_image) }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                z-index: -2;
            }
            .template-background::after {
                content: "";
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background-color: var(--bg);
                opacity: var(--bg-opacity);
                z-index: -1;
            }
        @else
            body {
                background-color: var(--bg);
            }
        @endif

        @media (max-width: 768px) {
            .heading {
                font-size: 2rem !important;
            }
        }
    </style>
</head>

<body class="template-background">

    @if (empty($allSections))
        {{-- Kondisi 1: Database kosong --}}
        <div class="h-screen flex items-center justify-center">
            <div class="text-center p-8 bg-white/80 rounded-2xl shadow-xl backdrop-blur-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-800">Belum ada section</h2>
                <p class="text-slate-600 mt-2">Pilih section di menu builder untuk memulai.</p>
            </div>
        </div>
    @elseif (empty($visibleSections))
        {{-- Kondisi 2: Ada section, tapi semua visible false --}}
        <div class="h-screen flex items-center justify-center">
            <div class="text-center p-8 bg-white/80 rounded-2xl shadow-xl backdrop-blur-sm border border-slate-200">
                <p class="text-slate-600">Semua section saat ini sedang disembunyikan.</p>
            </div>
        </div>
    @else
        {{-- Kondisi 3: Tampilkan section --}}
        @foreach ($visibleSections as $section)
            @if (view()->exists('theme-build.sections.' . $section['type']))
                @include('theme-build.sections.' . $section['type'])
            @endif
        @endforeach
    @endif

</body>

</html>
