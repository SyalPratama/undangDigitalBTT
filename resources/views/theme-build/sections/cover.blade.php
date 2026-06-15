<section class="min-h-screen flex flex-col items-center justify-center text-center px-6 py-10">
    <div class="w-full max-w-md">
        @if ($invitation->cover)
            {{-- Foto cover dengan aspect ratio agar tidak pecah --}}
            <div class="aspect-[3/4] overflow-hidden rounded-3xl shadow-2xl mb-8">
                <img src="{{ asset($invitation->cover->file_path) }}" class="w-full h-full object-cover" alt="Cover Image">
            </div>
        @endif

        <p id="preview-headline" class="primary tracking-[0.2em] uppercase text-xs md:text-sm font-semibold">
            {{ $invitation->profile->headline ?? 'Invitation' }}
        </p>

        {{-- Ukuran font menyesuaikan layar --}}
        <h1 class="heading text-4xl md:text-6xl mt-4 leading-tight">
            <span data-preview="first_name">{{ $invitation->profile->first_name }}</span>
            @if ($invitation->profile->second_name)
                <span class="primary block md:inline my-2">&</span>
                <span data-preview="second_name">{{ $invitation->profile->second_name }}</span>
            @endif
        </h1>
    </div>
</section>
