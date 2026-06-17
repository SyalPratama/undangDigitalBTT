<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResPaketController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activePackage = null;

        if ($user && $user->package) {
            $activePackage = [
                'name' => $user->package->name,
                'description' => $user->package->description,
                'price' => 'Rp ' . number_format($user->package->price, 0, ',', '.'),
                'type' => $user->package->duration_days ? 'Per ' . $user->package->duration_days . ' Hari' : 'Selamanya',
                'max_invitations' => $user->package->max_invitations,
            ];
        }

        return view('reseller.paket', compact('user', 'activePackage'));
    }
}
