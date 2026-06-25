<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Models\ThemeCategory;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::with('category')
            ->orderByRaw('GREATEST(created_at, updated_at) DESC')
            ->paginate(10);
            
        $categories = ThemeCategory::orderBy('name', 'asc')->get();

        return view('superadmin.theme.index', compact('themes', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'theme_category_id' => 'required|exists:theme_categories,id',
            'name'              => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:themes,slug',
            'description'       => 'nullable|string',
            'thumbnail'         => 'nullable|image|max:2048',
            'view_name'         => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'is_premium'        => 'nullable|boolean',
            'is_active'         => 'nullable|boolean',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/themes/thumbnail'), $fileName);
            $thumbnailPath = 'assets/themes/thumbnail/' . $fileName;
        }

        Theme::create([
            'theme_category_id' => $request->theme_category_id,
            'name'              => $request->name,
            'slug'              => $request->slug ?: Str::slug($request->name),
            'description'       => $request->description,
            'thumbnail'         => $thumbnailPath,
            'view_name'         => $request->view_name,
            'price'             => $request->price,
            'is_premium'        => $request->boolean('is_premium'),
            'is_active'         => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Theme berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $theme = Theme::findOrFail($id);

        $request->validate([
            'theme_category_id' => 'required|exists:theme_categories,id',
            'name'              => 'required|string|max:255',
            'slug'              => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('themes', 'slug')->ignore($theme->id),
            ],
            'description'       => 'nullable|string',
            'thumbnail'         => 'nullable|image|max:2048',
            'view_name'         => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'is_premium'        => 'nullable|boolean',
            'is_active'         => 'nullable|boolean',
        ]);

        $data = [
            'theme_category_id' => $request->theme_category_id,
            'name'              => $request->name,
            'slug'              => $request->slug ?: Str::slug($request->name),
            'description'       => $request->description,
            'view_name'         => $request->view_name,
            'price'             => $request->price,
            'is_premium'        => $request->boolean('is_premium'),
            'is_active'         => $request->boolean('is_active'),
        ];

        if ($request->hasFile('thumbnail')) {
            if ($theme->thumbnail && file_exists(public_path($theme->thumbnail))) {
                @unlink(public_path($theme->thumbnail));
            }

            $file = $request->file('thumbnail');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/themes/thumbnail'), $fileName);
            $data['thumbnail'] = 'assets/themes/thumbnail/' . $fileName;
        }

        $theme->update($data);

        return redirect()
            ->back()
            ->with('success', 'Theme berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $theme = Theme::findOrFail($id);

        if ($theme->thumbnail && file_exists(public_path($theme->thumbnail))) {
            @unlink(public_path($theme->thumbnail));
        }

        $theme->delete();

        return redirect()
            ->back()
            ->with('success', 'Theme berhasil dihapus.');
    }

    public function toggleStatus(string $id)
    {
        $theme = Theme::findOrFail($id);
        $theme->update([
            'is_active' => !$theme->is_active,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status theme berhasil diperbarui.');
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
            'type',
            'theme',
            'profile',
            'cover',
            'galleries',
            'events',
        ])->find($invitationId);

        if (!$invitation) {
            abort(404, "Data dummy undangan dengan ID: {$invitationId} tidak ditemukan di database.");
        }

        $invitation->setRelation('theme', $theme);

        return view($theme->view_name, compact('invitation'));
    }
}