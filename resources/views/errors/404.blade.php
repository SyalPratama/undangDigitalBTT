<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif { font-family: 'Instrument Serif', serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-[#f4e6fa] via-[#e5f4fd] to-[#d6fbfb] min-h-screen flex items-center justify-center p-6 text-slate-800">
    <div class="max-w-md w-full bg-white/70 backdrop-blur-xl rounded-[2.5rem] p-8 md:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white text-center">
        <div class="w-24 h-24 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <i class="fa-solid fa-ghost text-5xl text-rose-400"></i>
        </div>
        <h1 class="font-serif text-[42px] font-bold text-slate-900 tracking-tight leading-none mb-4">404</h1>
        <h2 class="text-lg font-bold text-slate-700 mb-2">Halaman Tidak Ditemukan</h2>
        <p class="text-sm text-slate-500 mb-8 leading-relaxed">
            Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center gap-2 w-full py-3.5 bg-[#6d28d9] hover:bg-[#5b21b6] text-white rounded-full font-semibold text-sm transition-all shadow-md shadow-purple-500/20">
            <i class="fa-solid fa-house"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
