<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class ThemeBuildController extends Controller
{
    /**
     * Halaman builder
     */
    public function edit(Invitation $invitation)
    {
        $invitation->load(['theme', 'design', 'profile', 'media', 'events']);

        // Pastikan design ada, jika tidak buat default
        if (!$invitation->design) {
            $invitation->design()->create([
                'sections' => $this->getDefaultSections(),
            ]);
            $invitation->refresh(); // Refresh agar relasi design terisi
        }

        return view('theme-build.edit', compact('invitation'));
    }

    /**
     * Update design (Auto-save utama)
     */
    public function update(Request $request, Invitation $invitation)
    {
        $data = $request->validate([
            'primary_color'    => 'nullable|string',
            'background_color' => 'nullable|string',
            'text_color'       => 'nullable|string',
            'heading_font'     => 'nullable|string',
            'body_font'        => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cover_image'      => 'nullable|string',
            'ornament_image'   => 'nullable|string',
            'sections'         => 'nullable',
            'settings'         => 'nullable|array'
        ]);

        // 1. Logika Hapus Gambar jika flag dikirim dari JavaScript
        if ($request->has('remove_background') || $request->has('remove_background_image')) {
            $design = $invitation->design;
            if ($design && $design->background_image && file_exists(public_path($design->background_image))) {
                unlink(public_path($design->background_image));
            }
            // Pastikan field di database menjadi null
            $invitation->design()->update(['background_image' => null]);
        }

        $data = $request->except(['background_image', 'remove_background']);

        // 2. Proses Upload File Baru
        if ($request->hasFile('background_image')) {
            // Hapus file lama jika ada sebelum upload yang baru
            $oldImage = $invitation->design->background_image ?? null;
            if ($oldImage && file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }

            $file = $request->file('background_image');
            $filename = 'bg_' . $invitation->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            $file->move(public_path('assets/themes/build'), $filename);
            $data['background_image'] = 'assets/themes/build/' . $filename;
        }

        // 3. Handle sections JSON
        if (isset($data['sections']) && is_string($data['sections'])) {
            $data['sections'] = json_decode($data['sections'], true);
        } else {
            $data['sections'] = $invitation->design->sections ?? [];
        }

        // 4. Merge Settings
        if (isset($data['settings']) && is_array($data['settings'])) {
            $existingSettings = $invitation->design->settings ?? [];
            $data['settings'] = array_merge($existingSettings, $data['settings']);
        }

        $invitation->design()->updateOrCreate(
            ['invitation_id' => $invitation->id],
            $data
        );

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success']);
        }

        return back()->with('success', 'Design berhasil diperbarui');
    }

    /**
     * Simpan posisi drag drop (API endpoint)
     */
    public function updateSections(Request $request, Invitation $invitation)
    {
        $request->validate([
            'sections' => 'required|array'
        ]);

        $invitation->design()->update([
            'sections' => $request->sections
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Section updated'
        ]);
    }

    /**
     * Preview
     */
    public function preview(Invitation $invitation)
{
    $invitation->load(['theme', 'design', 'profile', 'media', 'events']);
    
    // Sama, pastikan di preview juga aman
    if ($invitation->design && is_string($invitation->design->sections)) {
        $invitation->design->sections = json_decode($invitation->design->sections, true);
    }

    return view('theme-build.show', compact('invitation'));
}

    /**
     * Helper untuk mendapatkan struktur section default
     */
    private function getDefaultSections(): array
    {
        return [
            ['type' => 'cover', 'order' => 1, 'visible' => true],
            ['type' => 'quote', 'order' => 2, 'visible' => true],
            ['type' => 'profile', 'order' => 3, 'visible' => true],
            ['type' => 'event', 'order' => 4, 'visible' => true],
            ['type' => 'gallery', 'order' => 5, 'visible' => true],
            ['type' => 'closing', 'order' => 6, 'visible' => true],
        ];
    }
}