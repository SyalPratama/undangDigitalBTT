<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterOtpMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class RegisterOtpController extends Controller
{
    /**
     * Kirim OTP ke email.
     * POST /register/send-otp
     */
    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email       = strtolower(trim($request->email));
        $throttleKey = 'otp_send:' . $email;

        // Rate limit: maks 3x kirim per 10 menit per email
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ], 429);
        }

        RateLimiter::hit($throttleKey, 600); // decay 10 menit

        // Generate OTP 6 digit
        $otp      = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $cacheKey = 'register_otp:' . $email;

        // Simpan OTP di cache, berlaku 10 menit
        Cache::put($cacheKey, $otp, now()->addMinutes(10));

        // Kirim email
        try {
            Mail::to($email)->send(new RegisterOtpMail($otp));
        } catch (\Exception $e) {
            // Hapus OTP dari cache jika email gagal dikirim
            Cache::forget($cacheKey);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email. Pastikan konfigurasi mail sudah benar di .env',
            ], 500);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Verifikasi OTP yang dimasukkan user.
     * POST /register/verify-otp
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'code'  => ['required', 'string', 'size:6'],
        ]);

        $email    = strtolower(trim($request->email));
        $code     = trim($request->code);
        $cacheKey = 'register_otp:' . $email;

        $stored = Cache::get($cacheKey);

        if (!$stored || $stored !== $code) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tidak valid atau sudah kadaluarsa.',
            ]);
        }

        // Tandai email sudah terverifikasi (berlaku 15 menit untuk submit form)
        Cache::put('register_otp_verified:' . $email, true, now()->addMinutes(15));

        // Hapus OTP setelah berhasil diverifikasi (sekali pakai)
        Cache::forget($cacheKey);

        return response()->json(['success' => true]);
    }
}