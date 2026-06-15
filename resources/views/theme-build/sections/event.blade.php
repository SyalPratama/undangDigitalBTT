<section class="py-16 px-6">
    <div class="max-w-xl mx-auto bg-white/60 p-8 rounded-3xl border border-slate-100 shadow-lg text-center">
        <h2 class="heading text-3xl mb-8">Waktu & Tempat</h2>
        <div class="space-y-6">
            <div>
                <p class="text-xs uppercase tracking-widest text-slate-400 font-bold">Tanggal</p>
                <p class="text-lg font-semibold mt-1">{{ date('l, d F Y', strtotime($invitation->event_date)) }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-slate-400 font-bold">Waktu</p>
                <p class="text-lg font-semibold mt-1">{{ date('H:i', strtotime($invitation->event_date)) }} WIB - Selesai
                </p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-widest text-slate-400 font-bold">Lokasi</p>
                <p class="text-sm mt-1 leading-relaxed">{{ $invitation->profile->address }}</p>
            </div>
            <a href="#"
                class="inline-block mt-4 px-6 py-2 bg-primary text-white rounded-full text-sm font-bold hover:opacity-90 transition-all">
                Lihat Lokasi (Maps)
            </a>
        </div>
    </div>
</section>
