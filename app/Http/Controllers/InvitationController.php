<?php

namespace App\Http\Controllers;

use App\Models\Invitation;

class InvitationController extends Controller
{
    public function show(string $slug)
    {
        $invitation = Invitation::with([
            'type',
            'theme',
            'profile',
            'cover',
            'galleries',
            'events',
        ])
        ->active()
        ->bySlug($slug)
        ->firstOrFail();

        if (!$invitation->theme) {
            abort(404, 'Theme tidak ditemukan.');
        }

        return view(
            $invitation->theme->view_name,
            compact('invitation')
        );
    }
}