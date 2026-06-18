@php
    $userPackage = $invitation->user;
    $firstEvent = $invitation->events->first();
    
    // Check if we are rendering only one specific section (from inside template section loop)
    $renderOnlySection = $renderOnly ?? null;

    // Log for debugging
    \Log::info("Univ Sections Rendered", [
        'renderOnly' => $renderOnlySection,
        'has_countdown' => $userPackage->hasFeature('has_event_countdown'),
        'has_maps' => $userPackage->hasFeature('has_google_maps'),
        'has_rsvp' => $userPackage->hasFeature('has_rsvp'),
        'has_comments' => $userPackage->hasFeature('has_guest_comments'),
        'firstEvent' => $firstEvent ? $firstEvent->toArray() : null
    ]);

    // When renderOnly is set, we render just that one section - visibility is already handled by the parent loop
    if($renderOnlySection) {
        $univOrder = [['id' => $renderOnlySection, 'visible' => true]];
    } else {
        // Full mode: Check builder settings for universal sections order
        $builderData = [];
        if(isset($invitation->builder->project_data)) {
            $builderData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
        }
        
        $defaultUnivOrder = [
            ['id' => 'univ_countdown', 'visible' => true],
            ['id' => 'univ_maps', 'visible' => true],
            ['id' => 'univ_rsvp', 'visible' => true],
            ['id' => 'univ_comments', 'visible' => true]
        ];
        
        // Check section_order for univ sections first, fallback to universal_sections_order, then default
        $sectionOrderData = $builderData['section_order'] ?? [];
        $univFromSectionOrder = array_filter($sectionOrderData, function($s) {
            $id = $s['id'] ?? $s['type'] ?? '';
            return str_starts_with($id, 'univ_');
        });
        
        if(!empty($univFromSectionOrder)) {
            $univOrder = array_values($univFromSectionOrder);
        } else {
            $univOrder = $builderData['universal_sections_order'] ?? $defaultUnivOrder;
            if(is_string($univOrder)) {
                $univOrder = json_decode($univOrder, true) ?? $defaultUnivOrder;
            }
        }
    }
@endphp

{{-- CSS Khusus untuk Universal Sections agar tidak bentrok --}}
@if(!isset($hasRenderedUnivCss))
<style>
    .univ-sec {
        /* font-family inherit to match the template */
    }
    .univ-glass {
        background-color: rgba(128, 128, 128, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(128, 128, 128, 0.3);
        border-radius: 1.5rem;
    }
    .univ-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background-color: rgba(128, 128, 128, 0.1);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(128, 128, 128, 0.4);
        border-radius: 0.5rem;
        color: inherit;
        outline: none;
        transition: border-color 0.2s;
    }
    .univ-input:focus {
        border-color: var(--primary-color, var(--primary, currentColor));
    }
    .univ-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background-color: var(--primary-color, var(--primary, currentColor));
        color: var(--bg, #ffffff);
        font-weight: 600;
        border-radius: 9999px; /* fully rounded like theme-build */
        transition: opacity 0.2s;
        cursor: pointer;
        border: none;
    }
    .univ-btn:hover {
        opacity: 0.8;
    }
    /* Tambahan agar warna text dalam button kontras */
    .univ-btn-text {
        color: #ffffff; /* Default putih */
        transition: color 0.3s;
    }
</style>
@php $hasRenderedUnivCss = true; @endphp
@endif

<div class="univ-sec">

@foreach($univOrder as $univSec)
    @php
        // Lewati jika hidden
        if(!isset($univSec['visible']) || !$univSec['visible']) continue;
        
        $secId = $univSec['id'] ?? $univSec['type'] ?? '';
    @endphp

    {{-- SECTION: COUNTDOWN --}}
    @if($secId == 'univ_countdown')
        @if($userPackage && $userPackage->hasFeature('has_event_countdown') && $firstEvent && $firstEvent->event_date)
        <section class="py-16 px-6 border-t border-black/5">
            <div class="max-w-3xl mx-auto text-center">
                <h3 class="heading heading-font fs text-3xl font-bold mb-8 opacity-90">Menuju Hari Bahagia</h3>
                <div class="flex justify-center gap-4 md:gap-8" id="univ-countdown">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center univ-glass text-2xl md:text-3xl font-bold" id="univ-days">00</div>
                        <span class="text-xs opacity-70 mt-2 uppercase tracking-wider">Hari</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center univ-glass text-2xl md:text-3xl font-bold" id="univ-hours">00</div>
                        <span class="text-xs opacity-70 mt-2 uppercase tracking-wider">Jam</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center univ-glass text-2xl md:text-3xl font-bold" id="univ-mins">00</div>
                        <span class="text-xs opacity-70 mt-2 uppercase tracking-wider">Menit</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center univ-glass text-2xl md:text-3xl font-bold" id="univ-secs">00</div>
                        <span class="text-xs opacity-70 mt-2 uppercase tracking-wider">Detik</span>
                    </div>
                </div>
            </div>
        </section>
        <script>
            (function() {
                const eventDateStr = "{{ \Carbon\Carbon::parse($firstEvent->event_date->format('Y-m-d') . ' ' . ($firstEvent->start_time ?? '00:00:00'))->toIso8601String() }}";
                const countDownDate = new Date(eventDateStr).getTime();

                const x = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = countDownDate - now;

                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("univ-countdown").innerHTML = "<div class='text-violet-400 font-bold text-xl'>Acara Sedang Berlangsung / Telah Selesai</div>";
                        return;
                    }

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("univ-days").innerText = days.toString().padStart(2, '0');
                    document.getElementById("univ-hours").innerText = hours.toString().padStart(2, '0');
                    document.getElementById("univ-mins").innerText = minutes.toString().padStart(2, '0');
                    document.getElementById("univ-secs").innerText = seconds.toString().padStart(2, '0');
                }, 1000);
            })();
        </script>
        @else
            <section class="py-16 px-6 border-t border-black/5 flex items-center justify-center">
                <div class="text-center p-6 univ-glass max-w-lg w-full">
                    <i class="fa-solid fa-clock text-3xl opacity-60 mb-3"></i>
                    <h3 class="heading heading-font fs text-lg font-semibold opacity-90">Section Countdown</h3>
                    <p class="text-sm opacity-70 mt-1">Silakan isi data Tanggal Acara terlebih dahulu di form untuk menampilkan Countdown.</p>
                </div>
            </section>
        @endif
    @endif

    {{-- SECTION: GOOGLE MAPS --}}
    {{-- SECTION: GOOGLE MAPS --}}
    @if($secId == 'univ_maps')
        @if($userPackage && $userPackage->hasFeature('has_google_maps') && $firstEvent && $firstEvent->google_maps_url)
        <section class="py-16 px-6 border-t border-black/5">
            <div class="max-w-4xl mx-auto text-center">
                <h3 class="heading heading-font fs text-3xl font-bold mb-4 opacity-90">Lokasi Acara</h3>
                <p class="opacity-70 mb-8">{{ $firstEvent->venue_name ?? 'Lokasi Utama' }}</p>
                
                <div class="univ-glass p-2 md:p-4 mb-6">
                    @php
                        $mapsUrl = $firstEvent->google_maps_url;
                        // Ekstrak src jika input berupa iframe
                        if (strpos($mapsUrl, '<iframe') !== false && preg_match('/src="([^"]+)"/', $mapsUrl, $match)) {
                            $mapsUrl = $match[1];
                        }
                    @endphp
                    <iframe src="{{ $mapsUrl }}" width="100%" height="400" style="border:0; border-radius: 0.5rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                @if($firstEvent->google_maps_url)
                    <a href="{{ strip_tags($firstEvent->google_maps_url) }}" target="_blank" class="univ-btn inline-flex gap-2">
                        <i class="fa-solid fa-map-location-dot mt-1 text-white"></i> <span class="univ-btn-text">Buka di Google Maps</span>
                    </a>
                @endif
            </div>
        </section>
        @else
            <section class="py-16 px-6 border-t border-black/5 flex items-center justify-center">
                <div class="text-center p-6 univ-glass max-w-lg w-full">
                    <i class="fa-solid fa-map-location-dot text-3xl opacity-60 mb-3"></i>
                    <h3 class="heading heading-font fs text-lg font-semibold opacity-90">Section Google Maps</h3>
                    <p class="text-sm opacity-70 mt-1">Silakan isi URL Google Maps pada menu Edit Form untuk menampilkan lokasi Maps.</p>
                </div>
            </section>
        @endif
    @endif

    {{-- SECTION: RSVP --}}
    {{-- SECTION: RSVP --}}
    @if($secId == 'univ_rsvp')
        @if($userPackage && $userPackage->hasFeature('has_rsvp'))
        <section class="py-16 px-6 border-t border-black/5">
            <div class="max-w-3xl mx-auto">
                <h3 class="heading heading-font fs text-3xl font-bold mb-6 text-center opacity-90">RSVP Kehadiran</h3>
                <div class="univ-glass p-6 md:p-8">
                    <p class="opacity-70 mb-6 text-sm text-center">Mohon konfirmasi kehadiran Anda untuk membantu kami mempersiapkan acara dengan sebaik-baiknya.</p>
                    
                    <form id="univ-rsvp-form" class="space-y-4" onsubmit="submitUnivRsvp(event)">
                        <div>
                            <label class="block text-sm opacity-70 mb-1">Nama Lengkap</label>
                            <input type="text" id="univ-rsvp-name" class="univ-input" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm opacity-70 mb-1">Email Aktif</label>
                            <input type="email" id="univ-rsvp-email" class="univ-input" placeholder="Untuk menerima pengingat/lokasi acara">
                        </div>
                        <div>
                            <label class="block text-sm opacity-70 mb-1">Konfirmasi Kehadiran</label>
                            <select id="univ-rsvp-status" class="univ-input" required>
                                <option value="" disabled selected>Pilih status kehadiran</option>
                                <option value="hadir" class="text-black">Hadir</option>
                                <option value="mungkin" class="text-black">Mungkin Hadir</option>
                                <option value="tidak_hadir" class="text-black">Tidak Hadir</option>
                            </select>
                        </div>
                        <button type="submit" class="univ-btn w-full mt-4" id="univ-rsvp-btn">
                            <span class="univ-btn-text">Kirim Konfirmasi</span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
        @else
            <section class="py-16 px-6 border-t border-black/5 flex items-center justify-center">
                <div class="text-center p-6 univ-glass max-w-lg w-full">
                    <i class="fa-solid fa-envelope-open-text text-3xl opacity-60 mb-3"></i>
                    <h3 class="heading heading-font fs text-lg font-semibold opacity-90">Section RSVP</h3>
                    <p class="text-sm opacity-70 mt-1">Paket yang Anda gunakan saat ini tidak mendukung fitur RSVP Kehadiran.</p>
                </div>
            </section>
        @endif
        
        @if(!isset($hasRenderedRsvpJs))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function submitUnivRsvp(e) {
                e.preventDefault();
                const btn = document.getElementById('univ-rsvp-btn');
                btn.innerText = "Mengirim...";
                btn.disabled = true;

                const data = {
                    name: document.getElementById('univ-rsvp-name').value,
                    email: document.getElementById('univ-rsvp-email').value,
                    status: document.getElementById('univ-rsvp-status').value,
                    _token: '{{ csrf_token() }}'
                };

                fetch('{{ route('invitation.rsvp', $invitation->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    btn.innerText = "Kirim Konfirmasi";
                    btn.disabled = false;
                    if(res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            background: '#1e293b',
                            color: '#fff',
                            confirmButtonColor: '#6d28d9'
                        });
                        document.getElementById('univ-rsvp-form').reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message,
                            background: '#1e293b',
                            color: '#fff',
                            confirmButtonColor: '#6d28d9'
                        });
                    }
                })
                .catch(err => {
                    btn.innerText = "Kirim Konfirmasi";
                    btn.disabled = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem.',
                        background: '#1e293b',
                        color: '#fff',
                        confirmButtonColor: '#6d28d9'
                    });
                });
            }
        </script>
        @php $hasRenderedRsvpJs = true; @endphp
        @endif
    @endif

    {{-- SECTION: GUEST COMMENTS --}}
    @if($secId == 'univ_comments')
        @if($userPackage && $userPackage->hasFeature('has_guest_comments'))
        <section class="py-16 px-6 border-t border-black/5">
            <div class="max-w-3xl mx-auto">
                <h3 class="heading heading-font fs text-3xl font-bold mb-6 text-center opacity-90">Ucapan & Doa</h3>
                
                <div class="univ-glass p-6 md:p-8 mb-8">
                    <form id="univ-comment-form" class="space-y-4" onsubmit="submitUnivComment(event)">
                        <div>
                            <label class="block text-sm opacity-70 mb-1">Nama Lengkap</label>
                            <input type="text" id="univ-comment-name" class="univ-input" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm opacity-70 mb-1">Pesan Ucapan & Doa</label>
                            <textarea id="univ-comment-msg" class="univ-input" rows="3" placeholder="Tuliskan harapan dan doa terbaik Anda..." required></textarea>
                        </div>
                        <button type="submit" class="univ-btn w-full mt-4" id="univ-comment-btn">
                            <span class="univ-btn-text">Kirim Ucapan</span>
                        </button>
                    </form>
                </div>

                {{-- LIST COMMENTS --}}
                <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($invitation->comments as $comment)
                        <div class="univ-glass p-4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0" style="background-color: var(--primary-color, var(--primary, currentColor)); color: var(--bg, #fff);">
                                    {{ strtoupper(substr($comment->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold opacity-90 text-sm">{{ $comment->name }}</h4>
                                    <span class="text-[10px] opacity-60">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <p class="text-sm opacity-80 whitespace-pre-line">{{ $comment->message }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8 opacity-70 text-sm">
                            Belum ada ucapan. Jadilah yang pertama memberikan doa terbaik!
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        @if(!isset($hasRenderedCommentJs))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function submitUnivComment(e) {
                e.preventDefault();
                const btn = document.getElementById('univ-comment-btn');
                btn.innerText = "Mengirim...";
                btn.disabled = true;

                const data = {
                    name: document.getElementById('univ-comment-name').value,
                    message: document.getElementById('univ-comment-msg').value,
                    _token: '{{ csrf_token() }}'
                };

                fetch('{{ route('invitation.comment', $invitation->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    btn.innerText = "Kirim Ucapan";
                    btn.disabled = false;
                    if(res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            background: '#1e293b',
                            color: '#fff',
                            confirmButtonColor: '#6d28d9'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message,
                            background: '#1e293b',
                            color: '#fff',
                            confirmButtonColor: '#6d28d9'
                        });
                    }
                })
                .catch(err => {
                    btn.innerText = "Kirim Ucapan";
                    btn.disabled = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem.',
                        background: '#1e293b',
                        color: '#fff',
                        confirmButtonColor: '#6d28d9'
                    });
                });
            }
        </script>
        @php $hasRenderedCommentJs = true; @endphp
        @endif
        @else
            <section class="py-16 px-6 border-t border-black/5 flex items-center justify-center">
                <div class="text-center p-6 univ-glass max-w-lg w-full">
                    <i class="fa-solid fa-comments text-3xl opacity-60 mb-3"></i>
                    <h3 class="heading heading-font fs text-lg font-semibold opacity-90">Section Ucapan & Doa</h3>
                    <p class="text-sm opacity-70 mt-1">Paket yang Anda gunakan saat ini tidak mendukung fitur Ucapan & Doa.</p>
                </div>
            </section>
        @endif
    @endif

@endforeach

</div>

@if(!isset($hasRenderedUnivBtnJs))
<script>
    // Gunakan setInterval agar warna teks tombol selalu update secara realtime
    // ketika pengguna mengganti warna utama (primary color) di builder
    setInterval(function() {
        document.querySelectorAll('.univ-btn').forEach(function(btn) {
            var textSpan = btn.querySelector('.univ-btn-text');
            if(!textSpan) return;
            
            var bg = window.getComputedStyle(btn).backgroundColor;
            var rgb = bg.match(/\d+/g);
            if(rgb && rgb.length >= 3) {
                var luma = 0.2126 * parseInt(rgb[0]) + 0.7152 * parseInt(rgb[1]) + 0.0722 * parseInt(rgb[2]);
                // Jika sangat terang (mendekati putih), ubah ke hitam pekat. Default selalu putih.
                textSpan.style.color = luma > 230 ? '#1e293b' : '#ffffff';
            }
        });
    }, 500); // Cek setiap 500ms
</script>
@php $hasRenderedUnivBtnJs = true; @endphp
@endif
