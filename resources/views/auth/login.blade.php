<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngajak.my.id | Login</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .input-field {
            width: 100%;
            background: #f8f8fa;
            border: 1.5px solid #ececf0;
            border-radius: 12px;
            padding: 13px 16px 13px 44px;
            font-size: 14px;
            color: #1a1a2e;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .input-field::placeholder { color: #b0b0be; }
        .input-field:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236,72,153,0.08);
            background: #fff;
        }
        .input-field.error { border-color: #ef4444; }

        .input-wrapper { position: relative; }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b0be;
            font-size: 14px;
            pointer-events: none;
        }
        .input-right-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #b0b0be;
            font-size: 14px;
            padding: 4px;
            transition: color 0.2s;
            line-height: 1;
        }
        .input-right-btn:hover { color: #ec4899; }

        .btn-submit {
            width: 100%;
            background: linear-gradient(90deg, #f9a8d4 0%, #ec4899 50%, #a78bfa 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity 0.2s, transform 0.1s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-submit:hover { opacity: 0.92; }
        .btn-submit:active { transform: scale(0.99); }
    </style>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>

<body class="min-h-screen flex flex-col justify-between"
    style="background: linear-gradient(135deg, #fbeaf4 0%, #e0f2fe 50%, #fbcfe8 100%);">

    <div class="flex-1 flex flex-col items-center justify-center p-4 py-10">

        <div class="w-full max-w-md bg-white rounded-3xl p-8 sm:p-10"
            style="box-shadow: 0 8px 40px rgba(219,39,119,0.08), 0 2px 8px rgba(80,40,180,0.06);">

            {{-- Tombol Beranda --}}
            <div class="flex items-center justify-between mb-6">
                <a href="/"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-pink-500 transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    <span>Kembali ke Beranda</span>
                </a>
                <a href="/"
                    class="flex items-center justify-center w-9 h-9 rounded-xl text-white shadow-md shadow-pink-400/20 transition hover:scale-105"
                    style="background: linear-gradient(135deg, #ec4899, #7c3aed);">
                    <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0 -1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"></path>
                        <path d="M20 2v4"></path>
                        <path d="M22 4h-4"></path>
                        <circle cx="4" cy="20" r="2"></circle>
                    </svg>
                </a>
            </div>

            {{-- Header --}}
            <div class="text-center mb-7">
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang Kembali</h2>
                <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola undangan digital Anda</p>
            </div>

            @if (session('status'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-medium rounded-xl px-4 py-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-3.5">
                @csrf

                {{-- Email --}}
                <div>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fa-regular fa-envelope"></i></span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            required autofocus autocomplete="username" placeholder="nama@email.com"
                            class="input-field {{ $errors->get('email') ? 'error' : '' }}" />
                    </div>
                    @if ($errors->get('email'))
                        <p class="mt-1 text-xs font-medium text-red-500">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                {{-- Password --}}
                <div>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                        <input id="password" type="password" name="password"
                            required autocomplete="current-password" placeholder="••••••••"
                            style="padding-right:44px;"
                            class="input-field {{ $errors->get('password') ? 'error' : '' }}" />
                        <button type="button" class="input-right-btn" onclick="togglePassword(this)">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->get('password'))
                        <p class="mt-1 text-xs font-medium text-red-500">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="w-4 h-4 rounded accent-pink-500">
                        <span class="text-xs font-medium text-slate-600">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-xs font-semibold text-pink-600 hover:text-pink-700 hover:underline transition">
                            Lupa sandi?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="btn-submit">
                        <span>Masuk ke Akun</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-5 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Belum memiliki akun?
                    <a href="/register" class="font-bold text-pink-600 hover:text-pink-700 hover:underline transition">Daftar Akun</a>
                </p>
            </div>

        </div>
    </div>

    <footer class="w-full py-4 text-center text-[11px] text-slate-400 font-medium">
        © 2026 PT Berkah Teknologi Terdepan. All rights reserved.
    </footer>

    <script>
        function togglePassword(btn) {
            const input = document.getElementById('password');
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                btn.style.color = '#ec4899';
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                btn.style.color = '';
            }
        }
    </script>

</body>
</html>