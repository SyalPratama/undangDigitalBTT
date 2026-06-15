<section class="py-16 px-6">
    <div class="max-w-xl mx-auto space-y-8 text-center">
        <h2 class="heading text-4xl mb-8">Rangkaian Acara</h2>
        
        @if($invitation->events && $invitation->events->count() > 0)
            @foreach($invitation->events as $index => $event)
                <div class="bg-white/60 p-8 rounded-3xl border border-slate-100 shadow-lg">
                    <h3 class="heading text-2xl mb-6" data-event-preview="name_{{ $index }}">{{ $event->name }}</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <p class="text-xs uppercase tracking-widest primary opacity-70 font-bold">Tanggal</p>
                            <p class="text-lg font-semibold mt-1" data-event-preview="event_date_{{ $index }}">{{ date('l, d F Y', strtotime($event->event_date)) }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest primary opacity-70 font-bold">Waktu</p>
                            <p class="text-lg font-semibold mt-1">
                                <span data-event-preview="start_time_{{ $index }}">{{ substr($event->start_time, 0, 5) }}</span> WIB - 
                                <span data-event-preview="end_time_{{ $index }}">{{ $event->end_time ? substr($event->end_time, 0, 5) : 'Selesai' }}</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-widest primary opacity-70 font-bold">Tempat</p>
                            <p class="text-md font-semibold mt-1" data-event-preview="venue_name_{{ $index }}">{{ $event->venue_name }}</p>
                            <p class="text-sm mt-1 leading-relaxed primary opacity-90" data-event-preview="address_{{ $index }}">{{ $event->address }}</p>
                        </div>
                        
                        @if($event->google_maps_url)
                        <a href="{{ $event->google_maps_url }}" target="_blank"
                            class="inline-block mt-4 px-6 py-2 bg-primary text-white rounded-full text-sm font-bold hover:opacity-90 transition-all">
                            Lihat Lokasi (Maps)
                        </a>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="bg-white/60 p-8 rounded-3xl border border-slate-100 shadow-lg">
                <p class="primary opacity-80">Belum ada acara yang ditambahkan.</p>
            </div>
        @endif
    </div>
</section>
