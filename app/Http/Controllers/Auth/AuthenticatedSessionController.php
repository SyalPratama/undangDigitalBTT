<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // 1. Ambil data user yang baru saja login
        $user = Auth::user();

        // 2. Cek role user dan arahkan ke halaman yang sesuai
        if ($user->hasRole('superadmin')) {
            return redirect()->intended(route('superadmin.dashboard', absolute: false));
        } 
        
        if ($user->hasRole('reseller')) {
            return redirect()->intended(route('reseller.dashboard', absolute: false));
        } 
        
        if ($user->hasRole('customer')) {
            return redirect()->intended(route('customer.dashboard', absolute: false));
        }

        // Default redirect jika role tidak cocok dengan di atas
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}