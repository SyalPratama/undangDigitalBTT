<section class="py-20 px-6 text-center">
    <div class="max-w-lg mx-auto">
        <h2 class="heading text-3xl mb-6">Terima Kasih</h2>
        <p class="text-sm leading-relaxed text-slate-600">
            {{ $invitation->profile->closing_text ?? 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir di acara pernikahan kami.' }}
        </p>
        <p class="mt-8 font-bold text-lg">Kami yang berbahagia,</p>
        <p class="heading text-2xl mt-2">{{ $invitation->profile->first_nickname }} &
            {{ $invitation->profile->second_nickname }}</p>
    </div>
</section>
