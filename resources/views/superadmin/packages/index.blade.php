@extends('layouts.superadmin')

@section('title', 'Kelola Paket & Harga')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Paket & Harga</h1>
        <p class="text-sm text-slate-500 mt-1">Atur daftar paket berlangganan, harga, dan fitur (gates) yang tersedia untuk pelanggan.</p>
    </div>
    <a href="{{ route('superadmin.packages.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
        <i class="fa-solid fa-plus"></i> Tambah Paket
    </a>
</div>

@if (session('success'))
    <div class="mb-6 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-100 flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                <tr>
                    <th class="px-6 py-4">Nama Paket</th>
                    <th class="px-6 py-4">Harga (Rp)</th>
                    <th class="px-6 py-4">Masa Aktif</th>
                    <th class="px-6 py-4">Fitur Inti</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($packages as $package)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $package->name }}</div>
                            <div class="text-xs text-slate-500 mt-0.5 w-48 truncate" title="{{ $package->description }}">{{ $package->description ?: 'Tidak ada deskripsi' }}</div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            {{ number_format($package->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 bg-sky-50 text-sky-700 px-2.5 py-1 rounded-lg text-xs font-semibold border border-sky-100">
                                <i class="fa-regular fa-calendar"></i> {{ $package->active_days }} Hari
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if($package->is_premium_template_access)
                                    <span class="text-[10px] bg-amber-50 text-amber-700 px-2 py-0.5 rounded border border-amber-200 font-bold" title="Premium Template">Tpl Premium</span>
                                @endif
                                @if($package->has_rsvp)
                                    <span class="text-[10px] bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-200 font-bold" title="RSVP Access">RSVP</span>
                                @endif
                                @if($package->has_monitoring_dashboard)
                                    <span class="text-[10px] bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded border border-emerald-200 font-bold" title="Dashboard">Dashboard</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($package->is_active)
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-semibold border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-slate-50 text-slate-600 px-2.5 py-1 rounded-full text-xs font-semibold border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('superadmin.packages.edit', $package->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors" title="Edit">
                                <i class="fa-solid fa-pen-to-square text-sm"></i>
                            </a>
                            <form action="{{ route('superadmin.packages.destroy', $package->id) }}" method="POST" class="inline-block" id="delete-form-{{ $package->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $package->id }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 text-slate-400 mb-3">
                                <i class="fa-solid fa-box-open text-xl"></i>
                            </div>
                            <p class="font-medium text-slate-600">Belum ada paket.</p>
                            <p class="text-sm mt-1">Silakan tambahkan paket berlangganan baru untuk ditampilkan kepada pelanggan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($packages->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $packages->links() }}
        </div>
    @endif
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Paket?',
        text: 'Apakah Anda yakin ingin menghapus paket ini? Pengguna yang sudah membeli mungkin akan terdampak.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f43f5e',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-2xl',
            confirmButton: 'rounded-full px-6 font-semibold',
            cancelButton: 'rounded-full px-6 font-semibold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection
