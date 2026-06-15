<section class="py-16 px-6 text-center">
    <div class="max-w-xl mx-auto space-y-6">
        <h2 class="heading text-4xl mb-4">Mempelai</h2>
        <div class="space-y-4">
            <div class="p-6 bg-white/50 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-2xl font-bold">{{ $invitation->profile->first_name }}</h3>
                <p class="text-slate-500 text-sm">Putra dari Bpk. {{ $invitation->profile->first_father }} & Ibu
                    {{ $invitation->profile->first_mother }}</p>
            </div>
            <div class="text-2xl font-bold primary">&</div>
            <div class="p-6 bg-white/50 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="text-2xl font-bold">{{ $invitation->profile->second_name }}</h3>
                <p class="text-slate-500 text-sm">Putri dari Bpk. {{ $invitation->profile->second_father }} & Ibu
                    {{ $invitation->profile->second_mother }}</p>
            </div>
        </div>
    </div>
</section>
