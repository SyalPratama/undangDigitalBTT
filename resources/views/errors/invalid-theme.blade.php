<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Tema Tidak Valid - Preview Gagal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body
    class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-6 antialiased selection:bg-indigo-500/30">

    <div class="relative w-full max-w-md">
        <div class="absolute -top-12 -left-12 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-rose-500/10 rounded-full blur-3xl"></div>

        <div
            class="relative bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 text-center shadow-2xl">

            <div
                class="w-16 h-16 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner animate-pulse">
                <i class="fa-solid fa-folder-open text-2xl"></i>
            </div>

            <h1 class="text-xl font-bold text-white mb-2">Kategori Tidak Ditemukan</h1>
            <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                Tema <span class="text-indigo-400 font-medium">"{{ $theme->name }}"</span> tidak dapat ditampilkan
                karena belum dikaitkan dengan kategori undangan apa pun atau data kategori terkait telah dihapus.
            </p>

            <div
                class="bg-slate-900/50 border border-slate-800 rounded-xl p-3 mb-6 text-left font-mono text-xs text-slate-500 space-y-1">
                <div><span class="text-slate-400">Theme ID :</span> {{ $theme->id }}</div>
                <div><span class="text-slate-400">Slug :</span> {{ $theme->slug }}</div>
                <div><span class="text-slate-400">Categories ID :</span> <span
                        class="text-rose-400/80">{{ $theme->theme_category_id ?? 'NULL' }}</span></div>
            </div>

            <div class="flex flex-col gap-2">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center justify-center gap-2 w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-indigo-600/20 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-800">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke Halaman Sebelumnya
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-slate-600 mt-6 font-mono">System Core • Preview Guard</p>
    </div>

</body>

</html>
