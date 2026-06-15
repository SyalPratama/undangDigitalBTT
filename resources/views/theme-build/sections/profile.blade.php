<section class="py-16 px-6 text-center">
    <div class="max-w-xl mx-auto space-y-6">
        <h2 class="heading text-4xl mb-4">Mempelai</h2>
        <div class="space-y-4">
            <div class="p-6 bg-white/50 rounded-2xl border border-slate-100 shadow-sm">
                <h3 data-preview="first_name" class="text-2xl font-bold">{{ $invitation->profile->first_name }}</h3>
                @php
                    $bData = [];
                    if (isset($invitation) && $invitation->builder && $invitation->builder->project_data) {
                        $bData = is_string($invitation->builder->project_data) ? json_decode($invitation->builder->project_data, true) : $invitation->builder->project_data;
                    }
                    $sParents = $bData['show_parents'] ?? true;
                @endphp
                @if ($sParents)
                <p class="primary opacity-80 text-sm">Putra dari Bpk. <span id="preview-first_father">{{ $invitation->profile->first_father }}</span> & Ibu <span id="preview-first_mother">{{ $invitation->profile->first_mother }}</span></p>
                @endif
            </div>
            <div class="text-2xl font-bold primary">&</div>
            <div class="p-6 bg-white/50 rounded-2xl border border-slate-100 shadow-sm">
                <h3 data-preview="second_name" class="text-2xl font-bold">{{ $invitation->profile->second_name }}</h3>
                @if ($sParents)
                <p class="primary opacity-80 text-sm">Putri dari Bpk. <span id="preview-second_father">{{ $invitation->profile->second_father }}</span> & Ibu <span id="preview-second_mother">{{ $invitation->profile->second_mother }}</span></p>
                @endif
            </div>
        </div>
    </div>
</section>
