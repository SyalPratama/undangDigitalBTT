@extends('layouts.customer')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
@section('content')
    <div class="h-[calc(100vh-80px)] flex overflow-hidden bg-slate-100 relative">

        {{-- PANEL SETTING (Sidebar) --}}
        <div id="sidebar"
            class="w-[85%] sm:w-[400px] bg-white border-r border-slate-200 flex flex-col h-full z-30 absolute lg:relative transition-transform duration-300 -translate-x-full lg:translate-x-0 shadow-xl lg:shadow-none">

            <button onclick="toggleSidebar()"
                class="lg:hidden absolute -right-10 top-4 bg-slate-800 text-white w-10 h-10 rounded-r-lg flex items-center justify-center">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="h-14 flex items-center px-6 border-b border-slate-200">
                <h1 class="text-sm font-bold text-slate-800 flex items-center">
                    <i class="fa-solid fa-wand-magic-sparkles mr-2 text-rose-500"></i>Theme Builder
                </h1>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <form method="POST" action="{{ route('theme-builder.update', $invitation->id) }}" id="auto-save-form"
                    enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Warna & Font --}}
                    <div class="space-y-4 mb-6">
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-400">Warna Utama</label>
                                <input type="color" name="primary_color"
                                    class="w-full h-8 rounded-lg cursor-pointer border-0 p-0 auto-save"
                                    value="{{ $invitation->design->primary_color ?? '#000000' }}">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-400">Background</label>
                                <input type="color" name="background_color"
                                    class="w-full h-8 rounded-lg cursor-pointer border-0 p-0 auto-save"
                                    value="{{ $invitation->design->background_color ?? '#ffffff' }}">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-400">Teks</label>
                                <input type="color" name="text_color"
                                    class="w-full h-8 rounded-lg cursor-pointer border-0 p-0 auto-save"
                                    value="{{ $invitation->design->text_color ?? '#333333' }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-400">Font Judul</label>
                                <select name="heading_font" class="w-full text-xs border-slate-200 rounded-lg auto-save">
                                    @foreach (['Playfair Display', 'Poppins', 'Montserrat', 'Dancing Script'] as $font)
                                        <option value="{{ $font }}"
                                            {{ ($invitation->design->heading_font ?? '') == $font ? 'selected' : '' }}>
                                            {{ $font }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-400">Font Isi</label>
                                <select name="body_font" class="w-full text-xs border-slate-200 rounded-lg auto-save">
                                    @foreach (['Montserrat', 'Poppins', 'Open Sans', 'Roboto'] as $font)
                                        <option value="{{ $font }}"
                                            {{ ($invitation->design->body_font ?? '') == $font ? 'selected' : '' }}>
                                            {{ $font }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-[10px] uppercase font-bold text-slate-400">Tambah Section</label>
                        <div class="flex gap-2 mt-1">
                            <select id="newSectionType" class="flex-1 text-xs border-slate-200 rounded-lg">
                                <option value="cover">Cover</option>
                                <option value="quote">Quote</option>
                                <option value="profile">Profile</option>
                                <option value="event">Event</option>
                                <option value="gallery">Gallery</option>
                                <option value="closing">Closing</option>
                                <option value="univ_countdown">Countdown Acara (Univ)</option>
                                <option value="univ_maps">Lokasi Maps (Univ)</option>
                                <option value="univ_rsvp">RSVP (Univ)</option>
                                <option value="univ_comments">Ucapan & Doa (Univ)</option>
                            </select>
                            <button type="button" onclick="addSection()"
                                class="px-4 py-2 bg-slate-800 text-white rounded-lg text-xs font-bold">+</button>
                        </div>
                    </div>

                    <ul id="sectionList" class="space-y-2 mb-6">
                        @foreach ($invitation->design->sections ?? [] as $section)
                            <li class="bg-slate-50 border border-slate-200 p-3 rounded-xl flex justify-between items-center cursor-move"
                                data-type="{{ $section['type'] }}">
                                <span class="text-xs font-semibold text-slate-700 flex items-center">
                                    <i
                                        class="fa-solid fa-grip-vertical text-slate-300 mr-3"></i>{{ ucfirst($section['type']) }}
                                </span>
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" class="section-visible w-4 h-4 rounded-full auto-save"
                                        {{ $section['visible'] ?? true ? 'checked' : '' }}>
                                    <button type="button" onclick="removeSection(this)"
                                        class="text-rose-500 hover:text-rose-700 text-xs"><i
                                            class="fa-solid fa-trash"></i></button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="sections" id="sectionsInput">
                    {{-- Upload Background --}}
                    <div class="mb-6">
                        <label class="text-[10px] uppercase font-bold text-slate-400">Background Image</label>
                        <div class="mt-1 relative group">
                            <div id="image-preview-container"
                                class="{{ $invitation->design->background_image ?? false ? '' : 'hidden' }}">
                                <img id="current-bg-image"
                                    src="{{ $invitation->design->background_image ?? false ? asset($invitation->design->background_image) : '' }}"
                                    class="h-32 w-full object-cover rounded-lg mb-2 border shadow-sm">

                                <button type="button" onclick="removeBackgroundImage()"
                                    class="absolute top-2 right-2 bg-rose-500 text-white p-2 rounded-full shadow-lg hover:bg-rose-600 transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>

                            <input type="file" name="background_image" id="bg-input" accept="image/*"
                                class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 auto-save"
                                onchange="previewImage(event)">
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-4 border-t border-slate-200">
                <button type="submit" form="auto-save-form"
                    class="w-full py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-lg">Simpan
                    Perubahan</button>
            </div>
        </div>

        {{-- Overlay untuk menutup sidebar saat diklik di luar area --}}
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="lg:hidden fixed inset-0 bg-black/50 z-20 hidden"></div>

        {{-- PREVIEW --}}
        <div class="flex-1 flex flex-col items-center justify-start p-4 bg-slate-200 overflow-hidden relative">
            {{-- Tombol untuk membuka sidebar di mobile jika tersembunyi --}}
            <button onclick="toggleSidebar()"
                class="lg:hidden absolute top-4 left-4 bg-slate-800 text-white p-2 rounded-lg z-10">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div id="loader"
                class="absolute top-4 right-4 bg-rose-500 text-white px-4 py-1 rounded-full text-[10px] font-bold uppercase hidden shadow-lg animate-pulse z-50">
                Menyimpan...</div>

            <div class="mb-4 flex bg-white p-1 rounded-lg border border-slate-200 shadow-sm z-10">
                <button id="btn-desktop" class="device-btn px-4 py-2 text-xs font-bold rounded-lg transition"
                    onclick="setDevice('desktop', this)">
                    <i class="fa-solid fa-desktop mr-2"></i>Desktop
                </button>
                <button id="btn-tablet" class="device-btn px-4 py-2 text-xs font-bold rounded-lg transition"
                    onclick="setDevice('tablet', this)">
                    <i class="fa-solid fa-tablet-screen-button mr-2"></i>Tablet
                </button>
                <button id="btn-mobile" class="device-btn px-4 py-2 text-xs font-bold rounded-lg transition"
                    onclick="setDevice('mobile', this)">
                    <i class="fa-solid fa-mobile-screen-button mr-2"></i>Mobile
                </button>
            </div>

            <div id="preview-wrapper"
                class="bg-white shadow-2xl border-[8px] border-slate-800 transition-all duration-300 shrink-0 overflow-auto"
                style="width: 375px; height: 667px; border-radius: 40px; max-width: 100%; max-height: 80vh;">
                <iframe id="preview" src="{{ route('theme-builder.preview', $invitation->id) }}"
                    class="w-full h-full"></iframe>
            </div>
            <div class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest" id="device-label">Mobile View
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        const previewIframe = document.getElementById('preview');

        // Inisialisasi Device
        document.addEventListener('DOMContentLoaded', () => {
            setDevice('mobile', document.getElementById('btn-mobile'));
        });

        async function autoSave() {
            document.getElementById('loader').classList.remove('hidden');
            let data = [];
            document.querySelectorAll('#sectionList li').forEach((el, index) => {
                data.push({
                    type: el.dataset.type,
                    order: index + 1,
                    visible: el.querySelector('.section-visible').checked
                });
            });
            document.getElementById('sectionsInput').value = JSON.stringify(data);

            let formData = new FormData(document.getElementById('auto-save-form'));
            await fetch("{{ route('theme-builder.update', $invitation->id) }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            previewIframe.contentWindow.location.reload();
            document.getElementById('loader').classList.add('hidden');
        }

        function removeSection(btn) {
            btn.closest('li').remove();
            autoSave();
        }

        function addSection() {
            const type = document.getElementById('newSectionType').value;
            const list = document.getElementById('sectionList');
            const li = document.createElement('li');
            li.className =
                "bg-slate-50 border border-slate-200 p-3 rounded-xl flex justify-between items-center cursor-move";
            li.dataset.type = type;
            li.innerHTML =
                `<span class="text-xs font-semibold text-slate-700 flex items-center"><i class="fa-solid fa-grip-vertical text-slate-300 mr-3"></i>${type.charAt(0).toUpperCase() + type.slice(1)}</span>
            <div class="flex items-center gap-3"><input type="checkbox" class="section-visible w-4 h-4 rounded-full auto-save" checked><button type="button" onclick="removeSection(this)" class="text-rose-500 hover:text-rose-700 text-xs"><i class="fa-solid fa-trash"></i></button></div>`;
            list.appendChild(li);
            li.querySelector('.section-visible').addEventListener('change', autoSave);
            autoSave();
        }

        new Sortable(document.getElementById('sectionList'), {
            animation: 150,
            onEnd: autoSave
        });
        document.querySelectorAll('.auto-save').forEach(el => el.addEventListener('change', autoSave));

        window.setDevice = function(type, btnElement) {
            document.querySelectorAll('.device-btn').forEach(btn => btn.classList.remove('bg-slate-100',
                'text-sky-600'));
            if (btnElement) btnElement.classList.add('bg-slate-100', 'text-sky-600');

            const wrapper = document.getElementById('preview-wrapper');
            const label = document.getElementById('device-label');
            if (type === 'desktop') {
                wrapper.style.width = '100%';
                wrapper.style.height = '90%';
                wrapper.style.borderRadius = '0px';
                label.innerText = 'Desktop View';
            } else if (type === 'tablet') {
                wrapper.style.width = '768px';
                wrapper.style.height = '90%';
                wrapper.style.borderRadius = '20px';
                label.innerText = 'Tablet View';
            } else {
                wrapper.style.width = '375px';
                wrapper.style.height = '667px';
                wrapper.style.borderRadius = '40px';
                label.innerText = 'Mobile View';
            }
        }

        // Fungsi Preview Gambar Lokal
        function previewImage(event) {
            const reader = new FileReader();
            const container = document.getElementById('image-preview-container');
            const img = document.getElementById('current-bg-image');

            reader.onload = function() {
                img.src = reader.result;
                container.classList.remove('hidden');
            }

            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }

            // Pemicu auto-save setelah memilih gambar
            autoSave();
        }

        // Fungsi Hapus Gambar (di Database & UI)
        async function removeBackgroundImage() {
            // 1. Tampilkan konfirmasi SweetAlert
            const result = await Swal.fire({
                title: 'Hapus Background?',
                text: "Anda tidak dapat mengembalikan gambar yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Warna merah (rose-600)
                cancelButtonColor: '#64748b', // Warna abu-abu (slate-500)
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                // 2. Tampilkan status loading
                Swal.fire({
                    title: 'Menghapus...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 3. Kirim request ke backend
                let formData = new FormData(document.getElementById('auto-save-form'));
                formData.append('remove_background', '1');

                try {
                    const response = await fetch("{{ route('theme-builder.update', $invitation->id) }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (response.ok) {
                        // 4. Sukses: Update UI
                        document.getElementById('image-preview-container').classList.add('hidden');
                        document.getElementById('bg-input').value = '';
                        previewIframe.contentWindow.location.reload();

                        Swal.fire('Terhapus!', 'Background berhasil dihapus.', 'success');
                    } else {
                        throw new Error('Gagal menghapus');
                    }
                } catch (error) {
                    Swal.fire('Error!', 'Terjadi kesalahan saat menghapus.', 'error');
                }
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');

            // Tampilkan/sembunyikan overlay
            if (overlay.classList.contains('hidden')) {
                overlay.classList.remove('hidden');
            } else {
                overlay.classList.add('hidden');
            }
        }
    </script>
@endpush
