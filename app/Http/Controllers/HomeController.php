<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\ThemeCategory;
use App\Models\Invitation;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $themes = Theme::with('category')->get();
        $categories = ThemeCategory::all();

        return view('theme', compact('themes', 'categories'));
    }

    public function preview(string $id)
    {
        $theme = Theme::with('category')->findOrFail($id);

        if (empty($theme->theme_category_id) || !$theme->category) {
            return response()->view('errors.invalid-theme', compact('theme'), 422);
        }

        $invitationId = '770a3144-67d7-4275-8765-dc802adc0520';

        if ($theme->category->slug === 'birthday') {
            $invitationId = '01e8d4a6-2968-4b0a-875a-5001090f89a3';
        } elseif ($theme->category->slug === 'aqiqah') {
            $invitationId = 'b1c67de7-0edf-48f9-ae34-a9423f3832ca';
        } elseif ($theme->category->slug === 'khitan') {
            $invitationId = '5719d911-f884-4f32-9bea-d7914b01d08a';
        } elseif ($theme->category->slug === 'engagement') {
            $invitationId = 'd09be7a2-1111-4444-8888-c7c30c5a1111';
        } elseif ($theme->category->slug === 'graduation') {
            $invitationId = 'd09be7a2-2222-4444-8888-c7c30c5a2222';
        } elseif ($theme->category->slug === 'reuni') {
            $invitationId = 'd09be7a2-3333-4444-8888-c7c30c5a3333';
        } elseif ($theme->category->slug === 'syukuran') {
            $invitationId = 'd09be7a2-4444-4444-8888-c7c30c5a4444';
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