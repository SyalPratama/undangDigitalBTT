<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResPaketController extends Controller
{
    private function getPackageDetails($packageName) {
        $packages = [
            'Basic' => [
                'name' => 'Basic',
                'description' => 'Cocok untuk acara intim dan undangan sederhana',
                'price' => 'IDR 99.000',
                'type' => 'One Time',
                'max_invitations' => 1,
                'features' => [
                    '1 undangan digital',
                    'Template standar',
                    'RSVP & buku tamu',
                    'Galeri foto (5 foto)',
                    'Aktif 30 hari',
                ],
            ],
            'Premium' => [
                'name' => 'Premium',
                'description' => 'Pilihan paling populer untuk acara pernikahan',
                'price' => 'IDR 249.000',
                'type' => 'One Time',
                'max_invitations' => 3,
                'features' => [
                    '3 undangan digital',
                    'Semua template premium',
                    'RSVP, buku tamu, lucky draw',
                    'Galeri foto unlimited',
                    'Musik latar custom',
                    'Aktif 90 hari',
                    'Prioritas support'
                ],
            ],
            'Enterprise' => [
                'name' => 'Enterprise',
                'description' => 'Untuk reseller & event organizer',
                'price' => 'IDR 999.000',
                'type' => 'Per Bulan',
                'max_invitations' => 'Unlimited',
                'features' => [
                    'Unlimited undangan',
                    'Semua fitur premium',
                    'Custom domain',
                    'White-label brand',
                    'Akses reseller dashboard',
                    'Priority 24/7 support'
                ],
            ],
        ];

        return $packages[$packageName] ?? null;
    }

    public function index()
    {
        $user = auth()->user();
        $activePackage = null;
        if ($user && $user->active_package) {
            $activePackage = $this->getPackageDetails($user->active_package);
        }

        return view('reseller.paket', compact('user', 'activePackage'));
    }
}
