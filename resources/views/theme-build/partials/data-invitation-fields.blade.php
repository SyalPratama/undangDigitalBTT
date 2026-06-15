@php
    $projectData = [];
    if (isset($invitation) && $invitation->exists && $invitation->builder && $invitation->builder->project_data) {
        $projectData = is_string($invitation->builder->project_data)
            ? json_decode($invitation->builder->project_data, true)
            : $invitation->builder->project_data;
    }

    $showParents = isset($projectData['show_parents'])
        ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN)
        : isset($invitation->profile) &&
            ($invitation->profile->first_father ||
                $invitation->profile->first_mother ||
                $invitation->profile->second_father ||
                $invitation->profile->second_mother);
@endphp

<form id="auto-save-form"
    action="{{ isset($invitation) && $invitation->exists ? route('customer.kelola-undangan.save', $invitation->id) : route('customer.kelola-undangan.save') }}"
    method="POST" enctype="multipart/form-data" class="divide-y divide-slate-100">
    @csrf

    {{-- SECTION 1: INFORMASI UTAMA --}}
    <div class="p-6 space-y-4">
        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center">
            <i class="fa-solid fa-circle-info mr-2 text-sky-500"></i> Informasi Utama
        </h4>

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Undangan</label>
            <input type="text" name="title" id="title"
                value="{{ old('title', $invitation->title ?? 'Undangan Spesial') }}" required oninput="generateSlug()"
                class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Slug URL</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $invitation->slug ?? '') }}"
                    required
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tgl Pelaksanaan</label>
                <input type="datetime-local" name="event_date"
                    value="{{ old('event_date', isset($invitation) && $invitation->event_date ? date('Y-m-d\TH:i', strtotime($invitation->event_date)) : date('Y-m-d\T09:00', strtotime('+1 month'))) }}"
                    required
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tipe Undangan</label>
                <select name="invitation_type_id" id="type-select" required onchange="toggleProfileFields()"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                    <option value="">-- Pilih Tipe --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" data-slug="{{ $type->slug }}"
                            {{ ($invitation->invitation_type_id ?? '') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tema Desain</label>
                <select name="theme_id" id="theme-select" required
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                    <option value="">-- Pilih Tema --</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika publik"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Custom Domain</label>
                <input type="text" name="custom_domain"
                    value="{{ old('custom_domain', $invitation->custom_domain ?? '') }}" placeholder="dinda-raffi.com"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
        </div>
    </div>

    {{-- SECTION 2: PROFIL & TEKS --}}
    <div class="p-6 space-y-4">
        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center">
            <i class="fa-solid fa-user-gear mr-2 text-indigo-500"></i> Pengaturan Konten Profil & Teks
        </h4>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Headline</label>
                <input type="text" name="headline"
                    value="{{ old('headline', optional($invitation->profile)->headline ?? 'The Wedding Of') }}"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Quote Pembuka</label>
                <input type="text" name="quote"
                    value="{{ old('quote', optional($invitation->profile)->quote ?? 'Menuju ikatan halal...') }}"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
        </div>

        {{-- Nama Pasangan --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5" id="label-first-name">Pihak
                    Pertama</label>
                <input type="text" name="first_name" data-preview="first_name"
                    value="{{ old('first_name', optional($invitation->profile)->first_name ?? 'Budi') }}" required
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5" id="label-first-nick">Nama
                    Panggilan</label>
                <input type="text" name="first_nickname"
                    value="{{ old('first_nickname', optional($invitation->profile)->first_nickname ?? 'Budi') }}"
                    required
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
        </div>

        <div id="wrapper-second-party" class="grid grid-cols-2 gap-4 hidden">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Pihak Kedua</label>
                <input type="text" name="second_name" id="second_name" data-preview="second_name"
                    value="{{ old('second_name', optional($invitation->profile)->second_name ?? 'Sita') }}"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Panggilan Kedua</label>
                <input type="text" name="second_nickname" id="second_nickname"
                    value="{{ old('second_nickname', optional($invitation->profile)->second_nickname ?? 'Sita') }}"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
            </div>
        </div>

        {{-- Toggle Orang Tua --}}
        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200 my-2">
            <div>
                <p class="text-xs font-semibold text-slate-700">Tampilkan Nama Orang Tua</p>
                <p class="text-[10px] text-slate-400">Aktifkan untuk menyertakan di undangan.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="builder[show_parents]" value="0">
                <input type="checkbox" name="builder[show_parents]" id="toggle-parents-checkbox" value="1"
                    onchange="toggleParentsForm()" {{ $showParents ? 'checked' : '' }} class="sr-only peer">
                <div
                    class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:bg-emerald-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full">
                </div>
            </label>
        </div>

        <div id="wrapper-parents" class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ $showParents ? '' : 'hidden' }}">
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Orang Tua Pihak
                    Ke-1</span>
                <input type="text" name="first_father" data-preview="first_father"
                    value="{{ old('first_father', optional($invitation->profile)->first_father ?? 'Bapak Ahmad') }}"
                    class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 outline-none">
                <input type="text" name="first_mother" data-preview="first_mother"
                    value="{{ old('first_mother', optional($invitation->profile)->first_mother ?? 'Ibu Ani') }}"
                    class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 outline-none">
            </div>
            <div id="box-parent-2" class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3 hidden">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Orang Tua Pihak
                    Ke-2</span>
                <input type="text" name="second_father" data-preview="second_father"
                    value="{{ old('second_father', optional($invitation->profile)->second_father ?? 'Bapak Jono') }}"
                    class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 outline-none">
                <input type="text" name="second_mother" data-preview="second_mother"
                    value="{{ old('second_mother', optional($invitation->profile)->second_mother ?? 'Ibu Susi') }}"
                    class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 outline-none">
            </div>
        </div>

        {{-- Textareas --}}
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi Tambahan</label>
            <textarea name="description" rows="2"
                class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-sky-500 transition-all">{{ old('description', optional($invitation->profile)->description ?? '') }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Lengkap</label>
            <textarea name="address" rows="2" required
                class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-sky-500 transition-all">{{ old('address', optional($invitation->profile)->address ?? '') }}</textarea>
        </div>
    </div>

    {{-- SECTION 3: RANGKAIAN ACARA (DYNAMIC REPEATER) --}}
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center">
                <i class="fa-solid fa-calendar-days mr-2 text-amber-500"></i> Detail Susunan Acara
            </h4>
            <button type="button" onclick="addEventRow(); triggerAutoSave(true);"
                class="px-2.5 py-1 text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-200 hover:bg-amber-100 rounded-lg transition-all">
                <i class="fa-solid fa-plus"></i> Tambah
            </button>
        </div>
        <div id="events-container" class="space-y-4">
            {{-- Baris dirender via JavaScript --}}
        </div>
    </div>

    {{-- SECTION 4: UPLOAD MEDIA --}}
    <div class="p-6 space-y-5">
        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center mb-2">
            <i class="fa-solid fa-photo-film mr-2 text-rose-400"></i> Unggahan Media
        </h4>

        {{-- UPLOAD MUSIK --}}
        <div class="space-y-2">
            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Musik Latar Belakang
                (Backsound)</label>

            @php
                $activeMusic =
                    isset($invitation) && $invitation->exists
                        ? $invitation->media->where('type', 'music')->first()
                        : null;
            @endphp

            <div
                class="relative group border {{ $activeMusic ? 'border-emerald-300 bg-emerald-50' : 'border-slate-200 bg-slate-50' }} rounded-2xl p-4 flex items-center gap-4 hover:border-sky-400 transition-all">
                <input type="file" id="input-music" name="media_music" accept="audio/mp3,audio/wav"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    title="Pilih file baru untuk mengganti">

                <div
                    class="p-3 {{ $activeMusic ? 'bg-emerald-500' : 'bg-sky-500' }} rounded-xl text-white group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-music text-lg"></i>
                </div>
                <div class="flex-grow">
                    <p class="text-xs font-semibold {{ $activeMusic ? 'text-emerald-700' : 'text-slate-700' }}"
                        id="music-file-name">
                        {{ $activeMusic ? 'Musik Aktif Terpasang' : 'Pilih File Audio Baru' }}
                    </p>
                    <p class="text-2xs {{ $activeMusic ? 'text-emerald-600/70' : 'text-slate-400' }}">
                        {{ $activeMusic ? 'Timpa untuk mengganti.' : 'Format: MP3 atau WAV (Maksimal 15MB)' }}
                    </p>
                </div>
            </div>

            {{-- Mini Player untuk bukti ke User bahwa musik tersimpan --}}
            @if ($activeMusic)
                <div class="mt-2 p-2 bg-white border border-slate-200 rounded-xl shadow-sm flex items-center">
                    <audio controls class="h-8 w-full outline-none">
                        <source src="{{ asset($activeMusic->file_path) }}"
                            type="{{ $activeMusic->mime_type ?? 'audio/mpeg' }}">
                        Browser Anda tidak mendukung elemen audio.
                    </audio>
                </div>
            @endif
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-2">Gambar Cover Utama</label>
            <div id="dropzone-cover"
                class="relative group border-2 border-dashed border-slate-300 rounded-2xl p-2 cursor-pointer bg-slate-50 hover:border-sky-400 hover:bg-sky-50 h-32 flex flex-col items-center justify-center overflow-hidden transition-all">
                <input type="file" id="input-cover" name="media_cover" accept="image/*"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" title="">
                <div id="cover-placeholder"
                    class="text-center pointer-events-none {{ isset($invitation) && $invitation->media->where('type', 'cover')->first() ? 'hidden' : '' }}">
                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400 mb-1"></i>
                    <p class="text-[10px] font-medium text-slate-500">Klik / Drag Foto Sini</p>
                </div>
                <img id="cover-preview-img"
                    src="{{ isset($invitation) && $invitation->media->where('type', 'cover')->first() ? asset($invitation->media->where('type', 'cover')->first()->file_path) : '' }}"
                    class="absolute inset-0 w-full h-full object-cover z-0 {{ isset($invitation) && $invitation->media->where('type', 'cover')->first() ? '' : 'hidden' }}">
            </div>
            <p id="error-cover" class="text-[10px] text-red-500 font-medium hidden mt-1">Hanya bisa pilih 1 foto
                cover!</p>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-2">Album Galeri</label>

            {{-- KOTAK PREVIEW FOTO YANG SUDAH ADA (Bisa Dihapus) --}}
            <div id="gallery-preview-container" class="grid grid-cols-4 gap-2 mb-3">
                @if (isset($invitation) && $invitation->media->where('type', 'gallery')->count() > 0)
                    @foreach ($invitation->media->where('type', 'gallery') as $gal)
                        <div class="relative group rounded-lg overflow-hidden h-16 gallery-item">
                            <img src="{{ asset($gal->file_path) }}"
                                class="w-full h-full object-cover border border-slate-200">
                            <button type="button" onclick="removeGalleryImage('{{ $gal->id }}', this)"
                                class="absolute top-1 right-1 bg-rose-500 text-white w-5 h-5 rounded-full flex items-center justify-center transition-all z-20 shadow-md">
                                <i class="fa-solid fa-xmark text-[10px]"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- KOTAK DROPZONE KHUSUS TAMBAH FOTO BARU --}}
            <div id="dropzone-gallery"
                class="relative group border-2 border-dashed border-slate-300 rounded-2xl p-4 cursor-pointer bg-slate-50 hover:border-sky-400 hover:bg-sky-50 transition-all flex flex-col items-center justify-center min-h-[100px]">
                <input type="file" id="input-gallery" name="media_gallery[]" accept="image/*" multiple
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" title="">
                <i class="fa-solid fa-images text-2xl text-slate-400 mb-1"></i>
                <p class="text-[10px] font-medium text-slate-500">Klik / Drag Foto Baru Kesini</p>
            </div>
        </div>
    </div>

</form>
