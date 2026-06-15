<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User; // Ditambahkan untuk menghitung total klien reseller
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class ResDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $totalInvitations = \App\Models\Invitation::where('user_id', $user->id)->count();
        $recentInvitations = \App\Models\Invitation::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        return view('reseller.dashboard', compact(
            'totalInvitations',
            'recentInvitations'
        ));
    }

    public function templates()
    {
        $user = Auth::user();
        
        // 1. Mengambil data ringkasan statistik undangan
        $totalInvitations = Invitation::where('user_id', $user->id)->count();
        $activeInvitations = Invitation::where('user_id', $user->id)->where('is_active', true)->count();

        // 2. Menghitung total pengguna/klien yang berada di bawah naungan reseller ini
        // Memanfaatkan kolom 'reseller_id' yang sudah kamu tambahkan di tabel users
        $totalCustomers = User::where('reseller_id', $user->id)->count();

        // 3. Mengambil 5 undangan terbaru dengan teknik Eager Loading ('with')
        // Ini sangat penting untuk mencegah "N+1 Query Problem" saat memanggil nama tema di halaman Blade
        $recentInvitations = Invitation::where('user_id', $user->id)
            ->with('theme') 
            ->latest()
            ->take(5)
            ->get();

        // Mengambil semua tema untuk ditampilkan dalam bentuk card ke reseller
        $themes = Theme::with('category')->get();

        return view('reseller.templates', compact(
            'totalInvitations', 
            'activeInvitations', 
            'totalCustomers', 
            'recentInvitations',
            'themes'
        ));
    }
}
