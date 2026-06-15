@extends('layouts.superadmin')

@section('title', 'Kelola Theme')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        
        {{-- Header Title --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#4c3a99] rounded-full flex items-center justify-center text-white shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-serif text-3xl font-bold text-slate-900 tracking-tight">Manajemen Tema</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Kelola desain template dan tema visual untuk aplikasi undangan digital Anda.</p>
                </div>
            </div>
            <button onclick="toggleModal('modal-add')"
                class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-2.5 rounded-full font-medium text-[14px] transition-all shadow-sm cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                Tambah Tema Baru
            </button>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100/80 overflow-hidden p-6">

            {{-- Table Container --}}
            <div class="overflow-x-auto transition-all duration-300" id="table-container">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider font-semibold">
                            <th class="pb-3 font-medium">Pratinjau / Tema</th>
                            <th class="pb-3 font-medium">Kategori</th>
                            <th class="pb-3 font-medium">Nama View</th>
                            <th class="pb-3 font-medium">Harga</th>
                            <th class="pb-3 font-medium">Tipe</th>
                            <th class="pb-3 font-medium">Status</th>
                            <th class="pb-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-600 divide-y divide-slate-50">
                        @forelse($themes as $theme)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-14 h-14 rounded-lg bg-slate-100 border border-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                            @if ($theme->thumbnail)
                                                <img src="{{ asset($theme->thumbnail) }}" alt="{{ $theme->name }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <i class="fa-solid fa-image text-slate-300 text-lg"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="font-medium text-slate-800 block">{{ $theme->name }}</span>
                                            <span class="text-xs text-slate-400 font-mono">Slug: {{ $theme->slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-xs font-medium rounded-lg">
                                        {{ $theme->category->name ?? 'Tanpa Kategori' }}
                                    </span>
                                </td>
                                <td class="py-4 font-mono text-xs text-slate-500">{{ $theme->view_name }}</td>
                                <td class="py-4 font-medium text-slate-700">
                                    Rp {{ number_format($theme->price, 0, ',', '.') }}
                                </td>
                                <td class="py-4">
                                    @if ($theme->is_premium)
                                        <span
                                            class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200/40 text-[11px] font-semibold rounded-lg tracking-wide inline-block">
                                            PREMIUM
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-sky-50 text-sky-600 border border-sky-200/40 text-[11px] font-semibold rounded-lg tracking-wide inline-block">
                                            REGULAR
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4">
                                    <form action="{{ route('superadmin.themes.toggle', $theme->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="cursor-pointer">
                                            @if ($theme->is_active)
                                                <span
                                                    class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/40 text-[11px] font-semibold rounded-lg tracking-wide inline-block">
                                                    AKTIF
                                                </span>
                                            @else
                                                <span
                                                    class="px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200/40 text-[11px] font-semibold rounded-lg tracking-wide inline-block">
                                                    NON-AKTIF
                                                </span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 text-right space-x-1 whitespace-nowrap">
                                    {{-- Tombol Preview --}}
                                    <a href="{{ route('superadmin.themes.preview', $theme->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 text-emerald-600 bg-emerald-50 hover:bg-emerald-100/80 border border-emerald-200/30 rounded-xl transition-all cursor-pointer"
                                        title="Pratinjau Tema">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>

                                    {{-- Tombol Edit Tema --}}
                                    <button
                                        onclick="openEditModal('{{ $theme->id }}', '{{ $theme->theme_category_id }}', '{{ addslashes($theme->name) }}', '{{ $theme->slug }}', '{{ $theme->view_name }}', '{{ $theme->price }}', '{{ $theme->is_premium }}', '{{ $theme->is_active }}', '{{ addslashes($theme->description) }}')"
                                        class="inline-flex items-center justify-center w-8 h-8 text-sky-600 bg-sky-50 hover:bg-sky-100/80 border border-sky-200/30 rounded-xl transition-all cursor-pointer"
                                        title="Edit Tema">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <button
                                        onclick="handleDelete('{{ $theme->id }}', '{{ addslashes($theme->name) }}')"
                                        class="inline-flex items-center justify-center w-8 h-8 text-rose-600 bg-rose-50 hover:bg-rose-100/80 border border-rose-200/30 rounded-xl transition-all cursor-pointer"
                                        title="Hapus Tema">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 text-sm">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fa-solid fa-palette text-2xl text-slate-300"></i>
                                        <span>Data tema tidak ditemukan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($themes, 'links'))
                <div class="mt-6 border-t border-slate-50 pt-4">
                    {{ $themes->links() }}
                </div>
            @endif
        </div>
    </div>

    <form id="global-delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- MODAL TAMBAH TEMA --}}
    <div id="modal-add"
        class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-lg p-6 transform transition-all my-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800">Tambah Tema Baru</h3>
                <button onclick="toggleModal('modal-add')"
                    class="text-slate-400 hover:text-slate-600 text-xl cursor-pointer">&times;</button>
            </div>
            <form action="{{ route('superadmin.themes.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori
                        Tema</label>
                    <select name="theme_category_id" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500 bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                            Tema</label>
                        <input type="text" name="name" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Slug
                            (Opsional)</label>
                        <input type="text" name="slug"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500"
                            placeholder="Otomatis jika kosong">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama View
                            File</label>
                        <input type="text" name="view_name" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500"
                            placeholder="contoh: themes.wedding.modern-dark">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Harga
                            (IDR)</label>
                        <input type="number" name="price" value="0" min="0" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">File Gambar
                        Mini (Thumbnail)</label>
                    <input type="file" name="thumbnail" accept="image/*"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-hidden focus:border-sky-500 bg-slate-50 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Deskripsi
                        Tema</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500"></textarea>
                </div>

                <div class="flex flex-wrap gap-6 pt-1">
                    <label class="flex items-center space-x-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="is_premium" value="1"
                            class="w-4 h-4 rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                        <span class="text-sm text-slate-600 font-medium">Set sebagai Tema Premium</span>
                    </label>
                    <label class="flex items-center space-x-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="w-4 h-4 rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                        <span class="text-sm text-slate-600 font-medium">Langsung Aktifkan</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleModal('modal-add')"
                        class="px-4 py-2 text-sm font-medium text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl cursor-pointer">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 rounded-xl shadow-xs cursor-pointer">Simpan
                        Tema</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT TEMA --}}
    <div id="modal-edit"
        class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-lg p-6 transform transition-all my-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Data Tema</h3>
                <button onclick="toggleModal('modal-edit')"
                    class="text-slate-400 hover:text-slate-600 text-xl cursor-pointer">&times;</button>
            </div>
            <form id="form-edit" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Kategori
                        Tema</label>
                    <select name="theme_category_id" id="edit-category-id" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500 bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                            Tema</label>
                        <input type="text" name="name" id="edit-name" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Slug</label>
                        <input type="text" name="slug" id="edit-slug"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama View
                            File</label>
                        <input type="text" name="view_name" id="edit-view-name" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Harga
                            (IDR)</label>
                        <input type="number" name="price" id="edit-price" min="0" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Ubah Thumbnail
                        <span class="text-slate-400 font-normal italic">(Kosongkan jika tidak diganti)</span></label>
                    <input type="file" name="thumbnail" accept="image/*"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-hidden focus:border-sky-500 bg-slate-50 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Deskripsi
                        Tema</label>
                    <textarea name="description" id="edit-description" rows="3"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-sky-500"></textarea>
                </div>

                <div class="flex flex-wrap gap-6 pt-1">
                    <label class="flex items-center space-x-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="is_premium" id="edit-is-premium" value="1"
                            class="w-4 h-4 rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                        <span class="text-sm text-slate-600 font-medium">Set sebagai Tema Premium</span>
                    </label>
                    <label class="flex items-center space-x-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" id="edit-is-active" value="1"
                            class="w-4 h-4 rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                        <span class="text-sm text-slate-600 font-medium">Tema Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleModal('modal-edit')"
                        class="px-4 py-2 text-sm font-medium text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl cursor-pointer">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-xl shadow-xs cursor-pointer">Perbarui
                        Tema</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Opps! Terjadi Kesalahan',
                text: "{!! implode('\n', $errors->all()) !!}",
                confirmButtonColor: '#f43f5e',
                confirmButtonText: 'Perbaiki Data',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 font-medium text-sm cursor-pointer'
                }
            });
        @endif

        function toggleModal(modalId) {
            document.getElementById(modalId).classList.toggle('hidden');
        }

        function openEditModal(id, categoryId, name, slug, viewName, price, isPremium, isActive, description) {
            document.getElementById('form-edit').action = `/superadmin/themes/${id}`;
            document.getElementById('edit-category-id').value = categoryId;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-slug').value = slug;
            document.getElementById('edit-view-name').value = viewName;
            document.getElementById('edit-price').value = price;
            document.getElementById('edit-description').value = (description === 'null' || description === '') ? '' :
                description;

            document.getElementById('edit-is-premium').checked = parseInt(isPremium) === 1;
            document.getElementById('edit-is-active').checked = parseInt(isActive) === 1;

            toggleModal('modal-edit');
        }

        function handleDelete(id, name) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus tema "${name}"? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 font-medium text-sm cursor-pointer',
                    cancelButton: 'rounded-xl px-4 py-2 font-medium text-sm cursor-pointer'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('global-delete-form');
                    form.action = `/superadmin/themes/${id}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
