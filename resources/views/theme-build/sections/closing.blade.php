<section class="py-20 px-6 text-center">
    <div class="max-w-lg mx-auto">
        <h2 class="heading text-3xl mb-6">Terima Kasih</h2>
        <p id="preview-closing_text" class="text-sm leading-relaxed primary opacity-90">
            {{ $invitation->profile->closing_text ?? 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir di acara pernikahan kami.' }}
        </p>
        <p class="mt-8 font-bold text-lg">Kami yang berbahagia,</p>
        <p class="heading text-2xl mt-2"><span data-preview="first_nickname">{{ $invitation->profile->first_nickname }}</span> &
            <span data-preview="second_nickname">{{ $invitation->profile->second_nickname }}</span></p>
    </div>
</section>
