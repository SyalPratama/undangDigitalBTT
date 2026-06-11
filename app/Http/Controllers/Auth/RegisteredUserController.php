<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman form pendaftaran.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun baru.
     * OTP harus sudah diverifikasi sebelum akun bisa dibuat.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'verification_code' => ['required', 'string', 'size:6'],
            'otp_verified'      => ['required', 'in:1'],
        ], [
            'otp_verified.required'         => 'Email belum diverifikasi. Masukkan kode OTP terlebih dahulu.',
            'otp_verified.in'               => 'Email belum diverifikasi. Masukkan kode OTP terlebih dahulu.',
            'verification_code.required'    => 'Kode verifikasi wajib diisi.',
            'verification_code.size'        => 'Kode verifikasi harus tepat 6 digit.',
        ]);

        $email = strtolower(trim($request->email));

        // Double-check di backend: verifikasi OTP harus ada di cache
        $verified = Cache::get('register_otp_verified:' . $email);

        if (!$verified) {
            return back()
                ->withInput($request->except('password', 'password_confirmation', 'verification_code'))
                ->with('error', 'Sesi verifikasi OTP kadaluarsa. Silakan kirim ulang kode.')
                ->withErrors(['verification_code' => 'Kode OTP sudah kadaluarsa. Klik "Kirim Kode" untuk kode baru.']);
        }

        // Buat akun
        $user = User::create([
            'name'     => $request->name,
            'email'    => $email,
            'password' => Hash::make($request->password),
        ]);

        // Hapus flag verifikasi dari cache setelah berhasil
        Cache::forget('register_otp_verified:' . $email);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}