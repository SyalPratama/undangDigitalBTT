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
                    <i class="fa-solid fa-grip-vertical text-slate-300 mr-3"></i>{{ ucfirst($section['type']) }}
                </span>
                <div class="flex items-center gap-3">
                    <input type="checkbox" class="section-visible w-4 h-4 rounded-full auto-save"
                        {{ $section['visible'] ?? true ? 'checked' : '' }}>
                    <button type="button" onclick="removeSection(this)"
                        class="text-rose-500 hover:text-rose-700 text-xs"><i class="fa-solid fa-trash"></i></button>
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

        // 1. Slug Generator
        function generateSlug() {
            const title = document.getElementById('title').value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)+/g, '');
            document.getElementById('slug').value = slug;
        }

        // 2. Toggle Orang Tua
        function toggleParentsForm() {
            const checkbox = document.getElementById('toggle-parents-checkbox');
            const wrapper = document.getElementById('wrapper-parents');
            const boxParent2 = document.getElementById('box-parent-2');

            if (checkbox.checked) {
                wrapper.classList.remove('hidden');
                boxParent2.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
            }
        }

        // 3. Preview Cover Image
        document.getElementById('input-cover').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('cover-preview-img').src = event.target.result;
                    document.getElementById('cover-preview-img').classList.remove('hidden');
                    document.getElementById('cover-placeholder').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // 4. Hapus Foto Galeri (AJAX)
        async function removeGalleryImage(mediaId, btnElement) {
            if (!confirm('Hapus foto ini dari galeri?')) return;

            try {
                const response = await fetch(`/customer/kelola-undangan/media/delete/${mediaId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    btnElement.closest('.gallery-item').remove();
                } else {
                    alert('Gagal menghapus gambar.');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // 5. Tambah Baris Acara Dinamis
        // Inisialisasi index untuk form array events
        let eventIndex = document.querySelectorAll('.event-item').length;

        window.addEventRow = function(data = null) {
            // Cegah error "undefined" jika fungsi dipanggil paksa oleh button onclick
            if (data instanceof Event) data = null;

            const container = document.getElementById('events-container');
            const newRow = document.createElement('div');
            newRow.className = "event-item p-4 bg-slate-50 border border-slate-200 rounded-xl relative space-y-4";

            const defaultDate = new Date();
            defaultDate.setMonth(defaultDate.getMonth() + 1);
            const dateVal = data && data.event_date ? data.event_date.substring(0, 10) : defaultDate.toISOString()
                .substring(0, 10);

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
                <input type="time" name="events[${eventIndex}][start_time]" value="${data && data.start_time ? data.start_time.substring(0,5) : '08:00'}" required class="w-full text-xs bg-white border border-slate-200 rounded-lg px-3 py-2.5 outline-none focus:border-sky-500">
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

        // Fungsi pembantu untuk mengatur visibilitas tombol hapus
        window.updateRemoveButtons = function() {
            const items = document.querySelectorAll('.event-item');
            const buttons = document.querySelectorAll('.btn-remove-event');
            // Jika hanya tersisa 1 acara, sembunyikan tombol hapus agar tidak habis
            buttons.forEach(btn => {
                btn.style.display = items.length > 1 ? 'block' : 'none';
            });
        };

        // Pastikan fungsi updateRemoveButtons dipanggil saat load
        document.addEventListener('DOMContentLoaded', updateRemoveButtons);
        // 6. Listener Auto-Save Global (Debounced)
        let timeout = null;
        document.getElementById('auto-save-form').addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // Panggil fungsi autoSave Anda disini
                console.log("Auto-saving...");
                // autoSave(); 
            }, 1000);
        });

        // Listener untuk file musik
        document.getElementById('input-music').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih File Audio Baru';
            document.getElementById('music-file-name').innerText = fileName;
        });
    </script>
@endpush
