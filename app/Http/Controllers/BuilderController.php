<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationBuilder;
use Illuminate\Support\Facades\View;

class BuilderController extends Controller
{
    public function index(Invitation $invitation)
    {
        $invitation->load([
            'theme',
            'profile',
            'media',
            'events',
        ]);

        $builder = InvitationBuilder::firstOrCreate([
            'invitation_id' => $invitation->id,
        ]);

        // jika pernah diedit
        if ($builder->project_data) {
            return view('builder.index', compact(
                'invitation',
                'builder'
            ));
        }

        // render theme blade menjadi html
        $html = View::make(
            $invitation->theme->view_name,
            compact('invitation')
        )->render();

        return view('builder.index', compact(
            'invitation',
            'builder',
            'html'
        ));
    }
}