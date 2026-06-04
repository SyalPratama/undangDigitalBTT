<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Theme;
use App\Models\Invitation;
use App\Models\InvitationType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KelolaUndanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Invitation::with([
            'type',
            'theme',
            'profile',
            'cover',
            'galleries',
            'events',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('slug', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('invitation_type_id', $request->type);
        }

        $invitations = $query->latest()->paginate(10);
        $types = InvitationType::orderBy('name')->get();

        return view('superadmin.kelola-undangan.index', compact('invitations', 'types'));
    }

    public function create()
    {
        $types = InvitationType::orderBy('name')->get();
        $themes = Theme::orderBy('name')->get();

        return view('superadmin.kelola-undangan.create', compact('types', 'themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:invitations,slug',
            'theme_id' => 'required|exists:themes,id',
            'invitation_type_id' => 'required|exists:invitation_types,id',
        ]);

        Invitation::create([
            'user_id' => Auth::id(),
            'theme_id' => $request->theme_id,
            'invitation_type_id' => $request->invitation_type_id,
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'is_active' => false,
        ]);

        return redirect()
            ->route('superadmin.kelola-undangan.index')
            ->with('success', 'Undangan berhasil dibuat.');
    }

    public function edit($id)
    {
        $invitation = Invitation::findOrFail($id);
        $types = InvitationType::orderBy('name')->get();
        $themes = Theme::orderBy('name')->get();

        return view('superadmin.kelola-undangan.edit', compact('invitation', 'types', 'themes'));
    }

    public function update(Request $request, $id)
    {
        $invitation = Invitation::findOrFail($id);

        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:invitations,slug,' . $id,
            'theme_id' => 'required|exists:themes,id',
            'invitation_type_id' => 'required|exists:invitation_types,id',
        ]);

        $invitation->update([
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'theme_id' => $request->theme_id,
            'invitation_type_id' => $request->invitation_type_id,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()
            ->route('superadmin.kelola-undangan.index')
            ->with('success', 'Undangan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->delete();

        return back()->with('success', 'Undangan berhasil dihapus.');
    }
}