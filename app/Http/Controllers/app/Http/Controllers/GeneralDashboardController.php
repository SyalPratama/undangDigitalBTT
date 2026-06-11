<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class GeneralDashboardController extends Controller
{
    public function index()
    {
        // Hitung total undangan dan aktif milik user yang login
        $userId = Auth::id();
        $totalInvitations = Invitation::where('user_id', $userId)->count();
        $activeInvitations = Invitation::where('user_id', $userId)
                                       ->where('status', 'active')
                                       ->count();

        return view('dashboard', compact('totalInvitations', 'activeInvitations'));
    }
}