<section class="py-16 px-6">
    <h2 class="heading text-3xl md:text-5xl text-center mb-10">Gallery</h2>
    
    {{-- Grid yang lebih rapi --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5 max-w-5xl mx-auto">
        @foreach ($invitation->galleries as $image)
            {{-- Aspect ratio square agar ukuran foto seragam --}}
            <div class="aspect-square overflow-hidden rounded-xl shadow-sm">
                <img src="{{ asset($image->file_path) }}" 
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" 
                     alt="Gallery Image">
            </div>
        @endforeach
    </div>
</section>