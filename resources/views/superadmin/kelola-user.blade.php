@extends('layouts.superadmin')

@section('title', 'Kelola User')

@section('content')
    <div class="space-y-6">
        {{-- Main Card Container --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xs p-6">

            {{-- Bagian Header Kartu --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Daftar Manajemen Pengguna</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Kelola informasi akun pengguna aplikasi undangan digital Anda.
                    </p>
                </div>

                <button onclick="toggleModal('modal-add')"
                    class="bg-sky-500 text-white hover:bg-sky-600 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm shadow-sky-500/10 hover:shadow-md hover:shadow-sky-500/20 cursor-pointer">
                    + Tambah User Baru
                </button>
            </div>

            <div class="flex flex-col md:flex-row gap-3 mb-6 max-w-2xl">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="search-input" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama atau email..."
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
                    <select id="filter-role"
                        class="w-full border border-slate-200 focus:border-sky-500/70 rounded-xl px-3 py-2.5 text-sm focus:outline-hidden bg-slate-50/50 focus:bg-white transition-all cursor-pointer">
                        <option value="">Semua Hak Akses / Role</option>

                        @foreach ($roles as $role)
                            <option value="{{ strtolower($role->name) }}"
                                {{ request('role') == strtolower($role->name) ? 'selected' : '' }}>
                                {{ strtoupper($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto transition-all duration-300" id="table-container">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase tracking-wider font-semibold">
                            <th class="pb-3 font-medium">Nama Pengguna</th>
                            <th class="pb-3 font-medium">Email</th>
                            <th class="pb-3 font-medium">Role</th>
                            <th class="pb-3 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-600 divide-y divide-slate-50">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                <td class="py-4">
                                    <span class="font-medium text-slate-800 block">{{ $user->name }}</span>
                                    <span class="text-xs text-slate-400 font-mono">UUID:
                                        {{ Str::limit($user->id, 8) }}</span>
                                </td>
                                <td class="py-4">{{ $user->email }}</td>
                                <td class="py-4">
                                    @if ($user->roles->isEmpty())
                                        <span
                                            class="px-2.5 py-1 bg-sky-50 text-sky-600 border border-sky-200/40 text-[11px] font-semibold rounded-lg tracking-wide inline-block">
                                            CUSTOMER
                                        </span>
                                    @else
                                        @foreach ($user->roles as $role)
                                            @php
                                                $roleName = strtolower($role->name);
                                                if ($roleName === 'superadmin') {
                                                    $colorClass =
                                                        'bg-emerald-50 text-emerald-700 border border-emerald-200/40';
                                                } elseif ($roleName === 'reseller') {
                                                    $colorClass =
                                                        'bg-amber-50 text-amber-700 border border-amber-200/40';
                                                } elseif ($roleName === 'customer') {
                                                    $colorClass = 'bg-sky-50 text-sky-600 border border-sky-200/40';
                                                } else {
                                                    $colorClass =
                                                        'bg-stone-50 text-stone-600 border border-stone-200/40';
                                                }
                                            @endphp
                                            <span
                                                class="px-2.5 py-1 text-[11px] font-semibold rounded-lg tracking-wide uppercase mr-1 inline-block {{ $colorClass }}">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="py-4 text-right space-x-1 whitespace-nowrap">
                                    <button
                                        onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ json_encode($user->roles->pluck('id')) }}')"
                                        class="inline-flex items-center justify-center w-8 h-8 text-sky-600 bg-sky-50 hover:bg-sky-100/80 border border-sky-200/30 rounded-xl transition-all cursor-pointer"
                                        title="Edit User">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </button>
                                    <button onclick="handleDelete('{{ $user->id }}', '{{ $user->name }}')"
                                        class="inline-flex items-center justify-center w-8 h-8 text-rose-600 bg-rose-50 hover:bg-rose-100/80 border border-rose-200/30 rounded-xl transition-all cursor-pointer"
                                        title="Hapus User">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-slate-400 text-sm">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <i class="fa-solid fa-user-slash text-2xl text-slate-300"></i>
                                        <span>Data pengguna tidak ditemukan atau tidak cocok.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($users, 'links'))
                <div class="mt-6 border-t border-slate-50 pt-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>

    <form id="global-delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- MODAL TAMBAH USER --}}
    <div id="modal-add"
        class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-lg p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800">Tambah User Baru</h3>
                <button onclick="toggleModal('modal-add')"
                    class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <form action="{{ route('superadmin.user.store') }}" method="POST" class="space-y-4" id="form-add">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                        Lengkap</label>
                    <input type="text" name="name" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Pilih Role / Hak
                        Akses</label>
                    <select name="roles[]"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-hidden focus:border-rose-500">
                        <option value="">-- Tanpa Role (Customer) --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ strtoupper($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Password</label>
                    <input type="password" name="password" id="add-password" required
                        oninput="validatePasswordLive('add-password', 'add-password-error')"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-rose-500">
                    <p id="add-password-error" class="text-xs text-rose-500 mt-1 hidden">Password wajib memiliki minimal 8
                        karakter!</p>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleModal('modal-add')"
                        class="px-4 py-2 text-sm font-medium text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl cursor-pointer">Batal</button>
                    <button type="submit" id="add-submit-btn"
                        class="px-4 py-2 text-sm font-medium text-white bg-rose-500 hover:bg-rose-600 rounded-xl shadow-xs cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT USER --}}
    <div id="modal-edit"
        class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-lg p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Data User</h3>
                <button onclick="toggleModal('modal-edit')"
                    class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <form id="form-edit" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nama
                        Lengkap</label>
                    <input type="text" name="name" id="edit-name" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                    <input type="email" name="email" id="edit-email" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-rose-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Pilih Role /
                        Hak Akses</label>
                    <select name="roles[]" id="edit-role"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-hidden focus:border-rose-500">
                        <option value="">-- Tanpa Role (Customer) --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ strtoupper($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Password Baru
                        <span class="text-slate-400 italic font-normal">(Kosongkan jika tidak diganti)</span></label>
                    <input type="password" name="password" id="edit-password"
                        oninput="validatePasswordLive('edit-password', 'edit-password-error', true)"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-hidden focus:border-rose-500">
                    <p id="edit-password-error" class="text-xs text-rose-500 mt-1 hidden">Password baru harus memiliki
                        minimal 8 karakter!</p>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="toggleModal('modal-edit')"
                        class="px-4 py-2 text-sm font-medium text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl cursor-pointer">Batal</button>
                    <button type="submit" id="edit-submit-btn"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 rounded-xl shadow-xs cursor-pointer">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const filterRole = document.getElementById('filter-role');
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

                if (filterRole.value !== "") {
                    url.searchParams.set('role', filterRole.value);
                } else {
                    url.searchParams.delete('role');
                }

                url.searchParams.delete('page');
                window.location.href = url.toString();
            }

            filterRole.addEventListener('change', applyFilters);

            searchInput.addEventListener('input', function() {
                searchLoading.classList.remove('hidden');

                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(applyFilters, 550);
            });

            if (searchInput.value !== "") {
                searchInput.focus();
                const valLength = searchInput.value.length;
                searchInput.setSelectionRange(valLength, valLength);
            }
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

        function openEditModal(id, name, email, rolesJson) {
            document.getElementById('form-edit').action = `/superadmin/kelola-user/${id}`;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-password').value = '';
            document.getElementById('edit-password-error').classList.add('hidden');
            document.getElementById('edit-submit-btn').disabled = false;

            const userRoles = JSON.parse(rolesJson);
            const selectRole = document.getElementById('edit-role');
            selectRole.value = userRoles.length > 0 ? userRoles[0] : "";

            toggleModal('modal-edit');
        }

        function validatePasswordLive(inputId, errorId, isOptional = false) {
            const passwordInput = document.getElementById(inputId);
            const errorText = document.getElementById(errorId);
            const submitBtn = inputId === 'add-password' ? document.getElementById('add-submit-btn') : document
                .getElementById('edit-submit-btn');
            const value = passwordInput.value;

            if (isOptional && value.length === 0) {
                errorText.classList.add('hidden');
                submitBtn.disabled = false;
                passwordInput.classList.remove('border-rose-500');
                return;
            }

            if (value.length < 8) {
                errorText.classList.remove('hidden');
                passwordInput.classList.add('border-rose-500');
                submitBtn.disabled = true;
            } else {
                errorText.classList.add('hidden');
                passwordInput.classList.remove('border-rose-500');
                submitBtn.disabled = false;
            }
        }

        function handleDelete(id, name) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus user "${name}"? Tindakan ini tidak dapat dibatalkan.`,
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
                    form.action = `/superadmin/kelola-user/${id}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
