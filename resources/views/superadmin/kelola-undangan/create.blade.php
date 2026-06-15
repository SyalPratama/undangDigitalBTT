@extends('layouts.superadmin')

@section('title', 'Tambah Undangan')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Header Area --}}
        <div>
            <div class="flex items-center gap-3 mb-2 text-sm text-slate-500">
                <a href="{{ route('superadmin.kelola-undangan.index') }}" class="hover:text-[#6d28d9] transition-colors">Kelola Undangan</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                <span class="font-medium text-slate-700">Tambah Undangan Baru</span>
            </div>
            <div class="flex items-center justify-between">
                <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">
                    Tambah Undangan Baru
                </h1>
            </div>
            <p class="text-xs text-slate-500 mt-2">Buat entri data undangan digital baru ke dalam sistem.</p>
        </div>

        <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">

            <form action="{{ route('superadmin.kelola-undangan.store') }}" method="POST" class="space-y-6">
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
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                oninput="generateSlug()"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                            @error('title')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Slug
                                URL</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                            @error('slug')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tipe
                                Undangan</label>
                            <select name="invitation_type_id" id="invitation_type_id" required
                                onchange="toggleProfileFields()"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-hidden transition-all">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" data-slug="{{ Str::slug($type->name) }}"
                                        {{ old('invitation_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}
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
                                        {{ old('theme_id') == $theme->id ? 'selected' : '' }}>{{ $theme->name }}</option>
                                @endforeach
                            </select>
                            @error('theme_id')
                                <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: DATA RELASI PROFILE --}}
                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-50 pb-2">
                        <i class="fa-solid fa-user-gear mr-1.5 text-indigo-500"></i> Pengaturan Konten Profil
                    </h4>

                    {{-- Baris Nama Utama --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label id="label-first-name"
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama Pihak
                                Pertama / Pemilik</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                        <div>
                            <label id="label-first-nick"
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                                Panggilan Pihak Pertama</label>
                            <input type="text" name="first_nickname" value="{{ old('first_nickname') }}" required
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                    </div>

                    {{-- Form Pihak Kedua (Hanya Nikah & Tunangan) --}}
                    <div id="wrapper-second-party" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                                Pihak Kedua</label>
                            <input type="text" name="second_name" id="second_name" value="{{ old('second_name') }}"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                                Panggilan Pihak Kedua</label>
                            <input type="text" name="second_nickname" id="second_nickname"
                                value="{{ old('second_nickname') }}"
                                class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">
                        </div>
                    </div>

                    {{-- Form Orang Tua (Hanya Nikah) --}}
                    <div id="wrapper-parents" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
                        <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-3">
                            <span class="text-[11px] font-bold text-slate-400 uppercase block tracking-wider">Orang Tua
                                Pihak ke-1</span>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ayah</label>
                                <input type="text" name="first_father" id="first_father"
                                    value="{{ old('first_father') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ibu</label>
                                <input type="text" name="first_mother" id="first_mother"
                                    value="{{ old('first_mother') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50/50 rounded-xl border border-slate-100 space-y-3">
                            <span class="text-[11px] font-bold text-slate-400 uppercase block tracking-wider">Orang Tua
                                Pihak ke-2</span>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ayah</label>
                                <input type="text" name="second_father" id="second_father"
                                    value="{{ old('second_father') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                            <div>
                                <label class="block text-2xs font-semibold text-slate-500 uppercase mb-1">Nama Ibu</label>
                                <input type="text" name="second_mother" id="second_mother"
                                    value="{{ old('second_mother') }}"
                                    class="w-full border border-slate-200 focus:border-sky-500 rounded-lg px-3 py-2 text-xs bg-white focus:outline-hidden transition-all">
                            </div>
                        </div>
                    </div>

                    {{-- Alamat Utama --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Alamat
                            Utama Pelaksanaan Acara</label>
                        <textarea name="address" rows="2" placeholder="Contoh: Jl. Diponegoro No. 24, Bandung, Jawa Barat"
                            class="w-full border border-slate-200 focus:border-sky-500 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden transition-all">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-slate-50">
                    <a href="{{ route('superadmin.kelola-undangan.index') }}"
                        class="px-4 py-2.5 text-sm font-medium text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Batal</a>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 rounded-xl shadow-sm transition-all">Simpan
                        Undangan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function generateSlug() {
            const title = document.getElementById('title').value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            document.getElementById('slug').value = slug;
        }

        function toggleProfileFields() {
            const selectEl = document.getElementById('invitation_type_id');
            const selectedOption = selectEl.options[selectEl.selectedIndex];
            const typeSlug = selectedOption ? selectedOption.getAttribute('data-slug') : '';

            // Elemen Wrapper & Label
            const secondPartyWrapper = document.getElementById('wrapper-second-party');
            const parentsWrapper = document.getElementById('wrapper-parents');
            const labelFirstName = document.getElementById('label-first-name');
            const labelFirstNick = document.getElementById('label-first-nick');

            // Input Fields
            const secondName = document.getElementById('second_name');
            const secondNick = document.getElementById('second_nickname');
            const fFather = document.getElementById('first_father');
            const fMother = document.getElementById('first_mother');
            const sFather = document.getElementById('second_father');
            const sMother = document.getElementById('second_mother');

            // Cek Kondisi Event
            const isCoupleEvent = typeSlug.includes('pernikahan') || typeSlug.includes('wedding') || typeSlug.includes(
                'tunangan') || typeSlug.includes('engagement');
            const isWeddingEvent = typeSlug.includes('pernikahan') || typeSlug.includes('wedding');

            if (isCoupleEvent) {
                secondPartyWrapper.classList.remove('hidden');
                secondName.required = true;
                secondNick.required = true;
                labelFirstName.innerText = "Nama Pihak Pertama";
                labelFirstNick.innerText = "Nama Panggilan Pihak Pertama";
            } else {
                secondPartyWrapper.classList.add('hidden');
                secondName.required = false;
                secondName.value = '';
                secondNick.required = false;
                secondNick.value = '';
                labelFirstName.innerText = "Nama Lengkap Pemilik / Acara";
                labelFirstNick.innerText = "Nama Panggilan Pemilik";
            }

            if (isWeddingEvent) {
                parentsWrapper.classList.remove('hidden');
                fFather.required = true;
                fMother.required = true;
                sFather.required = true;
                sMother.required = true;
            } else {
                parentsWrapper.classList.add('hidden');
                fFather.required = false;
                fFather.value = '';
                fMother.required = false;
                fMother.value = '';
                sFather.required = false;
                sFather.value = '';
                sMother.required = false;
                sMother.value = '';
            }
        }

        // Trigger on load if there's old value
        document.addEventListener('DOMContentLoaded', toggleProfileFields);
    </script>
@endsection
