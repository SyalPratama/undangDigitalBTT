@extends('layouts.reseller')

@section('title', isset($invitation) ? 'Edit Undangan' : 'Tambah Undangan')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">

            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-800">
                    {{ $invitation->exists ? 'Edit Undangan Digital' : 'Tambah Undangan Baru' }}
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">
                    {{ $invitation->exists ? 'Perbarui data entri undangan digital beserta seluruh rangkaian acaranya.' : 'Buat entri data undangan digital baru beserta rangkaian acaranya ke dalam sistem.' }}
                </p>
            </div>

            <form
                action="{{ isset($invitation->id) ? route('reseller.kelola-undangan.save', $invitation->id) : route('reseller.kelola-undangan.save') }}"
                method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- SECTION 1: DATA UTAMA UNDANGAN --}}
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-2">
                        <i class="fa-solid fa-circle-info mr-1.5 text-sky-500"></i> Informasi Utama
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Judul
                                Undangan</label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $invitation->title ?? '') }}" required oninput="generateSlug()"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                            @error('title')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Slug
                                URL</label>
                            <input type="text" name="slug" id="slug"
                                value="{{ old('slug', $invitation->slug ?? '') }}" required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                            @error('slug')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tipe
                                Undangan</label>
                            <select name="invitation_type_id" id="invitation_type_id" required
                                onchange="toggleProfileFields()"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-hidden transition-all">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" data-slug="{{ Str::slug($type->name) }}"
                                        {{ old('invitation_type_id', $invitation->invitation_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('invitation_type_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tema
                                Undangan</label>
                            <select name="theme_id" required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-hidden transition-all">
                                <option value="">-- Pilih Tema --</option>
                                @foreach ($themes as $theme)
                                    <option value="{{ $theme->id }}"
                                        {{ old('theme_id', $invitation->theme_id ?? '') == $theme->id ? 'selected' : '' }}>
                                        {{ $theme->name }}</option>
                                @endforeach
                            </select>
                            @error('theme_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tanggal
                                Utama Pelaksanaan</label>
                            <input type="datetime-local" name="event_date"
                                value="{{ old('event_date', isset($invitation) ? date('Y-m-d\TH:i', strtotime($invitation->event_date)) : '') }}"
                                required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Password
                                Undangan (Opsional)</label>
                            <input type="password" name="password"
                                placeholder="{{ isset($invitation) ? 'Isi jika ingin mengganti password lama' : 'Kosongkan jika ingin bisa diakses publik' }}"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Custom
                                Domain (Opsional)</label>
                            <input type="text" name="custom_domain"
                                value="{{ old('custom_domain', $invitation->custom_domain ?? '') }}"
                                placeholder="contoh: dinda-raffi.com"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: DATA RELASI PROFILE --}}
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-2">
                        <i class="fa-solid fa-user-gear mr-1.5 text-indigo-500"></i> Pengaturan Konten Profil & Teks
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Headline
                                (Judul Pengantar)</label>
                            <input type="text" name="headline"
                                value="{{ old('headline', $invitation->profile->headline ?? '') }}"
                                placeholder="Contoh: The Wedding Of"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kutipan
                                / Quote Pembuka</label>
                            <input type="text" name="quote"
                                value="{{ old('quote', $invitation->profile->quote ?? '') }}"
                                placeholder="Contoh: Menuju Ikatan Halal..."
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label id="label-first-name"
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Pihak
                                Pertama / Pemilik</label>
                            <input type="text" name="first_name"
                                value="{{ old('first_name', $invitation->profile->first_name ?? '') }}" required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                        <div>
                            <label id="label-first-nick"
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                                Panggilan Pihak Pertama</label>
                            <input type="text" name="first_nickname"
                                value="{{ old('first_nickname', $invitation->profile->first_nickname ?? '') }}" required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                    </div>

                    <div id="wrapper-second-party" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                                Pihak Kedua</label>
                            <input type="text" name="second_name" id="second_name"
                                value="{{ old('second_name', $invitation->profile->second_name ?? '') }}"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                                Panggilan Pihak Kedua</label>
                            <input type="text" name="second_nickname" id="second_nickname"
                                value="{{ old('second_nickname', $invitation->profile->second_nickname ?? '') }}"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                    </div>

                    @php
                        // Deteksi otomatis jika data orang tua terisi untuk mencentang toggle secara default
                        $hasParentsData =
                            isset($invitation->profile) &&
                            ($invitation->profile->first_father ||
                                $invitation->profile->first_mother ||
                                $invitation->profile->second_father ||
                                $invitation->profile->second_mother);
                    @endphp

                    <div id="wrapper-toggle-parents"
                        class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-700">Tampilkan Informasi Orang Tua</span>
                            <span class="text-2xs text-slate-400">Aktifkan jika ingin menyertakan nama orang tua dalam
                                undangan.</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer select-none">
                            <input type="checkbox" id="toggle-parents-checkbox" onchange="toggleParentsForm()"
                                {{ $hasParentsData ? 'checked' : '' }} class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500">
                            </div>
                        </label>
                    </div>

                    <div id="wrapper-parents" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                        <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-3">
                            <span id="label-parent-1"
                                class="text-[11px] font-bold text-slate-400 uppercase block tracking-wider">Orang Tua Pihak
                                ke-1</span>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ayah</label>
                                <input type="text" name="first_father" id="first_father"
                                    value="{{ old('first_father', $invitation->profile->first_father ?? '') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ibu</label>
                                <input type="text" name="first_mother" id="first_mother"
                                    value="{{ old('first_mother', $invitation->profile->first_mother ?? '') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                        </div>

                        <div id="box-parent-2" class="p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-3">
                            <span class="text-[11px] font-bold text-slate-400 uppercase block tracking-wider">Orang Tua
                                Pihak ke-2</span>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ayah</label>
                                <input type="text" name="second_father" id="second_father"
                                    value="{{ old('second_father', $invitation->profile->second_father ?? '') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ibu</label>
                                <input type="text" name="second_mother" id="second_mother"
                                    value="{{ old('second_mother', $invitation->profile->second_mother ?? '') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Deskripsi
                            Tambahan Acara</label>
                        <textarea name="description" rows="2"
                            placeholder="Catatan tambahan mengenai dresscode, protokol kesehatan, dll..."
                            class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">{{ old('description', $invitation->profile->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Alamat
                            Utama Pelaksanaan</label>
                        <textarea name="address" rows="2" placeholder="Contoh: Jl. Diponegoro No. 24, Bandung" required
                            class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">{{ old('address', $invitation->profile->address ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Teks
                            Kalimat Penutup</label>
                        <textarea name="closing_text" rows="2"
                            placeholder="Contoh: Merupakan suatu kehormatan dan kebahagiaan bagi kami..."
                            class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">{{ old('closing_text', $invitation->profile->closing_text ?? '') }}</textarea>
                    </div>
                </div>

                {{-- SECTION 3: RANGKAIAN ACARA (DYNAMIC REPEATER) --}}
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <i class="fa-solid fa-calendar-days mr-1.5 text-amber-500"></i> Detail Susunan Acara / Event
                        </h4>
                        <button type="button" onclick="addEventRow()"
                            class="px-3 py-1.5 text-2xs font-semibold text-white bg-amber-500 hover:bg-amber-600 rounded-lg shadow-xs transition-all">
                            <i class="fa-solid fa-plus mr-1"></i> Tambah Acara
                        </button>
                    </div>

                    {{-- Container Baris Acara --}}
                    <div id="events-container" class="space-y-4">
                        {{-- Baris dirender via JavaScript agar sinkron saat edit data --}}
                    </div>
                </div>

                {{-- SECTION 4: UPLOAD MEDIA (COVER & GALERI) --}}
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-2">
                        <i class="fa-solid fa-images mr-1.5 text-emerald-500"></i> Lampiran Gambar & Galeri Media
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Gambar
                                Sampul / Cover Utama (Maksimal 1 Gambar)</label>

                            @if (isset($invitation) && $invitation->media->where('type', 'cover')->first())
                                <div
                                    class="mb-2 p-2 border border-slate-100 rounded-xl flex items-center gap-3 bg-slate-50">
                                    <img src="{{ asset($invitation->media->where('type', 'cover')->first()->file_path) }}"
                                        class="w-16 h-16 object-cover rounded-lg border">
                                    <span class="text-2xs text-slate-400">File cover saat ini aktif. Upload baru jika ingin
                                        mengganti.</span>
                                </div>
                            @endif

                            <div
                                class="border-2 border-dashed border-slate-200 hover:border-sky-400 rounded-2xl p-6 text-center cursor-pointer bg-slate-50/50 transition-all relative">
                                <input type="file" name="media_cover" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="space-y-1">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400"></i>
                                    <p class="text-xs font-medium text-slate-700">Pilih Foto Cover Baru</p>
                                    <p class="text-2xs text-slate-400">Format: JPG, PNG, WEBP hingga 2MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Foto Album
                                Galeri (Bisa Banyak Gambar)</label>

                            @if (isset($invitation) && $invitation->media->where('type', 'gallery')->count() > 0)
                                <div
                                    class="grid grid-cols-4 gap-2 mb-2 p-2 border border-slate-100 rounded-xl bg-slate-50">
                                    @foreach ($invitation->media->where('type', 'gallery') as $gal)
                                        <div class="relative group">
                                            <img src="{{ asset($gal->file_path) }}"
                                                class="w-full h-12 object-cover rounded-md border">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div
                                class="border-2 border-dashed border-slate-200 hover:border-sky-400 rounded-2xl p-6 text-center cursor-pointer bg-slate-50/50 transition-all relative">
                                <input type="file" name="media_gallery[]" accept="image/*" multiple
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="space-y-1">
                                    <i class="fa-solid fa-images text-2xl text-slate-400"></i>
                                    <p class="text-xs font-medium text-slate-700">Pilih Banyak Foto Tambahan</p>
                                    <p class="text-2xs text-slate-400">Format: JPG, PNG, WEBP</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-slate-50">
                    <a href="{{ route('reseller.kelola-undangan.index') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Batal</a>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 rounded-xl shadow-sm transition-all">
                        {{ isset($invitation) ? 'Perbarui Undangan' : 'Simpan Undangan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let eventIndex = 0;

        // Penanganan data awal untuk mode edit menggunakan data blade json encode
        const existingEvents = @json(isset($invitation) ? $invitation->events->toArray() : []);

        document.addEventListener("DOMContentLoaded", function() {
            if (existingEvents.length > 0) {
                existingEvents.forEach(event => {
                    addEventRow(event);
                });
            } else {
                addEventRow(); // Render satu baris kosong jika mode create
            }
            toggleProfileFields();
            toggleParentsForm();
        });

        function generateSlug() {
            const title = document.getElementById('title').value;
            document.getElementById('slug').value = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-');
        }

        function addEventRow(data = null) {
            const container = document.getElementById('events-container');
            const newRow = document.createElement('div');
            newRow.className = "event-item p-4 bg-slate-50/70 rounded-xl border border-slate-100 relative space-y-3";

            newRow.innerHTML = `
                <button type="button" onclick="removeEventRow(this)" class="btn-remove-event absolute top-3 right-3 text-slate-300 hover:text-rose-500 transition-all">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Nama Acara</label>
                        <input type="text" name="events[${eventIndex}][name]" value="${data ? data.name : ''}" placeholder="Contoh: Akad Nikah / Resepsi" required class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Tanggal Acara</label>
                        <input type="date" name="events[${eventIndex}][event_date]" value="${data && data.event_date ? data.event_date.substring(0,10) : ''}" required class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Jam Mulai</label>
                            <input type="time" name="events[${eventIndex}][start_time]" value="${data ? data.start_time.substring(0,5) : ''}" required class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                        </div>
                        <div>
                            <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Jam Selesai</label>
                            <input type="time" name="events[${eventIndex}][end_time]" value="${data && data.end_time ? data.end_time.substring(0,5) : ''}" class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Nama Tempat / Venue</label>
                        <input type="text" name="events[${eventIndex}][venue_name]" value="${data ? data.venue_name : ''}" required class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                    </div>
                    <div>
                        <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">URL Google Maps (Opsional)</label>
                        <input type="url" name="events[${eventIndex}][google_maps_url]" value="${data && data.google_maps_url ? data.google_maps_url : ''}" placeholder="https://maps.google.com/..." class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="md:col-span-2">
                        <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Alamat Spesifik Tempat</label>
                        <input type="text" name="events[${eventIndex}][address]" value="${data ? data.address : ''}" required class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Latitude</label>
                            <input type="text" name="events[${eventIndex}][latitude]" value="${data && data.latitude ? data.latitude : ''}" placeholder="-6.1234" class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                        </div>
                        <div>
                            <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Longitude</label>
                            <input type="text" name="events[${eventIndex}][longitude]" value="${data && data.longitude ? data.longitude : ''}" placeholder="106.1234" class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-2xs font-bold text-slate-500 uppercase mb-1">Keterangan Acara (Opsional)</label>
                    <input type="text" name="events[${eventIndex}][description]" value="${data && data.description ? data.description : ''}" placeholder="Contoh: Live streaming" class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden">
                </div>
            `;
            container.appendChild(newRow);
            eventIndex++;
            updateRemoveButtons();
        }

        function removeEventRow(button) {
            button.closest('.event-item').remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const buttons = document.querySelectorAll('.btn-remove-event');
            buttons.forEach(btn => {
                if (buttons.length <= 1) btn.classList.add('hidden');
                else btn.classList.remove('hidden');
            });
        }

        function toggleProfileFields() {
            const select = document.getElementById('invitation_type_id');
            const selectedOption = select.options[select.selectedIndex];
            const typeSlug = selectedOption ? selectedOption.getAttribute('data-slug') : '';

            const wrapperSecondParty = document.getElementById('wrapper-second-party');
            const labelFirstName = document.getElementById('label-first-name');
            const labelFirstNick = document.getElementById('label-first-nick');
            const labelParent1 = document.getElementById('label-parent-1');
            const boxParent2 = document.getElementById('box-parent-2');

            if (typeSlug === 'pernikahan') {
                wrapperSecondParty.classList.remove('hidden');
                boxParent2.classList.remove('hidden');
                labelFirstName.textContent = "Nama Mempelai Pria / Wanita Utama";
                labelFirstNick.textContent = "Nama Panggilan Pihak Pertama";
                labelParent1.textContent = "Orang Tua Pihak Ke-1";
            } else {
                wrapperSecondParty.classList.add('hidden');
                boxParent2.classList.add('hidden');
                labelFirstName.textContent = "Nama Lengkap Pemilik / Pihak Pertama";
                labelFirstNick.textContent = "Nama Panggilan";
                labelParent1.textContent = "Informasi Orang Tua";
            }
        }

        function toggleParentsForm() {
            const checkbox = document.getElementById('toggle-parents-checkbox');
            const wrapper = document.getElementById('wrapper-parents');
            if (checkbox.checked) wrapper.classList.remove('hidden');
            else wrapper.classList.add('hidden');
        }
    </script>
@endsection
