@extends('layouts.superadmin')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Pembayaran</h1>
        <p class="text-sm text-slate-500 mt-1">Konfirmasi atau tolak bukti pembayaran langganan dari pengguna.</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-start gap-3">
        <i class="fa-solid fa-circle-check mt-0.5 text-emerald-500"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-start gap-3">
        <i class="fa-solid fa-circle-xmark mt-0.5 text-red-500"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-medium">
                <tr>
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4">Paket</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800">{{ $transaction->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $transaction->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-purple-50 text-purple-700 font-medium text-xs border border-purple-200">
                                {{ $transaction->package->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->status == 'pending')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                </span>
                            @elseif($transaction->status == 'confirmed')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-xs font-semibold border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            {{ $transaction->created_at->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                    x-data 
                                    @click="$dispatch('open-transaction-modal', { 
                                        id: '{{ $transaction->id }}', 
                                        proof: '{{ asset('storage/' . $transaction->proof_of_payment) }}',
                                        notes: '{{ addslashes($transaction->notes) }}',
                                        status: '{{ $transaction->status }}'
                                    })"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                            Belum ada transaksi pembayaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $transactions->links() }}
    </div>
</div>

<!-- Modal Detail Transaksi -->
<div x-data="{ 
        show: false, 
        txId: '', 
        proofUrl: '', 
        notes: '', 
        status: '', 
        rejectionReason: '',
        showRejectForm: false
    }"
    @open-transaction-modal.window="
        show = true; 
        txId = $event.detail.id; 
        proofUrl = $event.detail.proof; 
        notes = $event.detail.notes;
        status = $event.detail.status;
        showRejectForm = false;
        rejectionReason = '';
    "
    x-show="show" 
    style="display: none;"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
>
    <div @click.away="show = false" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-bold text-slate-800">Detail Pembayaran</h3>
            <button @click="show = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <!-- Body -->
        <div class="px-6 py-4 overflow-y-auto">
            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Bukti Transfer</label>
                <div class="bg-slate-100 rounded-xl p-2 border border-slate-200 flex justify-center">
                    <img :src="proofUrl" class="max-w-full max-h-64 object-contain rounded-lg shadow-sm" alt="Bukti Pembayaran">
                </div>
                <div class="mt-2 text-right">
                    <a :href="proofUrl" target="_blank" class="text-xs text-blue-600 hover:underline"><i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Buka gambar di tab baru</a>
                </div>
            </div>

            <div x-show="notes" class="mb-4">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan dari User</label>
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-sm text-slate-700 italic" x-text="notes"></div>
            </div>

            <!-- Formulir Tolak -->
            <div x-show="showRejectForm" class="mt-4 p-4 border border-red-200 bg-red-50 rounded-xl" style="display: none;">
                <label class="block text-sm font-semibold text-red-800 mb-2">Alasan Penolakan</label>
                <form :action="`/superadmin/transactions/${txId}/reject`" method="POST">
                    @csrf
                    <textarea name="rejection_reason" x-model="rejectionReason" rows="3" class="w-full border border-red-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-red-500 outline-none mb-3" placeholder="Masukkan alasan kenapa pembayaran ditolak..."></textarea>
                    <div class="flex gap-2 justify-end">
                        <button type="button" @click="showRejectForm = false" class="px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-200 bg-slate-100 rounded-lg transition">Batal</button>
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-white bg-red-600 hover:bg-red-700 rounded-lg transition" :disabled="!rejectionReason">Tolak Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3" x-show="status === 'pending' && !showRejectForm">
            <button @click="showRejectForm = true" class="px-4 py-2 border border-red-200 text-red-600 hover:bg-red-50 font-semibold text-sm rounded-lg transition shadow-sm">
                <i class="fa-solid fa-xmark mr-1"></i> Tolak
            </button>
            <form :action="`/superadmin/transactions/${txId}/confirm`" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg transition shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-check mr-1"></i> Konfirmasi Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
