<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard superadmin.
     */
    public function index()
    {
        // Hitung total user yang memiliki role 'customer'
        $totalCustomer = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })->count();

        // Hitung total user yang memiliki role 'reseller'
        $totalReseller = User::whereHas('roles', function ($query) {
            $query->where('name', 'reseller');
        })->count();

        // Masukkan data real dari DB ke dalam array stats
        $stats = [
            'total_users' => $totalCustomer,
            'active_invitations' => 3420, // Nanti ini bisa disesuaikan saat model Invitation dibuat
            'total_resellers' => $totalReseller,
            'total_earnings' => 'Rp 15.450.000' // Nanti ini bisa diambil dari tabel transaksi
        ];

        return view('superadmin.dashboard', compact('stats'));
    }
}