<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\Invitation;
use Illuminate\Http\Request;

class CusDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama customer (Hanya Daftar Tema)
     */
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $totalInvitations = Invitation::where('user_id', $user->id)->count();
        $recentInvitations = Invitation::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        return view('customer.dashboard', compact(
            'totalInvitations',
            'recentInvitations'
        ));
    }

    public function templates()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $totalInvitations = Invitation::where('user_id', $user->id)->count();
        $activeInvitations = Invitation::where('user_id', $user->id)->where('is_active', true)->count();
        $totalCustomers = 0;

        $recentInvitations = Invitation::where('user_id', $user->id)
            ->with('theme') 
            ->latest()
            ->take(5)
            ->get();

        $themes = Theme::with('category')->get();

        return view('customer.templates', compact(
            'totalInvitations', 
            'activeInvitations', 
            'totalCustomers', 
            'recentInvitations',
            'themes'
        ));
    }

    /**
     * Memproses preview tema berdasarkan UUID dummy masing-masing kategori.
     */
    public function preview(string $id)
    {
        $theme = Theme::with('category')->findOrFail($id);

        if (empty($theme->theme_category_id) || !$theme->category) {
            return response()->view('errors.invalid-theme', compact('theme'), 422);
        }

        $invitationId = '770a3144-67d7-4275-8765-dc802adc0520'; // Default Wedding

        if ($theme->category->slug === 'birthday') {
            $invitationId = '01e8d4a6-2968-4b0a-875a-5001090f89a3'; // Birthday
        } elseif ($theme->category->slug === 'aqiqah') {
            $invitationId = 'b1c67de7-0edf-48f9-ae34-a9423f3832ca'; // Aqiqah
        } elseif ($theme->category->slug === 'khitan') {
            $invitationId = '5719d911-f884-4f32-9bea-d7914b01d08a'; // Khitan
        }

        $invitation = Invitation::with([
            'type', 'theme', 'profile', 'cover', 'galleries', 'events'
        ])->find($invitationId);

        if (!$invitation) {
            abort(404, "Data dummy undangan dengan ID: {$invitationId} tidak ditemukan di database.");
        }

        $invitation->setRelation('theme', $theme);

        return view($theme->view_name, compact('invitation'));
    }
}