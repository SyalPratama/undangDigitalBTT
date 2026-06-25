<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ngajak.my.id | Set New Password</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

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
        }

        .input-field:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.08);
            background: #fff;
        }

        .input-wrapper {
            position: relative;
            margin-top: 4px;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #b0b0be;
            pointer-events: none;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(90deg, #f9a8d4 0%, #ec4899 50%, #a78bfa 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col justify-center items-center p-4"
    style="background: linear-gradient(135deg, #fbeaf4 0%, #e0f2fe 50%, #fbcfe8 100%);">

    <div class="w-full max-w-md bg-white rounded-3xl p-8 sm:p-10 shadow-xl">

        <div class="text-center mb-7">
            <h2 class="text-xl font-bold text-slate-800">Buat Password Baru</h2>
            <p class="text-xs text-slate-500 mt-2">Silakan masukkan password baru untuk akun Anda.</p>
        </div>

        <form method="POST" action="/reset-password" class="space-y-4">
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="text-xs font-semibold text-slate-600">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" name="email" value="{{ $email }}" readonly
                        class="input-field bg-slate-50 cursor-not-allowed" />
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Password Baru</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" required placeholder="••••••••" class="input-field" />
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600">Konfirmasi Password</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password_confirmation" required placeholder="••••••••"
                        class="input-field" />
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-submit">
                    Reset Password
                </button>
            </div>
        </form>
    </div>

    <footer class="mt-8 text-center text-[11px] text-slate-400 font-medium">
        © 2026 PT Berkah Teknologi Terdepan. All rights reserved.
    </footer>

</body>

</html>
