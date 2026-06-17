@extends('layouts.customer')

@section('title', 'Invitations')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">Invitations</h1>
            
            <a href="{{ route('customer.kelola-undangan.create') }}" class="inline-flex items-center gap-2 bg-[#6d28d9] hover:bg-[#5b21b6] text-white px-6 py-2.5 rounded-full font-medium text-[14px] transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                New
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl shadow-sm flex items-start gap-3">
                <svg class="w-6 h-6 shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        {{-- Search/Filter if needed --}}
        <form method="GET" action="{{ route('customer.kelola-undangan.index') }}" class="flex gap-3 mb-6 hidden">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invitations..." class="border border-white bg-white/60 backdrop-blur-md rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 w-64 shadow-sm">
            <button type="submit" class="bg-white/60 backdrop-blur-md border border-white px-4 py-2 rounded-xl text-slate-600 hover:bg-white shadow-sm text-sm">Search</button>
        </form>

        {{-- Invitations List --}}
        <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] border border-white">
            
            <div class="divide-y divide-slate-100/60">
                @forelse($invitations as $invitation)
                    <div class="py-5 flex flex-col md:flex-row md:items-center justify-between gap-4 group transition-colors">
                        <div>
                            <h4 class="text-[16px] font-semibold text-slate-900">{{ $invitation->title }}</h4>
                            <p class="text-[12px] text-slate-500 mt-1">
                                {{ $invitation->custom_domain ? route('invitation.subdomain', ['subdomain' => $invitation->custom_domain]) : route('invitation.show', $invitation->slug) }} &middot; {{ $invitation->visitor_count ?? 0 }} views
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-3 shrink-0">
                            {{-- Draft/Live Badge --}}
                            @if($invitation->is_active)
                                <span class="inline-flex px-3 py-1.5 bg-purple-100/50 text-[#6d28d9] rounded-full text-[11px] font-semibold tracking-wide" id="badge-{{ $invitation->id }}">
                                    Live
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1.5 bg-slate-100/80 text-slate-500 rounded-full text-[11px] font-semibold tracking-wide" id="badge-{{ $invitation->id }}">
                                    Draft
                                </span>
                            @endif
                            
                            {{-- Share Link Button --}}
                            <button type="button" 
                                onclick="shareLink('{{ $invitation->id }}', '{{ $invitation->custom_domain ? route('invitation.subdomain', ['subdomain' => $invitation->custom_domain]) : route('invitation.show', $invitation->slug) }}', {{ $invitation->is_active ? 'true' : 'false' }}, '{{ route('customer.kelola-undangan.toggle-status', $invitation->id) }}')" 
                                class="p-2 text-slate-400 hover:text-[#6d28d9] transition-colors" 
                                title="Share / Go Live">
                                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </button>
                            
                            {{-- Tamu & Lokasi Button --}}
                            @if(auth()->user()->hasFeature('has_rsvp'))
                                <a href="{{ route('customer.kelola-undangan.guests', $invitation->id) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-purple-100/50 text-[#6d28d9] rounded-full text-[11px] font-bold tracking-wide hover:bg-purple-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Tamu & Lokasi
                                </a>
                            @else
                                <button onclick="showLockedAlert('Tamu & Lokasi', '{{ route('customer.paket.index') }}')" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-slate-100 text-slate-400 rounded-full text-[11px] font-bold tracking-wide cursor-pointer hover:bg-slate-200 transition-colors" title="Upgrade paket untuk fitur Tamu & Lokasi">
                                    <i class="fa-solid fa-lock text-[10px]"></i> Tamu & Lokasi
                                </button>
                            @endif
                            
                            {{-- Peta Button --}}
                            <a href="{{ route('customer.kelola-undangan.map', $invitation->id) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-purple-100/50 text-[#6d28d9] rounded-full text-[11px] font-bold tracking-wide hover:bg-purple-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                                Peta
                            </a>

                            {{-- Edit Button --}}
                            <a href="{{ route('customer.kelola-undangan.edit', $invitation->id) }}" class="p-2 text-slate-400 hover:text-slate-700 transition-colors ml-2" title="Edit">
                                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            
                            {{-- Delete Button --}}
                            <form action="{{ route('customer.kelola-undangan.destroy', $invitation->id) }}" method="POST" class="inline-block" id="delete-form-{{ $invitation->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $invitation->id }}')" class="p-2 text-rose-400 hover:text-rose-600 transition-colors" title="Delete">
                                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100/50 mb-4 text-slate-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-1">No invitations found</h3>
                        <p class="text-slate-500 text-[14px]">Get started by creating a new invitation.</p>
                    </div>
                @endforelse
            </div>
            
            @if(method_exists($invitations, 'links') && $invitations->hasPages())
                <div class="pt-6 mt-4 border-t border-slate-100/60">
                    {{ $invitations->links() }}
                </div>
            @endif

        </div>
    </div>

    {{-- Script for auto live and copy link --}}
    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Undangan?',
            text: 'Tindakan ini tidak dapat dibatalkan.',
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

    function shareLink(id, url, isActive, toggleUrl) {
        // Copy to clipboard first
        navigator.clipboard.writeText(url).then(() => {
            Swal.fire({
                title: 'Disalin!',
                text: 'Link undangan berhasil disalin ke clipboard.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
                customClass: { popup: 'rounded-xl' }
            });
        });

        // If not active, auto toggle to active via ajax
        if (!isActive) {
            fetch(toggleUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    let badge = document.getElementById('badge-' + id);
                    if (badge) {
                        badge.className = "inline-flex px-3 py-1.5 bg-purple-100/50 text-[#6d28d9] rounded-full text-[11px] font-semibold tracking-wide";
                        badge.innerText = "Live";
                    }
                    // Update the onclick property to reflect true so it doesn't trigger again
                    event.currentTarget.setAttribute('onclick', `shareLink('${id}', '${url}', true, '${toggleUrl}')`);
                }
            }).catch(error => console.error('Error toggling status:', error));
        }
    }
    </script>
@endsection
