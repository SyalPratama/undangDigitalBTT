@extends('layouts.reseller')

@section('title', 'Peta Lokasi')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex items-center gap-2 mb-2 text-sm text-slate-500">
        <a href="{{ route('reseller.kelola-undangan.index') }}" class="hover:text-[#6d28d9] transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke undangan
        </a>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none">Peta Lokasi</h1>
            <p class="text-slate-500 mt-1">{{ $invitation->title }}</p>
        </div>
    </div>

    <div class="bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] p-12 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] min-h-[400px] flex flex-col w-full">
        <h3 class="text-xl font-bold text-slate-800 mb-2">Peta Persebaran Tamu</h3>
        <p class="text-sm text-slate-500 mb-6">Lokasi diambil dari tamu yang telah membagikan lokasi pada hari-H.</p>

        @if($guests->isEmpty())
            <div class="text-center text-slate-400 my-auto">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                <h3 class="text-lg font-bold text-slate-700 mb-2">Belum Ada Lokasi</h3>
                <p class="text-[15px] font-medium max-w-md mx-auto">Belum ada tamu yang membagikan lokasi mereka saat ini.</p>
            </div>
        @else
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <style>
                #guestMap { height: 500px; width: 100%; border-radius: 1rem; z-index: 10; }
            </style>
            
            <div id="guestMap"></div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const guests = @json($guests);
                    
                    // Default center to Indonesia if no guests
                    let center = [-2.5489, 118.0149];
                    let zoom = 5;
                    
                    if (guests.length > 0) {
                        center = [guests[0].latitude, guests[0].longitude];
                        zoom = 12;
                    }

                    const map = L.map('guestMap').setView(center, zoom);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    const markers = [];

                    guests.forEach(guest => {
                        if(guest.latitude && guest.longitude) {
                            const marker = L.marker([guest.latitude, guest.longitude]).addTo(map);
                            marker.bindPopup(`<b>${guest.name || 'Tamu'}</b><br>Status: ${guest.status}`);
                            markers.push(marker);
                        }
                    });

                    if (markers.length > 1) {
                        const group = new L.featureGroup(markers);
                        map.fitBounds(group.getBounds().pad(0.1));
                    }
                });
            </script>
        @endif
    </div>
</div>
@endsection
