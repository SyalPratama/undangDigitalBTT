<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class GeneralDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return redirect()->route('superadmin.dashboard');
        }

        if ($user->hasRole('reseller')) {
            return redirect()->route('reseller.dashboard');
        }

        if ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard');
        }

        $totalInvitations = Invitation::where('user_id', $user->id)->count();
        $activeInvitations = Invitation::where('user_id', $user->id)
                                       ->where('is_active', true)
                                       ->count();

        $totalCustomers = 0;
        $recentInvitations = collect();

        return view('dashboard', compact(
            'totalInvitations',
            'activeInvitations',
            'totalCustomers',
            'recentInvitations'
        ));
    }
}