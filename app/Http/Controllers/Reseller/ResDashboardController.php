<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResDashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard reseller.
     */
    public function index()
    {
        $totalCustomer = User::where('reseller_id', Auth::id())
            ->whereHas('roles', function ($query) {
                $query->where('name', 'customer');
            })
            ->count();

        $stats = [
            'total_users' => $totalCustomer,
            'active_invitations' => 3420,
            'total_earnings' => 'Rp 15.450.000',
        ];

        return view('reseller.dashboard', compact('stats'));
    }
}