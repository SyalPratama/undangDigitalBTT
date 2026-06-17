<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    // Tambahkan parameter Request $request untuk membaca parameter URL
    public function show(Request $request, string $slug)
    {
        $query = Invitation::with([
            'type',
            'theme',
            'profile',
            'cover',
            'galleries',
            'events',
        ])->bySlug($slug);

        if (!$request->has('preview')) {
            $query->active();
        }

        $invitation = $query->firstOrFail();

        if (!$request->has('preview')) {
            $invitation->increment('visitor_count');
        }

        if (!$invitation->theme) {
            abort(404, 'Theme tidak ditemukan.');
        }

        return view(
            $invitation->theme->view_name,
            compact('invitation')
        );
    }

    public function showSubdomain(Request $request, string $subdomain)
    {
        $query = Invitation::with([
            'type',
            'theme',
            'profile',
            'cover',
            'galleries',
            'events',
        ])->where('custom_domain', $subdomain);

        if (!$request->has('preview')) {
            $query->active();
        }

        $invitation = $query->firstOrFail();

        if (!$request->has('preview')) {
            $invitation->increment('visitor_count');
        }

        if (!$invitation->theme) {
            abort(404, 'Theme tidak ditemukan.');
        }

        return view(
            $invitation->theme->view_name,
            compact('invitation')
        );
    }
}