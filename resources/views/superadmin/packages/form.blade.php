@extends('layouts.superadmin')

@section('title', isset($package) && $package->exists ? 'Edit Paket' : 'Tambah Paket')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">{{ isset($package) && $package->exists ? 'Edit Paket' : 'Tambah Paket' }}</h1>
        <p class="text-sm text-slate-500 mt-1">Atur detail harga, fitur, dan akses paket di sini.</p>
    </div>
    <a href="{{ route('superadmin.packages.index') }}" class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-slate-50 transition-all">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <form action="{{ isset($package) && $package->exists ? route('superadmin.packages.update', $package->id) : route('superadmin.packages.store') }}" method="POST">
        @csrf
        @if(isset($package) && $package->exists)
            @method('PUT')
        @endif

        <div class="p-6 md:p-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Paket</label>
                    <input type="text" name="name" value="{{ old('name', $package->name ?? '') }}" required placeholder="Contoh: Basic"
                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $package->price ?? 0) }}" required min="0"
                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Masa Aktif (Hari)</label>
                    <input type="number" name="active_days" value="{{ old('active_days', $package->active_days ?? 30) }}" required min="1"
                        class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Paket</label>
                    <div class="mt-2 flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            <span class="ml-3 text-sm font-medium text-slate-700">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi Singkat</label>
                <textarea name="description" rows="2" placeholder="Deskripsi paket untuk landing page"
                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:bg-white focus:border-indigo-500 outline-none transition-all">{{ old('description', $package->description ?? '') }}</textarea>
            </div>

            <hr class="border-slate-100">

            <div>
                <h3 class="text-base font-bold text-slate-800 mb-4">Pengaturan Akses Fitur (Gates)</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="is_premium_template_access" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('is_premium_template_access', $package->is_premium_template_access ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Template Premium</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_auto_guest_name" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_auto_guest_name', $package->has_auto_guest_name ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Nama Tamu Otomatis</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_event_countdown" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_event_countdown', $package->has_event_countdown ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Countdown Acara</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_google_maps" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_google_maps', $package->has_google_maps ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Google Maps</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_photo_gallery" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_photo_gallery', $package->has_photo_gallery ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Galeri Foto</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_love_story" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_love_story', $package->has_love_story ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Love Story</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_background_music" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_background_music', $package->has_background_music ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Musik Background</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_digital_envelope" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_digital_envelope', $package->has_digital_envelope ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Amplop Digital</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_guest_comments" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_guest_comments', $package->has_guest_comments ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Ucapan & Doa Tamu</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_rsvp" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_rsvp', $package->has_rsvp ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">RSVP</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_rsvp_stats" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_rsvp_stats', $package->has_rsvp_stats ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Statistik RSVP</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_realtime_tracking" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_realtime_tracking', $package->has_realtime_tracking ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Real-time Tracking Tamu</p></div>
                    </label>
                    
                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_opened_list" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_opened_list', $package->has_opened_list ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Daftar Tamu Sudah Membuka</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_unopened_list" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_unopened_list', $package->has_unopened_list ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Daftar Tamu Belum Membuka</p></div>
                    </label>

                    <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50">
                        <input type="checkbox" name="has_monitoring_dashboard" value="1" class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ old('has_monitoring_dashboard', $package->has_monitoring_dashboard ?? false) ? 'checked' : '' }}>
                        <div><p class="text-sm font-semibold text-slate-800">Dashboard Monitoring</p></div>
                    </label>
                </div>
        </div>

        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('superadmin.packages.index') }}" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-800 transition-colors">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Paket
            </button>
        </div>
    </form>
</div>
@endsection
