<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngajak.my.id | Daftar Akun</title>

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
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,0.08);
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
        .input-right-btn:hover { color: #7c3aed; }

        .btn-send-code {
            white-space: nowrap;
            background: #6d28d9;
            color: #fff;
            border: none;
            border-radius: 999px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-send-code:hover { background: #5b21b6; }
        .btn-send-code:active { transform: scale(0.97); }
        .btn-send-code:disabled {
            background: #c4b5fd;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(90deg, #a78bfa 0%, #7c3aed 50%, #6d28d9 100%);
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
        .btn-submit:hover:not(:disabled) { opacity: 0.92; }
        .btn-submit:active:not(:disabled) { transform: scale(0.99); }
        .btn-submit:disabled {
            background: linear-gradient(90deg, #ddd6fe 0%, #c4b5fd 50%, #a78bfa 100%);
            cursor: not-allowed;
        }

        .otp-verified-badge {
            display: none;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #16a34a;
            font-weight: 600;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 6px 10px;
        }
        .otp-verified-badge.show { display: flex; }
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
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-violet-600 transition">
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
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Mulai Petualangan Anda</h2>
                <p class="text-xs text-slate-500 mt-1">Buat akun untuk mendesain undangan digital impian</p>
            </div>

            {{-- Flash error --}}
            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-600 text-xs font-medium rounded-xl px-4 py-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-3.5">
                @csrf
                <input type="hidden" name="otp_verified" id="otpVerifiedInput" value="0">

                {{-- Nama Lengkap --}}
                <div>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fa-regular fa-user"></i></span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            required autofocus autocomplete="name" placeholder="Nama lengkap Anda"
                            class="input-field {{ $errors->get('name') ? 'error' : '' }}" />
                    </div>
                    @if ($errors->get('name'))
                        <p class="mt-1 text-xs font-medium text-red-500">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                {{-- Alamat Email --}}
                <div>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fa-regular fa-envelope"></i></span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            required autocomplete="username" placeholder="nama@email.com"
                            class="input-field {{ $errors->get('email') ? 'error' : '' }}"
                            oninput="onEmailChanged()" />
                    </div>
                    @if ($errors->get('email'))
                        <p class="mt-1 text-xs font-medium text-red-500">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                {{-- Kata Sandi --}}
                <div>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                        <input id="password" type="password" name="password"
                            required autocomplete="new-password" placeholder="Kata sandi"
                            style="padding-right:44px;"
                            class="input-field {{ $errors->get('password') ? 'error' : '' }}" />
                        <button type="button" class="input-right-btn" onclick="togglePassword('password', this)">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->get('password'))
                        <p class="mt-1 text-xs font-medium text-red-500">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                {{-- Konfirmasi Kata Sandi --}}
                <div>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                            required autocomplete="new-password" placeholder="Konfirmasi kata sandi"
                            style="padding-right:44px;"
                            class="input-field {{ $errors->get('password_confirmation') ? 'error' : '' }}" />
                        <button type="button" class="input-right-btn" onclick="togglePassword('password_confirmation', this)">
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                    @if ($errors->get('password_confirmation'))
                        <p class="mt-1 text-xs font-medium text-red-500">{{ $errors->first('password_confirmation') }}</p>
                    @endif
                </div>

                {{-- Kode Verifikasi --}}
                <div>
                    <div class="flex gap-2 items-center">
                        <div class="input-wrapper flex-1">
                            <span class="input-icon"><i class="fa-solid fa-key"></i></span>
                            <input id="verification_code" type="text" name="verification_code"
                                placeholder="Kode verifikasi"
                                maxlength="6"
                                autocomplete="one-time-code"
                                style="letter-spacing:0.1em; padding-right:40px;"
                                class="input-field {{ $errors->get('verification_code') ? 'error' : '' }}"
                                oninput="onOtpInput(this)" />
                            <span id="otpCheckIcon"
                                style="display:none; position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#16a34a; font-size:15px; pointer-events:none;">
                                <i class="fa-solid fa-circle-check"></i>
                            </span>
                        </div>
                        <button type="button" class="btn-send-code" id="sendCodeBtn" onclick="sendVerificationCode()">
                            Kirim Kode
                        </button>
                    </div>

                    <div id="otpHintSent" class="mt-1.5 text-xs text-slate-400" style="display:none;">
                        <i class="fa-regular fa-paper-plane text-violet-400 mr-1"></i>
                        Kode dikirim ke email Anda — cek inbox/spam.
                        <span id="countdownText" class="font-semibold text-violet-500"></span>
                    </div>
                    <div id="otpHintVerified" class="otp-verified-badge mt-1.5">
                        <i class="fa-solid fa-circle-check"></i>
                        Email terverifikasi! Silakan lanjut daftar.
                    </div>
                    <div id="otpHintError" class="mt-1 text-xs font-medium text-red-500" style="display:none;">
                        <i class="fa-solid fa-xmark mr-1"></i>
                        <span id="otpErrorText">Kode tidak valid atau sudah kadaluarsa.</span>
                    </div>

                    @if ($errors->get('verification_code'))
                        <p class="mt-1 text-xs font-medium text-red-500">{{ $errors->first('verification_code') }}</p>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                        <i class="fa-solid fa-lock text-xs" id="submitLockIcon"></i>
                        <span id="submitBtnText">Verifikasi email dulu</span>
                        <svg id="submitArrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px;display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-5 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-pink-600 hover:text-pink-700 hover:underline transition">Masuk di sini</a>
                </p>
            </div>

        </div>
    </div>

    <footer class="w-full py-4 text-center text-[11px] text-slate-400 font-medium">
        © 2026 PT Berkah Teknologi Terdepan. All rights reserved.
    </footer>

    <script>
        let otpVerified = false;
        let countdownInterval = null;

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                btn.style.color = '#7c3aed';
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                btn.style.color = '';
            }
        }

        function onEmailChanged() {
            if (!otpVerified) return;
            // Reset OTP state jika email diubah setelah verifikasi
            otpVerified = false;
            document.getElementById('otpVerifiedInput').value = '0';
            document.getElementById('verification_code').value = '';
            document.getElementById('otpHintVerified').classList.remove('show');
            document.getElementById('otpCheckIcon').style.display = 'none';
            document.getElementById('otpHintSent').style.display = 'none';
            document.getElementById('otpHintError').style.display = 'none';
            setSubmitState(false);
            document.getElementById('sendCodeBtn').disabled = false;
            document.getElementById('sendCodeBtn').textContent = 'Kirim Kode';
            if (countdownInterval) clearInterval(countdownInterval);
            document.getElementById('countdownText').textContent = '';
        }

        function sendVerificationCode() {
            const emailInput = document.getElementById('email');
            const email = emailInput.value.trim();

            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                emailInput.classList.add('error');
                emailInput.focus();
                setTimeout(() => emailInput.classList.remove('error'), 2500);
                showOtpError('Isi alamat email yang valid terlebih dahulu.');
                return;
            }

            const btn = document.getElementById('sendCodeBtn');
            btn.disabled = true;
            btn.textContent = 'Mengirim...';
            document.getElementById('otpHintError').style.display = 'none';

            fetch('{{ route("register.send-otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('otpHintSent').style.display = 'block';
                    startCountdown(120, btn);
                } else {
                    btn.disabled = false;
                    btn.textContent = 'Kirim Kode';
                    showOtpError(data.message || 'Gagal mengirim kode. Coba lagi.');
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.textContent = 'Kirim Kode';
                showOtpError('Terjadi kesalahan jaringan. Periksa koneksi Anda.');
            });
        }

        function startCountdown(seconds, btn) {
            if (countdownInterval) clearInterval(countdownInterval);
            const el = document.getElementById('countdownText');
            let remaining = seconds;
            el.textContent = `(kirim ulang dalam ${remaining}d)`;
            countdownInterval = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(countdownInterval);
                    el.textContent = '';
                    btn.disabled = false;
                    btn.textContent = 'Kirim Ulang';
                } else {
                    el.textContent = `(kirim ulang dalam ${remaining}d)`;
                }
            }, 1000);
        }

        function onOtpInput(input) {
            // Hanya angka
            const code = input.value.replace(/\D/g, '').slice(0, 6);
            input.value = code;
            document.getElementById('otpHintError').style.display = 'none';

            if (code.length < 6) {
                if (otpVerified) {
                    otpVerified = false;
                    document.getElementById('otpVerifiedInput').value = '0';
                    document.getElementById('otpHintVerified').classList.remove('show');
                    document.getElementById('otpCheckIcon').style.display = 'none';
                    setSubmitState(false);
                }
                return;
            }

            // Auto-verify saat 6 digit lengkap
            const email = document.getElementById('email').value.trim();
            verifyOtp(email, code);
        }

        function verifyOtp(email, code) {
            fetch('{{ route("register.verify-otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email, code: code })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    otpVerified = true;
                    document.getElementById('otpVerifiedInput').value = '1';
                    document.getElementById('otpCheckIcon').style.display = 'block';
                    document.getElementById('otpHintSent').style.display = 'none';
                    document.getElementById('otpHintVerified').classList.add('show');
                    setSubmitState(true);
                    if (countdownInterval) clearInterval(countdownInterval);
                    document.getElementById('countdownText').textContent = '';
                } else {
                    otpVerified = false;
                    document.getElementById('otpVerifiedInput').value = '0';
                    document.getElementById('otpCheckIcon').style.display = 'none';
                    document.getElementById('otpHintVerified').classList.remove('show');
                    showOtpError(data.message || 'Kode tidak valid atau sudah kadaluarsa.');
                    setSubmitState(false);
                }
            })
            .catch(() => {
                showOtpError('Gagal memverifikasi. Periksa koneksi Anda.');
            });
        }

        function showOtpError(msg) {
            document.getElementById('otpErrorText').textContent = msg;
            document.getElementById('otpHintError').style.display = 'block';
        }

        function setSubmitState(verified) {
            const btn = document.getElementById('submitBtn');
            const lockIcon = document.getElementById('submitLockIcon');
            const text = document.getElementById('submitBtnText');
            const arrow = document.getElementById('submitArrow');
            btn.disabled = !verified;
            lockIcon.style.display = verified ? 'none' : 'inline';
            arrow.style.display = verified ? 'inline' : 'none';
            text.textContent = verified ? 'Daftar Akun Baru' : 'Verifikasi email dulu';
        }

        // Guard terakhir di sisi client
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!otpVerified) {
                e.preventDefault();
                showOtpError('Verifikasi kode OTP terlebih dahulu sebelum mendaftar.');
            }
        });
    </script>

</body>
</html>