@extends('layouts.customer')

@section('title', isset($invitation) && $invitation->exists ? 'Edit Undangan' : 'Tambah Undangan')

@section('content')

@php
    $projectData = [];
    if (isset($invitation) && $invitation->exists && $invitation->builder && $invitation->builder->project_data) {
        $projectData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
    }
    $primaryColor = $projectData['primary_color'] ?? '#10b981';
    
    $sectionOrderVal = isset($projectData['section_order']) 
                        ? (is_array($projectData['section_order']) ? json_encode($projectData['section_order']) : $projectData['section_order']) 
                        : '';
    
    $hasParentsData = isset($invitation->profile) && ($invitation->profile->first_father || $invitation->profile->first_mother || $invitation->profile->second_father || $invitation->profile->second_mother);
    $showParents = isset($projectData['show_parents']) ? filter_var($projectData['show_parents'], FILTER_VALIDATE_BOOLEAN) : $hasParentsData;

    $programStudi = $projectData['program_studi'] ?? '';
    $universitas = $projectData['universitas'] ?? '';
@endphp

<div class="flex h-[calc(100vh-4.5rem)] overflow-hidden font-sans border-t border-slate-200 -mx-6 -mt-6 bg-slate-100">
    
    {{-- BAGIAN KIRI: EDITOR PANEL (SIDEBAR) --}}
    <div class="w-full lg:w-[480px] bg-white border-r border-slate-200 flex flex-col z-20 shadow-sm shrink-0">
        <div class="h-14 flex items-center justify-between px-6 border-b border-slate-100 bg-white shrink-0">
            <div>
                <h1 class="text-sm font-bold text-slate-800"><i class="fa-solid fa-pen-nib mr-2 text-sky-500"></i>Editor Undangan</h1>
                <p class="text-[10px] text-slate-400">Pilih tipe & tema, preview akan langsung muncul.</p>
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto custom-scrollbar relative">
            <form id="auto-save-form"
                action="{{ isset($invitation) && $invitation->exists ? route('customer.kelola-undangan.save', $invitation->id) : route('customer.kelola-undangan.save') }}"
                method="POST" enctype="multipart/form-data" class="divide-y divide-slate-100">
                @csrf

                {{-- SECTION 1: DATA UTAMA UNDANGAN --}}
                <div class="p-6 space-y-4">
                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-circle-info mr-2 text-sky-500"></i> Informasi Utama
                    </h4>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Undangan</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $invitation->title ?? 'Undangan Spesial') }}" required oninput="generateSlug()" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Slug URL</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $invitation->slug ?? '') }}" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tgl Pelaksanaan</label>
                            <input type="datetime-local" name="event_date" value="{{ old('event_date', isset($invitation) && $invitation->event_date ? date('Y-m-d\TH:i', strtotime($invitation->event_date)) : date('Y-m-d\T09:00', strtotime('+1 month'))) }}" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tipe Undangan</label>
                            <select name="invitation_type_id" id="type-select" required onchange="toggleProfileFields()" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" data-slug="{{ $type->slug }}" {{ ($invitation->invitation_type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tema Desain</label>
                            <select name="theme_id" id="theme-select" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                                <option value="">-- Pilih Tema --</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password (Opsional)</label>
                            <input type="password" name="password" placeholder="Kosongkan jika publik" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Custom Domain</label>
                            <input type="text" name="custom_domain" value="{{ old('custom_domain', $invitation->custom_domain ?? '') }}" placeholder="dinda-raffi.com" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                    </div>
                </div>

                {{-- SECTION BUILDER UI --}}
                <div class="p-6 space-y-4">
                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-layer-group mr-2 text-sky-500"></i> Builder & Tampilan
                    </h4>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">Warna Utama (Aksen)</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="builder[primary_color]" value="{{ $primaryColor }}" class="w-10 h-10 rounded cursor-pointer border-0 p-0">
                            <span class="text-xs text-slate-500">Dominasi warna untuk elemen desain.</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">Susunan Section (Layer)</label>
                        <input type="hidden" name="builder[section_order]" id="section_order_input" value="{{ $sectionOrderVal }}">
                        <ul id="section-list" class="space-y-2"></ul>
                    </div>
                </div>

                {{-- SECTION 2: DATA RELASI PROFILE --}}
                <div class="p-6 space-y-4">
                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center">
                        <i class="fa-solid fa-user-gear mr-2 text-indigo-500"></i> Pengaturan Konten Profil & Teks
                    </h4>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Headline (Pengantar)</label>
                            <input type="text" name="headline" value="{{ old('headline', optional($invitation->profile)->headline ?? 'The Wedding Of') }}" placeholder="Contoh: The Wedding Of" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kutipan / Quote Pembuka</label>
                            <input type="text" name="quote" value="{{ old('quote', optional($invitation->profile)->quote ?? 'Menuju ikatan halal...') }}" placeholder="Menuju Ikatan Halal..." class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label id="label-first-name" class="block text-xs font-semibold text-slate-600 mb-1.5">Pihak Pertama</label>
                            <input type="text" name="first_name" data-preview="first_name" value="{{ old('first_name', optional($invitation->profile)->first_name ?? 'Budi') }}" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                        <div>
                            <label id="label-first-nick" class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Panggilan Pertama</label>
                            <input type="text" name="first_nickname" value="{{ old('first_nickname', optional($invitation->profile)->first_nickname ?? 'Budi') }}" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                    </div>

                    <div id="wrapper-second-party" class="grid grid-cols-2 gap-4 hidden">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Pihak Kedua</label>
                            <input type="text" name="second_name" id="second_name" data-preview="second_name" value="{{ old('second_name', optional($invitation->profile)->second_name ?? 'Sita') }}" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Panggilan Kedua</label>
                            <input type="text" name="second_nickname" id="second_nickname" value="{{ old('second_nickname', optional($invitation->profile)->second_nickname ?? 'Sita') }}" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-200 mt-2">
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Tampilkan Nama Orang Tua</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Aktifkan untuk menyertakan di undangan.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="builder[show_parents]" value="0">
                            <input type="checkbox" name="builder[show_parents]" id="toggle-parents-checkbox" value="1" onchange="toggleParentsForm()" {{ $showParents ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>

                    <div id="wrapper-parents" class="grid grid-cols-1 md:grid-cols-2 gap-4 {{ $showParents ? '' : 'hidden' }}">
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                            <span id="label-parent-1" class="text-[10px] font-bold text-slate-400 uppercase block tracking-wider">Orang Tua Pihak Ke-1</span>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Nama Ayah</label>
                                <input type="text" name="first_father" data-preview="first_father" id="first_father" value="{{ old('first_father', optional($invitation->profile)->first_father ?? 'Bapak Ahmad') }}" class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 focus:border-sky-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Nama Ibu</label>
                                <input type="text" name="first_mother" data-preview="first_mother" id="first_mother" value="{{ old('first_mother', optional($invitation->profile)->first_mother ?? 'Ibu Ani') }}" class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 focus:border-sky-500 outline-none transition-all">
                            </div>
                        </div>

                        <div id="box-parent-2" class="p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3 hidden">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block tracking-wider">Orang Tua Pihak Ke-2</span>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Nama Ayah</label>
                                <input type="text" name="second_father" data-preview="second_father" id="second_father" value="{{ old('second_father', optional($invitation->profile)->second_father ?? 'Bapak Jono') }}" class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 focus:border-sky-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-slate-500 uppercase mb-1">Nama Ibu</label>
                                <input type="text" name="second_mother" data-preview="second_mother" id="second_mother" value="{{ old('second_mother', optional($invitation->profile)->second_mother ?? 'Ibu Susi') }}" class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2 focus:border-sky-500 outline-none transition-all">
                            </div>
                        </div>
                    </div>

                    <div id="wrapper-graduation-fields" class="grid grid-cols-2 gap-4 hidden">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Program Studi</label>
                            <input type="text" name="builder[program_studi]" id="program_studi" value="{{ old('builder.program_studi', $programStudi) }}" placeholder="Contoh: Teknik Informatika" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Almamater / Universitas</label>
                            <input type="text" name="builder[universitas]" id="universitas" value="{{ old('builder.universitas', $universitas) }}" placeholder="Contoh: Universitas Pasundan" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi Tambahan Acara</label>
                        <textarea name="description" rows="2" placeholder="Catatan tambahan mengenai dresscode, protokol, dll..." class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">{{ old('description', optional($invitation->profile)->description ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Utama Pelaksanaan</label>
                        <textarea name="address" rows="2" placeholder="Jl. Diponegoro No. 24, Bandung" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">{{ old('address', optional($invitation->profile)->address ?? 'Jl. Raya Contoh No. 123') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Teks Kalimat Penutup</label>
                        <textarea name="closing_text" rows="2" placeholder="Merupakan suatu kehormatan bagi kami..." class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-sky-500 outline-none transition-all">{{ old('closing_text', optional($invitation->profile)->closing_text ?? '') }}</textarea>
                    </div>
                </div>

                {{-- SECTION 3: RANGKAIAN ACARA (DYNAMIC REPEATER) --}}
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider flex items-center">
                            <i class="fa-solid fa-calendar-days mr-2 text-amber-500"></i> Detail Susunan Acara
                        </h4>
                        <button type="button" onclick="addEventRow(); triggerAutoSave(true);" class="px-2.5 py-1 text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-200 hover:bg-amber-100 rounded-lg transition-all">
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
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider">Musik Latar Belakang (Backsound)</label>
                        
                        @php 
                            $activeMusic = isset($invitation) && $invitation->exists ? $invitation->media->where('type', 'music')->first() : null; 
                        @endphp

                        <div class="relative group border {{ $activeMusic ? 'border-emerald-300 bg-emerald-50' : 'border-slate-200 bg-slate-50' }} rounded-2xl p-4 flex items-center gap-4 hover:border-sky-400 transition-all">
                            <input type="file" id="input-music" name="media_music" accept="audio/mp3,audio/wav" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" title="Pilih file baru untuk mengganti">
                            
                            <div class="p-3 {{ $activeMusic ? 'bg-emerald-500' : 'bg-sky-500' }} rounded-xl text-white group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-music text-lg"></i>
                            </div>
                            <div class="flex-grow">
                                <p class="text-xs font-semibold {{ $activeMusic ? 'text-emerald-700' : 'text-slate-700' }}" id="music-file-name">
                                    {{ $activeMusic ? 'Musik Aktif Terpasang' : 'Pilih File Audio Baru' }}
                                </p>
                                <p class="text-2xs {{ $activeMusic ? 'text-emerald-600/70' : 'text-slate-400' }}">
                                    {{ $activeMusic ? 'Timpa untuk mengganti.' : 'Format: MP3 atau WAV (Maksimal 15MB)' }}
                                </p>
                            </div>
                        </div>

                        {{-- Mini Player untuk bukti ke User bahwa musik tersimpan --}}
                        @if($activeMusic)
                        <div class="mt-2 p-2 bg-white border border-slate-200 rounded-xl shadow-sm flex items-center">
                            <audio controls class="h-8 w-full outline-none">
                                <source src="{{ asset($activeMusic->file_path) }}" type="{{ $activeMusic->mime_type ?? 'audio/mpeg' }}">
                                Browser Anda tidak mendukung elemen audio.
                            </audio>
                        </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">Gambar Cover Utama</label>
                        <div id="dropzone-cover" class="relative group border-2 border-dashed border-slate-300 rounded-2xl p-2 cursor-pointer bg-slate-50 hover:border-sky-400 hover:bg-sky-50 h-32 flex flex-col items-center justify-center overflow-hidden transition-all">
                            <input type="file" id="input-cover" name="media_cover" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" title="">
                            <div id="cover-placeholder" class="text-center pointer-events-none {{ isset($invitation) && $invitation->media->where('type', 'cover')->first() ? 'hidden' : '' }}">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400 mb-1"></i>
                                <p class="text-[10px] font-medium text-slate-500">Klik / Drag Foto Sini</p>
                            </div>
                            <img id="cover-preview-img" src="{{ isset($invitation) && $invitation->media->where('type', 'cover')->first() ? asset($invitation->media->where('type', 'cover')->first()->file_path) : '' }}" class="absolute inset-0 w-full h-full object-cover z-0 {{ isset($invitation) && $invitation->media->where('type', 'cover')->first() ? '' : 'hidden' }}">
                        </div>
                        <p id="error-cover" class="text-[10px] text-red-500 font-medium hidden mt-1">Hanya bisa pilih 1 foto cover!</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-2">Album Galeri</label>
                        
                        {{-- KOTAK PREVIEW FOTO YANG SUDAH ADA (Bisa Dihapus) --}}
                        <div id="gallery-preview-container" class="grid grid-cols-4 gap-2 mb-3">
                            @if(isset($invitation) && $invitation->media->where('type', 'gallery')->count() > 0)
                                @foreach($invitation->media->where('type', 'gallery') as $gal)
                                    <div class="relative group rounded-lg overflow-hidden h-16 gallery-item">
                                        <img src="{{ asset($gal->file_path) }}" class="w-full h-full object-cover border border-slate-200">
                                        <button type="button" onclick="removeGalleryImage('{{ $gal->id }}', this)" class="absolute top-1 right-1 bg-rose-500 text-white w-5 h-5 rounded-full flex items-center justify-center transition-all z-20 shadow-md">
                                            <i class="fa-solid fa-xmark text-[10px]"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- KOTAK DROPZONE KHUSUS TAMBAH FOTO BARU --}}
                        <div id="dropzone-gallery" class="relative group border-2 border-dashed border-slate-300 rounded-2xl p-4 cursor-pointer bg-slate-50 hover:border-sky-400 hover:bg-sky-50 transition-all flex flex-col items-center justify-center min-h-[100px]">
                            <input type="file" id="input-gallery" name="media_gallery[]" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" title="">
                            <i class="fa-solid fa-images text-2xl text-slate-400 mb-1"></i>
                            <p class="text-[10px] font-medium text-slate-500">Klik / Drag Foto Baru Kesini</p>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        
    </div>

    {{-- BAGIAN KANAN: LIVE PREVIEW AREA --}}
    <div class="flex-1 flex flex-col relative overflow-hidden bg-slate-200/60 dot-pattern">
        
        {{-- Header Tools Iframe --}}
        <div class="absolute top-4 left-1/2 -translate-x-1/2 z-10 flex items-center bg-white/90 backdrop-blur-md p-1.5 rounded-xl shadow-sm border border-slate-200 gap-1">
            <button type="button" onclick="changeDevice('mobile')" id="btn-mobile" class="device-btn px-4 py-1.5 rounded-lg bg-slate-800 text-white text-xs font-semibold transition-all">
                <i class="fa-solid fa-mobile-screen mr-1"></i> Mobile
            </button>
            <button type="button" onclick="changeDevice('tablet')" id="btn-tablet" class="device-btn px-4 py-1.5 rounded-lg bg-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-100 text-xs font-semibold transition-all">
                <i class="fa-solid fa-tablet-screen-button mr-1"></i> Tablet
            </button>
            <button type="button" onclick="changeDevice('desktop')" id="btn-desktop" class="device-btn px-4 py-1.5 rounded-lg bg-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-100 text-xs font-semibold transition-all">
                <i class="fa-solid fa-desktop mr-1"></i> Desktop
            </button>
            <div class="w-[1px] h-4 bg-slate-300 mx-1"></div>
            <button onclick="refreshPreview()" class="px-3 py-1.5 text-slate-500 hover:text-sky-500 hover:bg-sky-50 rounded-lg transition-all" title="Refresh Iframe">
                <i class="fa-solid fa-rotate-right text-xs"></i>
            </button>
        </div>

        {{-- Wrapper Iframe / Placeholder --}}
        <div id="preview-container-box" class="flex-1 overflow-y-auto flex items-center justify-center p-8 pt-20 custom-scrollbar relative">
            @if(isset($invitation) && $invitation->exists && $invitation->theme_id)
                <div id="preview-wrapper" class="relative transition-all duration-500 shadow-2xl bg-white border-[12px] border-slate-800 rounded-[2.5rem] overflow-hidden" style="width: 375px; height: 812px; min-height: 812px; flex-shrink: 0;">
                    <iframe id="preview-frame" src="{{ route('invitation.show', $invitation->slug) }}?preview=1" class="w-full h-full border-none bg-white pointer-events-auto"></iframe>
                </div>
            @else
                <div id="preview-empty-state" class="w-full max-w-md bg-white p-8 rounded-2xl shadow-sm text-center border border-slate-200 transition-all">
                    <div class="w-20 h-20 bg-sky-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-wand-magic-sparkles text-3xl text-sky-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Pilih Tema Desain</h3>
                    <p class="text-sm text-slate-500">Silakan pilih <b>Tipe & Tema Desain</b> di menu sebelah kiri. Live Preview akan langsung dimuat secara otomatis.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 10px; }
    .dot-pattern { background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px); background-size: 24px 24px; }
</style>

<script>
    // Menyimpan Status Data
    let isInvitationExists = {{ isset($invitation) && $invitation->exists ? 'true' : 'false' }};
    const autoSaveForm = document.getElementById('auto-save-form');
    let eventIndex = 0;
    const existingEvents = @json(isset($invitation) ? $invitation->events->toArray() : []);

    document.addEventListener("DOMContentLoaded", function() {
        if (existingEvents.length > 0) {
            existingEvents.forEach(event => { addEventRow(event); });
        } else {
            addEventRow(); // Auto buat 1 baris acara
        }
        
        // Auto generate slug jika baru
        if (!document.getElementById('slug').value) {
            generateSlug();
        }

        toggleProfileFields();
        toggleParentsForm();
    });

    // -------------------------------------------------------------
    // LOGIKA AUTO-SAVE DAN LIVE PREVIEW SINKRONISASI
    // -------------------------------------------------------------
    let saveTimeout = null;

    function refreshPreview() {
        const previewFrame = document.getElementById('preview-frame');
        if (!previewFrame || previewFrame.src === '#' || previewFrame.src.includes('#')) return;

        // 1. Simpan posisi scroll iframe saat ini
        let currentScroll = 0;
        try {
            currentScroll = previewFrame.contentWindow.scrollY || previewFrame.contentWindow.document.documentElement.scrollTop;
        } catch(e) {}

        // 2. Munculkan indikator loading kecil di pojok iframe
        const wrapper = document.getElementById('preview-wrapper');
        let loader = document.getElementById('iframe-loader');
        if(!loader && wrapper) {
            loader = document.createElement('div');
            loader.id = 'iframe-loader';
            loader.className = 'absolute top-3 right-3 bg-slate-800/80 backdrop-blur text-white text-[10px] font-bold px-3 py-1.5 rounded-full z-50 animate-pulse transition-all';
            loader.innerHTML = '<i class="fa-solid fa-arrows-rotate fa-spin mr-1"></i> Menyinkronkan...';
            wrapper.appendChild(loader);
        } else if(loader) {
            loader.classList.remove('hidden');
        }

        let baseUrl = previewFrame.src.split('?')[0];
        previewFrame.src = baseUrl + '?preview=1&t=' + new Date().getTime();

        // 3. Setelah selesai dimuat, kembalikan posisi scroll ke tempat semula
        previewFrame.onload = function() {
            try {
                previewFrame.contentWindow.scrollTo(0, currentScroll);
                if(loader) loader.classList.add('hidden');

                const audio = previewFrame.contentWindow.document.getElementById('weddingMusic');
                if (audio) audio.play().catch(e => {}); 
            } catch(e) {}
        };
    }

    // Live Text Update (tanpa refresh) -> Bekerja jika ada atribut data-preview="first_name" di template
    function syncToPreview(name, value) {
        const previewFrame = document.getElementById('preview-frame');
        if (!previewFrame || !previewFrame.contentWindow) return;
        try {
            const doc = previewFrame.contentWindow.document;
            
            // SUNTIKAN WARNA LANGSUNG KE CSS
            if (name === 'builder[primary_color]') {
                doc.documentElement.style.setProperty('--primary-color', value, 'important');
                return;
            }

            if (name === 'builder[program_studi]') {
                const elements = doc.querySelectorAll('[data-preview="program_studi"]');
                elements.forEach(el => { el.innerText = value; });
                return;
            }

            if (name === 'builder[universitas]') {
                const elements = doc.querySelectorAll('[data-preview="universitas"]');
                elements.forEach(el => { el.innerText = value; });
                return;
            }

            // FORMAT REAL-TIME UNTUK TANGGAL PELAKSANAAN UTAMA
            if (name === 'event_date') {
                if (!value) return;
                // Potong hanya bagian tanggalnya saja (YYYY-MM-DD)
                const dateOnly = value.split('T')[0];
                const parts = dateOnly.split('-');
                if (parts.length === 3) {
                    // Susun ulang menjadi DD . MM . YYYY
                    const formattedDate = `${parts[2]} . ${parts[1]} . ${parts[0]}`;
                    const elements = doc.querySelectorAll(`[data-preview="event_date"]`);
                    elements.forEach(el => { el.innerText = formattedDate; });
                }
                return;
            }

            // CEK JIKA INI INPUT ACARA (EVENTS ARRAY)
            if (name.startsWith('events[')) {
                const match = name.match(/events\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const idx = match[1];
                    const field = match[2];
                    
                    let displayValue = value;
                    if (field === 'end_time' && !value) displayValue = 'Selesai';

                    const elements = doc.querySelectorAll(`[data-event-preview="${field}_${idx}"]`);
                    elements.forEach(el => { el.innerText = displayValue; });
                }
                return;
            }

            // UPDATE TEKS LAINNYA (Termasuk Orang Tua & Profil)
            const elements = doc.querySelectorAll(`[data-preview="${name}"]`);
            elements.forEach(el => { el.innerText = value; });
        } catch (e) { /* Abaikan Error cross-origin */ }
    }

    // Fungsi Utama Menyimpan Background
    function triggerAutoSave(forceRefresh = false) {
        const themeSelect = document.getElementById('theme-select');
        if (!themeSelect.value) return; 

        const formData = new FormData(autoSaveForm);
        const previewContainer = document.getElementById('preview-container-box');
        const emptyState = document.getElementById('preview-empty-state');
        
        if (!isInvitationExists && emptyState) {
            emptyState.innerHTML = `
                <div class="animate-spin w-14 h-14 border-4 border-sky-500 border-t-transparent rounded-full mx-auto mb-5"></div>
                <h3 class="text-lg font-bold text-slate-800">Menyiapkan Preview...</h3>
                <p class="text-sm text-slate-500">Menerapkan template desain pilihan Anda secara realtime.</p>
            `;
        }

        fetch(autoSaveForm.action, {
            method: 'POST',
            body: formData,
            headers: { 
                'X-Requested-With': 'XMLHttpRequest', 
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(async r => {
            if (!r.ok) {
                const errData = await r.json().catch(() => ({}));
                let errMsg = errData.message || 'Terjadi masalah pada server. Periksa isian form.';
                
                if (errData.errors) {
                    const firstErrorKey = Object.keys(errData.errors)[0];
                    errMsg = errData.errors[firstErrorKey][0];
                }
                
                throw new Error(errMsg);
            }
            return r.json();
        })
        .then(data => {
            if (data.status === 'success') {
                
                // MENGOSONGKAN INPUT FILE AGAR BISA UPLOAD FOTO BARU (TIDAK DOUBLE)
                if(document.getElementById('input-cover')) document.getElementById('input-cover').value = '';
                if(document.getElementById('input-gallery')) document.getElementById('input-gallery').value = '';
                if(document.getElementById('input-music')) document.getElementById('input-music').value = '';

                // Hapus efek loading hitam dari gambar galeri yang baru diupload
                document.querySelectorAll('.temp-gallery-item .bg-black\\/40').forEach(el => el.remove());

                if (!isInvitationExists) {
                    isInvitationExists = true;
                    
                    // UBAH BARIS INI: Gunakan save_url untuk action form (POST)
                    autoSaveForm.action = data.save_url; 
                    
                    // Tetap gunakan redirect_url untuk mengubah alamat di browser atas (visual saja)
                    window.history.replaceState(null, null, data.redirect_url); 
                    
                    previewContainer.innerHTML = `
                        <div id="preview-wrapper" class="relative transition-all duration-500 shadow-2xl bg-white border-[12px] border-slate-800 rounded-[2.5rem] overflow-hidden" style="width: 375px; height: 812px; min-height: 812px; flex-shrink: 0;">
                            <iframe id="preview-frame" src="${data.preview_url}?preview=1" class="w-full h-full border-none bg-white pointer-events-auto"></iframe>
                        </div>
                    `;
                } else {
                    if (forceRefresh) refreshPreview();
                }
            }
        })
        .catch(err => {
            console.error("Auto-save gagal: ", err);
            
            // 1. KOSONGKAN FILE AGAR ERROR TIDAK MENYANGKUT DI BACKGROUND
            if(document.getElementById('input-cover')) document.getElementById('input-cover').value = '';
            if(document.getElementById('input-gallery')) document.getElementById('input-gallery').value = '';
            if(document.getElementById('input-music')) document.getElementById('input-music').value = '';
            
            // 2. HAPUS PREVIEW GAMBAR YANG GAGAL UPLOAD
            document.querySelectorAll('.temp-gallery-item').forEach(el => el.remove()); 

            // 3. MUNCULKAN POP-UP PERINGATAN KE USER
            alert("GAGAL MENYIMPAN: \n" + err.message + "\n\n(TIPS: Jika gagal upload, pastikan ukuran Foto maks 5MB dan Musik maks 10MB. Jika masih gagal, cek batas upload_max_filesize di php.ini Anda).");

            const emptyState = document.getElementById('preview-empty-state');
            if (!isInvitationExists && emptyState) {
                emptyState.innerHTML = `
                    <div class="w-16 h-16 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-triangle-exclamation text-3xl text-rose-500"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Gagal Membuat Draft</h3>
                    <p class="text-xs text-rose-500 max-w-sm mx-auto text-center">${err.message}</p>
                `;
            }
        });
    }

    // Auto-save on Input Text (Debounce 1.5 detik)
    autoSaveForm.addEventListener('input', (e) => {
        if (e.target.type === 'file') return;
        
        syncToPreview(e.target.name, e.target.value);
        clearTimeout(saveTimeout);
        
        saveTimeout = setTimeout(() => {
            triggerAutoSave(false); 
        }, 1500);
    });

    autoSaveForm.addEventListener('change', (e) => {
        if (e.target.name === 'event_date') {
            syncToPreview(e.target.name, e.target.value);
        }
    });

    // Handle perubahan Select, Waktu, Tanggal, dll
    autoSaveForm.addEventListener('change', (e) => {
        if (e.target.type === 'file') return; 

        if (e.target.type !== 'text') {
            // Daftar input yang MERUBAH STRUKTUR (butuh smart reload iframe)
            const structuralInputs = ['theme_id', 'invitation_type_id', 'builder[show_parents]'];
            const isEventData = e.target.name.includes('events[');

            const needsRefresh = structuralInputs.includes(e.target.name) || isEventData;
            
            triggerAutoSave(needsRefresh);
        }
    });

    // -------------------------------------------------------------
    // FUNGSI UMUM FORM
    // -------------------------------------------------------------
    
    window.changeDevice = function(device) {
        const wrapper = document.getElementById('preview-wrapper');
        if(!wrapper) return;
        document.querySelectorAll('.device-btn').forEach(btn => {
            btn.classList.remove('bg-slate-800', 'text-white');
            btn.classList.add('bg-transparent', 'text-slate-500');
        });
        if (device === 'mobile') {
            wrapper.style.width = '375px'; wrapper.style.height = '812px';
            wrapper.className = "relative transition-all duration-500 shadow-2xl bg-white border-[12px] border-slate-800 rounded-[2.5rem] overflow-hidden flex-shrink-0";
            document.getElementById('btn-mobile').classList.add('bg-slate-800', 'text-white');
        } else if (device === 'tablet') {
            wrapper.style.width = '768px'; wrapper.style.height = '1024px';
            wrapper.className = "relative transition-all duration-500 shadow-2xl bg-white border-[16px] border-slate-800 rounded-[3rem] overflow-hidden flex-shrink-0";
            document.getElementById('btn-tablet').classList.add('bg-slate-800', 'text-white');
        } else {
            wrapper.style.width = '100%'; wrapper.style.height = '100%';
            wrapper.className = "relative transition-all duration-500 shadow-2xl bg-white border-4 border-slate-800 rounded-xl overflow-hidden w-full h-full";
            document.getElementById('btn-desktop').classList.add('bg-slate-800', 'text-white');
        }
    };

    function generateSlug() {
        const title = document.getElementById('title').value;
        document.getElementById('slug').value = title.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-') + '-' + Math.floor(Math.random() * 1000);
    }

    const themesData = @json($themes);
    const typesData = @json($types);
    const currentThemeId = "{{ $invitation->theme_id ?? '' }}";

    function toggleProfileFields() {
        const typeSelect = document.getElementById('type-select');
        const selectedOption = typeSelect.options[typeSelect.selectedIndex];
        const typeSlug = selectedOption ? selectedOption.getAttribute('data-slug') : '';

        const wrapperSecondParty = document.getElementById('wrapper-second-party');
        const labelFirstName = document.getElementById('label-first-name');
        const labelFirstNick = document.getElementById('label-first-nick');
        const labelParent1 = document.getElementById('label-parent-1');
        const boxParent2 = document.getElementById('box-parent-2');
        const wrapperGraduation = document.getElementById('wrapper-graduation-fields');

        if (typeSlug === 'wedding' || typeSlug === 'pernikahan' || typeSlug === 'engagement') {
            wrapperSecondParty.classList.remove('hidden');
            boxParent2.classList.remove('hidden');
            wrapperGraduation.classList.add('hidden');
            labelFirstName.textContent = "Nama Pria / Wanita Pertama";
            labelFirstNick.textContent = "Nama Panggilan Pertama";
            labelParent1.textContent = "Orang Tua Pihak Ke-1";
        } else if (typeSlug === 'graduation' || typeSlug === 'wisuda') {
            wrapperSecondParty.classList.add('hidden');
            boxParent2.classList.add('hidden');
            wrapperGraduation.classList.remove('hidden');
            labelFirstName.textContent = "Nama Lengkap (Pemilik Acara)";
            labelFirstNick.textContent = "Nama Panggilan";
            labelParent1.textContent = "Informasi Orang Tua";
        } else {
            wrapperSecondParty.classList.add('hidden');
            boxParent2.classList.add('hidden');
            wrapperGraduation.classList.add('hidden');
            labelFirstName.textContent = "Nama Lengkap (Pemilik Acara)";
            labelFirstNick.textContent = "Nama Panggilan";
            labelParent1.textContent = "Informasi Orang Tua";
        }
        
        const themeSelect = document.getElementById('theme-select');
        themeSelect.innerHTML = '<option value="">-- Pilih Tema --</option>'; 
        const selectedTypeData = typesData.find(t => t.id === typeSelect.value);
        if (selectedTypeData) {
            const filteredThemes = themesData.filter(t => t.category_slug === selectedTypeData.slug);
            filteredThemes.forEach(t => {
                const isSelected = (t.id === currentThemeId) ? 'selected' : '';
                themeSelect.innerHTML += `<option value="${t.id}" ${isSelected}>${t.name}</option>`;
            });
        }
    }

    window.toggleParentsForm = function() {
        const checkbox = document.getElementById('toggle-parents-checkbox');
        const wrapper = document.getElementById('wrapper-parents');
        if (checkbox.checked) wrapper.classList.remove('hidden');
        else wrapper.classList.add('hidden');
    };

    window.addEventRow = function(data = null) {
        // Cegah error "undefined" jika fungsi dipanggil paksa oleh button onclick
        if (data instanceof Event) data = null; 

        const container = document.getElementById('events-container');
        const newRow = document.createElement('div');
        newRow.className = "event-item p-4 bg-slate-50 border border-slate-200 rounded-xl relative space-y-4";

        const defaultDate = new Date(); defaultDate.setMonth(defaultDate.getMonth() + 1);
        const dateVal = data && data.event_date ? data.event_date.substring(0, 10) : defaultDate.toISOString().substring(0, 10);
        
        newRow.innerHTML = `
            <button type="button" onclick="this.closest('.event-item').remove(); updateRemoveButtons(); triggerAutoSave(true);" class="btn-remove-event absolute top-3 right-3 text-red-400 hover:text-red-600 transition-all"><i class="fa-solid fa-trash-can text-sm"></i></button>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nama Acara</label>
                    <input type="text" name="events[${eventIndex}][name]" value="${data ? data.name : 'Acara Utama'}" required class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tanggal Acara</label>
                    <input type="date" name="events[${eventIndex}][event_date]" value="${dateVal}" required class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jam Mulai</label>
                    <input type="time" name="events[${eventIndex}][start_time]" value="${data ? data.start_time.substring(0,5) : '08:00'}" required class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jam Selesai <span class="text-sky-500 font-normal normal-case">(Kosongkan = Selesai)</span></label>
                    <input type="time" name="events[${eventIndex}][end_time]" value="${data && data.end_time ? data.end_time.substring(0,5) : ''}" class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Nama Tempat</label>
                    <input type="text" name="events[${eventIndex}][venue_name]" value="${data ? data.venue_name : 'Gedung Acara'}" required class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">URL Google Maps</label>
                    <input type="url" name="events[${eventIndex}][google_maps_url]" value="${data && data.google_maps_url ? data.google_maps_url : ''}" placeholder="https://maps..." class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Alamat Spesifik Tempat</label>
                <textarea name="events[${eventIndex}][address]" required rows="2" class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">${data ? data.address : 'Jl. Contoh Alamat No. 1'}</textarea>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Keterangan Tambahan Acara</label>
                <input type="text" name="events[${eventIndex}][description]" value="${data && data.description ? data.description : ''}" placeholder="Cth: Harap memakai dresscode putih..." class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
            </div>
        `;
        container.appendChild(newRow);
        eventIndex++;
        updateRemoveButtons();
    };

    function updateRemoveButtons() {
        const buttons = document.querySelectorAll('.btn-remove-event');
        buttons.forEach(btn => {
            if (buttons.length <= 1) btn.classList.add('hidden');
            else btn.classList.remove('hidden');
        });
    }

    const defaultSections = [
        { id: 'cover', name: 'Sampul Depan', visible: true },
        { id: 'quote', name: 'Kutipan Pengantar', visible: true },
        { id: 'profile', name: 'Profil & Orang Tua', visible: true },
        { id: 'event', name: 'Rangkaian Acara', visible: true },
        { id: 'gallery', name: 'Galeri Momen', visible: true },
        { id: 'closing', name: 'Penutup Undangan', visible: true }
    ];

    const sectionInput = document.getElementById('section_order_input');
    const sectionList = document.getElementById('section-list');
    let currentSections = defaultSections;

    try {
        const parsed = JSON.parse(sectionInput.value);
        if(Array.isArray(parsed) && parsed.length > 0) {
            currentSections = parsed;
            
            // SMART MERGE: Cek apakah ada menu baru di defaultSections yang belum tersimpan di database lama
            const savedIds = currentSections.map(s => s.id);
            defaultSections.forEach(def => {
                if (!savedIds.includes(def.id)) {
                    currentSections.push(def); // Tambahkan otomatis ke urutan paling bawah
                }
            });
        }
    } catch(e) {}

    function renderSections() {
        sectionList.innerHTML = '';
        currentSections.forEach((sec, index) => {
            const li = document.createElement('li');
            li.className = "flex items-center justify-between p-2.5 bg-slate-50 border border-slate-200 rounded-lg cursor-move hover:border-sky-300 transition-all";
            li.draggable = true;
            li.innerHTML = `
                <div class="flex items-center gap-3 pointer-events-none">
                    <i class="fa-solid fa-grip-vertical text-slate-300"></i>
                    <span class="text-xs font-medium ${sec.visible ? 'text-slate-700' : 'text-slate-400 line-through'}">${sec.name}</span>
                </div>
                <button type="button" onclick="toggleSection(${index})" class="p-1 hover:bg-slate-200 rounded transition-colors">
                    <i class="fa-solid text-xs ${sec.visible ? 'fa-eye text-emerald-500' : 'fa-eye-slash text-slate-400'}"></i>
                </button>
            `;
            li.addEventListener('dragstart', (e) => e.dataTransfer.setData('text/plain', index));
            li.addEventListener('dragover', (e) => { e.preventDefault(); li.classList.add('bg-sky-50'); });
            li.addEventListener('dragleave', () => li.classList.remove('bg-sky-50'));
            li.addEventListener('drop', (e) => {
                e.preventDefault(); li.classList.remove('bg-sky-50');
                const draggedIdx = parseInt(e.dataTransfer.getData('text/plain'));
                const draggedItem = currentSections.splice(draggedIdx, 1)[0];
                currentSections.splice(index, 0, draggedItem);
                updateSectionInput(); renderSections(); 
                
                triggerAutoSave(true); // <--- Pastikan ada 'true'
            });
            sectionList.appendChild(li);
        });
    }
    window.toggleSection = function(index) {
        currentSections[index].visible = !currentSections[index].visible;
        updateSectionInput(); renderSections(); 
        
        triggerAutoSave(true); // <--- Pastikan ada 'true'
    };
    function updateSectionInput() { sectionInput.value = JSON.stringify(currentSections); }
    updateSectionInput(); renderSections();

    // FUNGSI MENGHAPUS FOTO GALERI
    window.removeGalleryImage = function(id, btn) {
        btn.closest('.gallery-item').remove(); // Hapus dari layar
        // Tambahkan input hidden berisi ID gambar yang akan dihapus ke database
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'deleted_media[]';
        hiddenInput.value = id;
        document.getElementById('auto-save-form').appendChild(hiddenInput);
        triggerAutoSave(true); // Simpan perubahan & refresh iframe
    };

    // FUNGSI MENANGKAP DRAG & DROP FILE
    const handleFiles = (files, inputEl, errEl, previewId, dropzone, isMulti, type) => {
        if(files.length > 1 && !isMulti) {
            if(errEl) errEl.classList.remove('hidden'); 
            inputEl.value = '';
        } else if (files.length > 0) {
            if(errEl && !isMulti) errEl.classList.add('hidden');

            // 1. JIKA YANG DIUPLOAD ADALAH MUSIK
            if (type === 'music') {
                document.getElementById('music-file-name').textContent = "Terpilih: " + files[0].name;
            } 
            // 2. JIKA YANG DIUPLOAD ADALAH GALERI
            else if (isMulti) {
                const container = document.getElementById('gallery-preview-container');
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        const div = document.createElement('div');
                        div.className = 'relative rounded-lg overflow-hidden h-16 temp-gallery-item';
                        div.innerHTML = `
                            <img src="${ev.target.result}" class="w-full h-full object-cover border border-slate-200">
                            <button type="button" onclick="this.parentElement.remove()" class="absolute top-1 right-1 bg-rose-500 text-white w-5 h-5 rounded-full flex items-center justify-center z-20 shadow-md"><i class="fa-solid fa-xmark text-[10px]"></i></button>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center z-10 loading-overlay"><i class="fa-solid fa-spinner fa-spin text-white"></i></div>
                        `;
                        container.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            } 
            // 3. JIKA YANG DIUPLOAD ADALAH COVER
            else if (type === 'cover') {
                if(document.getElementById('cover-placeholder')) document.getElementById('cover-placeholder').classList.add('hidden');
                if(document.getElementById('cover-preview-img')) {
                    const img = document.getElementById('cover-preview-img');
                    const reader = new FileReader();
                    reader.onload = (ev) => { 
                        img.src = ev.target.result; 
                        img.classList.remove('hidden'); 
                        
                        // SUNTIKAN REALTIME KE IFRAME (Tanpa Refresh)
                        try {
                            const previewFrame = document.getElementById('preview-frame');
                            if (previewFrame && previewFrame.contentWindow) {
                                const heroBg = previewFrame.contentWindow.document.querySelector('.hero-bg');
                                if (heroBg) {
                                    heroBg.style.backgroundImage = `linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.9)), url('${ev.target.result}')`;
                                }
                            }
                        } catch(e) {}
                    };
                    reader.readAsDataURL(files[0]);
                }
            }
            
            triggerAutoSave(true); 
        }
    };

    // EVENT LISTENER DRAG & DROP
    ['cover', 'gallery', 'music'].forEach(type => {
        const input = document.getElementById(`input-${type}`);
        const dropzone = input ? input.closest('.group') : null; 
        const err = document.getElementById(`error-${type}`); // Menghindari salah target error
        
        if(input && dropzone) {
            input.addEventListener('dragenter', () => dropzone.classList.add('border-sky-400', 'bg-sky-50/80'));
            input.addEventListener('dragleave', () => dropzone.classList.remove('border-sky-400', 'bg-sky-50/80'));
            input.addEventListener('drop', () => dropzone.classList.remove('border-sky-400', 'bg-sky-50/80'));
            
            input.addEventListener('change', (e) => {
                // Kita tambahkan argumen 'type' di bagian paling akhir
                handleFiles(e.target.files, input, err, null, dropzone, type === 'gallery', type);
            });
        }
    });
</script>
@endsection