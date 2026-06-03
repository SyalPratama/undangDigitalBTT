<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Ngajak.com - Digital Invitation</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-[#fbeaf4] via-[#e0f2fe] to-[#fbcfe8] min-h-screen flex flex-col justify-between selection:bg-pink-200">

    <div class="flex-1 flex flex-col items-center justify-center p-4 my-8">

        <div
            class="w-full max-w-md bg-white/40 backdrop-blur-xl border border-white/60 rounded-3xl p-8 sm:p-10 shadow-[0_20px_50px_rgba(219,39,119,0.06)]">

            <div class="text-center mb-8">
                <a href="/"
                    class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-r from-pink-500 to-sky-500 text-white font-bold text-lg shadow-lg shadow-pink-500/20 mb-4 transition transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="w-6 h-6 transform -rotate-45">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                </a>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Mulai Petualangan Anda</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Buat akun untuk mendesain undangan digital impian</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name"
                        class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        Nama Lengkap
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        autocomplete="name" placeholder="Nama lengkap Anda"
                        class="w-full bg-white/60 border border-pink-200/80 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-400/20 transition duration-200" />
                    @if ($errors->get('name'))
                        <p class="mt-1 text-xs font-medium text-pink-600">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div>
                    <label for="email"
                        class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        Alamat Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="username" placeholder="nama@email.com"
                        class="w-full bg-white/60 border border-pink-200/80 rounded-xl px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-400/20 transition duration-200" />
                    @if ($errors->get('email'))
                        <p class="mt-1 text-xs font-medium text-pink-600">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password"
                        class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            placeholder="••••••••"
                            class="w-full bg-white/60 border border-pink-200/80 rounded-xl pl-4 pr-12 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-400/20 transition duration-200" />
                        <button type="button" onclick="togglePassword('password', 'icon-pass')"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-pink-500 transition cursor-pointer">
                            <i id="icon-pass" class="fa-solid fa-envelope text-base"></i>
                        </button>
                    </div>
                    @if ($errors->get('password'))
                        <p class="mt-1 text-xs font-medium text-pink-600">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div>
                    <label for="password_confirmation"
                        class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            autocomplete="new-password" placeholder="••••••••"
                            class="w-full bg-white/60 border border-pink-200/80 rounded-xl pl-4 pr-12 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-400/20 transition duration-200" />
                        <button type="button" onclick="togglePassword('password_confirmation', 'icon-confirm')"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-pink-500 transition cursor-pointer">
                            <i id="icon-confirm" class="fa-solid fa-envelope text-base"></i>
                        </button>
                    </div>
                    @if ($errors->get('password_confirmation'))
                        <p class="mt-1 text-xs font-medium text-pink-600">{{ $errors->first('password_confirmation') }}
                        </p>
                    @endif
                </div>

                <div class="pt-3">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-pink-500 via-purple-500 to-sky-500 hover:opacity-95 text-white font-semibold py-3 px-4 rounded-xl text-sm shadow-md shadow-pink-500/20 active:scale-[0.99] transition duration-200">
                        Daftar Akun Baru
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-white/40 text-center">
                <p class="text-xs text-slate-500">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}"
                        class="font-bold text-pink-600 hover:text-pink-700 hover:underline transition">Masuk di sini</a>
                </p>
            </div>

        </div>
    </div>

    <footer class="w-full py-4 text-center text-[11px] text-slate-400 font-medium mt-auto">
        © 2026 PT Berkah Teknologi Terdepan. All rights reserved.
    </footer>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                // Ubah input jadi teks biasa (Tampilkan)
                passwordInput.type = "text";
                // Ubah ikon amplop tertutup menjadi amplop terbuka (fa-envelope-open)
                icon.classList.remove("fa-envelope");
                icon.classList.add("fa-envelope-open", "text-pink-500");
            } else {
                // Sembunyikan kembali
                passwordInput.type = "password";
                icon.classList.remove("fa-envelope-open", "text-pink-500");
                icon.classList.add("fa-envelope");
            }
        }
    </script>

</body>

</html>
