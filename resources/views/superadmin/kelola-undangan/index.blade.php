@extends('layouts.superadmin')

@section('title', 'Kelola Undangan')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6" x-data="{ openDetail: false, selectedData: {} }">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">Kelola Undangan</h1>
            
            <a href="{{ route('superadmin.kelola-undangan.create') }}" class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-2.5 rounded-full font-medium text-[14px] transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah Undangan Baru
            </a>
        </div>

        <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">

            {{-- Filter & Search --}}
            <div class="flex flex-col md:flex-row gap-3 mb-6 max-w-2xl">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="search-input" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan judul atau slug..."
                        class="w-full border border-slate-200 focus:border-sky-500/70 rounded-xl pl-10 pr-12 py-2.5 text-sm focus:outline-hidden bg-slate-50/50 focus:bg-white transition-all">

                    <div id="search-loading"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none hidden">
                        <svg class="animate-spin h-4 w-4 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>

                <div class="w-full md:w-56">
                    <select id="filter-type"
                        class="w-full border border-slate-200 focus:border-sky-500/70 rounded-xl px-3 py-2.5 text-sm focus:outline-hidden bg-slate-50/50 focus:bg-white transition-all cursor-pointer">
                        <option value="">Semua Tipe Undangan</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto transition-all duration-300" id="table-container">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider font-semibold">
                            <th class="pb-3 font-medium">Judul & Profil Acara</th>
                            <th class="pb-3 font-medium">Tipe / Tema</th>
                            <th class="pb-3 font-medium">Lampiran Data</th>
                            <th class="pb-3 font-medium">Pembuat / User</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-600 divide-y divide-slate-50">
                        @forelse($invitations as $invitation)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                {{-- Kolom 1: Judul dan Data dari InvitationProfile --}}
                                <td class="py-4">
                                    <span class="font-semibold text-slate-800 block">{{ $invitation->title }}</span>
                                    <span
                                        class="text-xs text-slate-400 font-mono block mb-1">/{{ $invitation->slug }}</span>

                                    @if ($invitation->profile)
                                        <div
                                            class="inline-flex flex-col gap-0.5 bg-slate-50 border border-slate-100 rounded-lg p-2 mt-1 max-w-xs">
                                            <span class="text-[11px] font-medium text-slate-500 uppercase tracking-tight">
                                                {{ in_array(Str::slug($invitation->type->slug ?? ''), ['engagement', 'wedding']) ? 'Pasangan:' : 'Pemilik:' }}
                                            </span>

                                            <span class="text-xs text-slate-700 font-medium">
                                                {{ $invitation->profile->first_nickname ?? ($invitation->profile->first_name ?? '?') }}

                                                {{-- Cek apakah tipe acara adalah pernikahan atau tunangan --}}
                                                @if (in_array(Str::slug($invitation->type->slug ?? ''), ['engagement', 'wedding']))
                                                    &
                                                    {{ $invitation->profile->second_nickname ?? ($invitation->profile->second_name ?? '?') }}
                                                @endif
                                            </span>

                                            @if ($invitation->profile->address)
                                                <span class="text-[11px] text-slate-400 truncate"
                                                    title="{{ $invitation->profile->address }}">
                                                    <i
                                                        class="fa-solid fa-location-dot text-[10px] mr-0.5"></i>{{ $invitation->profile->address }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-amber-500 italic block mt-1">
                                            <i class="fa-solid fa-triangle-exclamation mr-1"></i>Profil belum diisi
                                        </span>
                                    @endif
                                </td>

                                {{-- Kolom 2: Tipe & Tema --}}
                                <td class="py-4 align-top">
                                    <span
                                        class="block text-slate-700 font-medium mt-0.5">{{ $invitation->type->name ?? '-' }}</span>
                                    <span class="text-xs text-slate-400 block">Tema:
                                        {{ $invitation->theme->name ?? '-' }}</span>
                                </td>

                                {{-- Kolom 3: Lampiran Relasi (Events & Media) --}}
                                <td class="py-4 align-top">
                                    <div class="flex flex-col gap-1.5 mt-0.5">
                                        {{-- Jumlah Rangkaian Acara (Events) --}}
                                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-600">
                                            <i class="fa-solid fa-calendar-day text-slate-400 w-4"></i>
                                            {{ $invitation->events->count() ?? 0 }} Acara
                                        </span>

                                        {{-- Jumlah File Media --}}
                                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-600">
                                            <i class="fa-solid fa-images text-slate-400 w-4"></i>
                                            {{ $invitation->media->count() ?? 0 }} Media/Gallery
                                        </span>
                                    </div>
                                </td>

                                {{-- Kolom 4: Pembuat --}}
                                <td class="py-4 align-top">
                                    <span class="block text-slate-700 mt-0.5">{{ $invitation->user->name ?? '-' }}</span>
                                    <span
                                        class="text-[11px] text-slate-400 block">{{ $invitation->user->email ?? '' }}</span>
                                </td>

                                {{-- Kolom 5: Status --}}
                                <td class="py-4 align-top">
                                    <div class="mt-0.5">
                                        @if ($invitation->is_active)
                                            <span
                                                class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/40 text-[11px] font-semibold rounded-lg inline-block">AKTIF</span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200/40 text-[11px] font-semibold rounded-lg inline-block">NON-AKTIF</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom 6: Aksi --}}
                                <td class="py-4 text-right space-x-1 whitespace-nowrap align-top">
                                    <div class="mt-0.5">
                                        {{-- BUTTON DETAIL MODAL --}}
                                        <button type="button" onclick="showDetailModal(this)"
                                            data-title="{{ $invitation->title }}" data-slug="{{ $invitation->slug }}"
                                            data-type="{{ $invitation->type->name ?? '-' }}"
                                            data-type-slug="{{ Str::slug($invitation->type->name ?? '') }}"
                                            data-theme="{{ $invitation->theme->name ?? '-' }}"
                                            data-user-name="{{ $invitation->user->name ?? '-' }}"
                                            data-user-email="{{ $invitation->user->email ?? '-' }}"
                                            data-status="{{ $invitation->is_active ? 'AKTIF' : 'NON-AKTIF' }}"
                                            data-p1-name="{{ $invitation->profile->first_name ?? '-' }}"
                                            data-p1-nick="{{ $invitation->profile->first_nickname ?? '-' }}"
                                            data-p1-father="{{ $invitation->profile->first_father ?? '-' }}"
                                            data-p1-mother="{{ $invitation->profile->first_mother ?? '-' }}"
                                            data-p2-name="{{ $invitation->profile->second_name ?? '-' }}"
                                            data-p2-nick="{{ $invitation->profile->second_nickname ?? '-' }}"
                                            data-p2-father="{{ $invitation->profile->second_father ?? '-' }}"
                                            data-p2-mother="{{ $invitation->profile->second_mother ?? '-' }}"
                                            data-address="{{ $invitation->profile->address ?? 'Belum mengisi alamat' }}"
                                            data-events-count="{{ $invitation->events->count() ?? 0 }}"
                                            data-media-count="{{ $invitation->media->count() ?? 0 }}"
                                            class="inline-flex items-center justify-center w-8 h-8 text-slate-600 bg-slate-100 hover:bg-slate-200 border border-slate-200/30 rounded-xl transition-all cursor-pointer"
                                            title="Lihat Detail">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </button>

                                        <a href="{{ route('superadmin.kelola-undangan.edit', $invitation->id) }}"
                                            class="inline-flex items-center justify-center w-8 h-8 text-sky-600 bg-sky-50 hover:bg-sky-100/80 border border-sky-200/30 rounded-xl transition-all"
                                            title="Edit Undangan">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <button
                                            onclick="handleDelete('{{ $invitation->id }}', '{{ $invitation->title }}')"
                                            class="inline-flex items-center justify-center w-8 h-8 text-rose-600 bg-rose-50 hover:bg-rose-100/80 border border-rose-200/30 rounded-xl transition-all cursor-pointer"
                                            title="Hapus Undangan">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 text-sm">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fa-solid fa-envelope-open-text text-2xl text-slate-300"></i>
                                        <span>Data undangan tidak ditemukan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($invitations, 'links'))
                <div class="mt-6 border-t border-slate-50 pt-4">
                    {{ $invitations->appends(request()->query())->links() }}
                </div>
            @endif

        </div>

        {{-- COMPONENT MODAL DETAIL UNDANGAN --}}
        <div id="detail-modal"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 hidden animate-fade-in">
            <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs transition-opacity" onclick="closeDetailModal()">
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-2xl max-h-[90vh] overflow-y-auto z-10 transform scale-95 opacity-0 transition-all duration-300 ease-out"
                id="modal-card">

                <div
                    class="flex items-center justify-between border-b border-slate-100 px-6 py-4 sticky top-0 bg-white/90 backdrop-blur-md z-20">
                    <div>
                        <h4 class="text-base font-bold text-slate-800">Detail Lengkap Undangan</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Informasi entitas, relasi, dan konfigurasi tema.</p>
                    </div>
                    <button onclick="closeDetailModal()"
                        class="w-8 h-8 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200/40 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-all cursor-pointer">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                            <h5 class="text-lg font-bold text-slate-900" id="md-title">-</h5>
                            <span id="md-status" class="px-2 py-0.5 text-[10px] font-bold rounded-md"></span>
                        </div>
                        <p class="text-sm font-mono text-sky-600 bg-sky-50/50 border border-sky-100 inline-block px-2.5 py-1 rounded-lg"
                            id="md-slug">-</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-slate-50/60 rounded-xl p-3.5 border border-slate-100">
                            <span class="text-[11px] font-medium text-slate-400 block uppercase tracking-wider mb-1">Tipe
                                Undangan</span>
                            <span class="text-sm font-semibold text-slate-700" id="md-type">-</span>
                        </div>
                        <div class="bg-slate-50/60 rounded-xl p-3.5 border border-slate-100">
                            <span class="text-[11px] font-medium text-slate-400 block uppercase tracking-wider mb-1">Tema
                                yang Digunakan</span>
                            <span class="text-sm font-semibold text-slate-700" id="md-theme">-</span>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div>
                        <h6
                            class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-heart text-rose-400 text-2xs"></i> Profil Pasangan / Pemilik
                        </h6>
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50/30 border border-slate-100 rounded-xl p-4">
                            {{-- Pihak Pertama --}}
                            <div>
                                <span class="text-[11px] text-slate-400 block">Pihak Pertama (Nama / Nick):</span>
                                <span class="text-sm font-medium text-slate-800 block mt-0.5" id="md-p1-name">-</span>
                                <span class="text-xs text-slate-500 font-mono" id="md-p1-nick">-</span>
                            </div>
                            {{-- Pihak Kedua --}}
                            <div class="border-t sm:border-t-0 sm:border-l border-slate-100 pt-3 sm:pt-0 sm:pl-4">
                                <span class="text-[11px] text-slate-400 block">Pihak Kedua (Nama / Nick):</span>
                                <span class="text-sm font-medium text-slate-800 block mt-0.5" id="md-p2-name">-</span>
                                <span class="text-xs text-slate-500 font-mono" id="md-p2-nick">-</span>
                            </div>

                            {{-- Baris Khusus Orang Tua (Hanya tampil jika Pernikahan) --}}
                            <div id="wedding-parents-section"
                                class="col-span-1 sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-slate-100 pt-3 hidden">
                                <div class="bg-slate-50/80 p-3 rounded-xl border border-slate-100/50">
                                    <span
                                        class="text-[11px] font-semibold text-slate-400 uppercase tracking-tight block mb-1">Orang
                                        Tua Pihak ke-1:</span>
                                    <div class="text-xs text-slate-600 space-y-0.5">
                                        <p><span class="text-slate-400">Ayah:</span> <span id="md-p1-father"
                                                class="font-medium text-slate-700">-</span></p>
                                        <p><span class="text-slate-400">Ibu:</span> <span id="md-p1-mother"
                                                class="font-medium text-slate-700">-</span></p>
                                    </div>
                                </div>
                                <div class="bg-slate-50/80 p-3 rounded-xl border border-slate-100/50">
                                    <span
                                        class="text-[11px] font-semibold text-slate-400 uppercase tracking-tight block mb-1">Orang
                                        Tua Pihak ke-2:</span>
                                    <div class="text-xs text-slate-600 space-y-0.5">
                                        <p><span class="text-slate-400">Ayah:</span> <span id="md-p2-father"
                                                class="font-medium text-slate-700">-</span></p>
                                        <p><span class="text-slate-400">Ibu:</span> <span id="md-p2-mother"
                                                class="font-medium text-slate-700">-</span></p>
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="col-span-1 sm:col-span-2 border-t border-slate-100 pt-3">
                                <span class="text-[11px] text-slate-400 block"><i
                                        class="fa-solid fa-location-dot mr-1"></i>Alamat Utama:</span>
                                <p class="text-xs text-slate-600 mt-1" id="md-address">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                        <div>
                            <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Pembuat
                            </h6>
                            <div class="space-y-1">
                                <span class="text-sm font-medium text-slate-700 block" id="md-user-name">-</span>
                                <span class="text-xs text-slate-400 block" id="md-user-email">-</span>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Lampiran Saat Ini
                            </h6>
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex items-center gap-2 text-xs text-slate-600 bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-xl">
                                    <i class="fa-solid fa-calendar-day text-slate-400"></i>
                                    <span id="md-events-count">0</span> Acara
                                </div>
                                <div
                                    class="flex items-center gap-2 text-xs text-slate-600 bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-xl">
                                    <i class="fa-solid fa-images text-slate-400"></i>
                                    <span id="md-media-count">0</span> Media
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 px-6 py-4 flex justify-end bg-slate-50/50 rounded-b-2xl">
                    <button type="button" onclick="closeDetailModal()"
                        class="bg-slate-200 text-slate-700 hover:bg-slate-300 px-4 py-2 rounded-xl text-sm font-medium transition-all cursor-pointer">
                        Tutup Detail
                    </button>
                </div>
            </div>
        </div>

    </div>

    <form id="global-delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // FUNGSI MANAJEMEN MODAL DETAIL (NATIVE JS OPTIMIZED)
        function showDetailModal(button) {
            const modal = document.getElementById('detail-modal');
            const card = document.getElementById('modal-card');

            // Map data dasar
            document.getElementById('md-title').innerText = button.getAttribute('data-title');
            document.getElementById('md-slug').innerText = '/' + button.getAttribute('data-slug');
            document.getElementById('md-type').innerText = button.getAttribute('data-type');
            document.getElementById('md-theme').innerText = button.getAttribute('data-theme');
            document.getElementById('md-user-name').innerText = button.getAttribute('data-user-name');
            document.getElementById('md-user-email').innerText = button.getAttribute('data-user-email');
            document.getElementById('md-p1-name').innerText = button.getAttribute('data-p1-name');
            document.getElementById('md-p1-nick').innerText = button.getAttribute('data-p1-nick') !== '-' ?
                `(${button.getAttribute('data-p1-nick')})` : '-';
            document.getElementById('md-p2-name').innerText = button.getAttribute('data-p2-name');
            document.getElementById('md-p2-nick').innerText = button.getAttribute('data-p2-nick') !== '-' ?
                `(${button.getAttribute('data-p2-nick')})` : '-';
            document.getElementById('md-address').innerText = button.getAttribute('data-address');
            document.getElementById('md-events-count').innerText = button.getAttribute('data-events-count');
            document.getElementById('md-media-count').innerText = button.getAttribute('data-media-count');

            // Map data orang tua
            document.getElementById('md-p1-father').innerText = button.getAttribute('data-p1-father');
            document.getElementById('md-p1-mother').innerText = button.getAttribute('data-p1-mother');
            document.getElementById('md-p2-father').innerText = button.getAttribute('data-p2-father');
            document.getElementById('md-p2-mother').innerText = button.getAttribute('data-p2-mother');

            // Kondisi pengecekan tipe pernikahan (menggunakan slug string biar aman dari typo huruf besar/kecil)
            const typeSlug = button.getAttribute('data-type-slug');
            const parentsSection = document.getElementById('wedding-parents-section');

            if (typeSlug.includes('pernikahan') || typeSlug.includes('wedding')) {
                parentsSection.classList.remove('hidden');
            } else {
                parentsSection.classList.add('hidden');
            }

            // Handling Status Style
            const status = button.getAttribute('data-status');
            const statusEl = document.getElementById('md-status');
            statusEl.innerText = status;
            if (status === 'AKTIF') {
                statusEl.className =
                    "px-2.5 py-0.5 text-[10px] font-bold rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200/50";
            } else {
                statusEl.className =
                    "px-2.5 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-600 border border-slate-200/50";
            }

            // Tampilkan Modal dengan Animasi
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDetailModal() {
            const modal = document.getElementById('detail-modal');
            const card = document.getElementById('modal-card');

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 250);
        }

        // Script filter, search, & delete bawaan Anda tetap aman di bawah ini
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const filterType = document.getElementById('filter-type');
            const searchLoading = document.getElementById('search-loading');
            const tableContainer = document.getElementById('table-container');
            let debounceTimer;

            function applyFilters() {
                searchLoading.classList.remove('hidden');
                tableContainer.classList.add('opacity-40', 'blur-[1px]');
                const url = new URL(window.location.href);

                if (searchInput.value.trim() !== "") {
                    url.searchParams.set('search', searchInput.value.trim());
                } else {
                    url.searchParams.delete('search');
                }

                if (filterType.value !== "") {
                    url.searchParams.set('type', filterType.value);
                } else {
                    url.searchParams.delete('type');
                }

                url.searchParams.delete('page');
                window.location.href = url.toString();
            }

            filterType.addEventListener('change', applyFilters);
            searchInput.addEventListener('input', function() {
                searchLoading.classList.remove('hidden');
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(applyFilters, 550);
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        @endif

        function handleDelete(id, title) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus undangan "${title}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 font-medium text-sm',
                    cancelButton: 'rounded-xl px-4 py-2 font-medium text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('global-delete-form');
                    form.action = `/superadmin/kelola-undangan/${id}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
