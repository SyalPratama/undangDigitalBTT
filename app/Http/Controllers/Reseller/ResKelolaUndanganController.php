<?php

namespace App\Http\Controllers\Reseller;

use App\Models\Theme;
use App\Models\User;
use App\Models\Invitation;
use App\Models\InvitationType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResKelolaUndanganController extends Controller
{
    public function index(Request $request)
    {
        $customerIds = User::where('reseller_id', Auth::id())
            ->pluck('id');

        $query = Invitation::with([
            'type',
            'theme',
            'profile',
            'cover',
            'galleries',
            'events',
        ])->whereIn('user_id', $customerIds);

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

        return view('reseller.kelola-undangan.index', compact('invitations', 'types'));
    }

    public function create(Request $request)
    {
        if ($request->has('theme_id')) {
            $theme = Theme::find($request->theme_id);
            if ($theme) {
                // Buat draft awal agar data template terisi otomatis
                $invitation = Invitation::create([
                    'user_id' => Auth::id(),
                    'theme_id' => $theme->id,
                    'invitation_type_id' => InvitationType::first()->id ?? null,
                    'title' => 'Undangan ' . $theme->name,
                    'slug' => Str::slug('undangan-' . $theme->name . '-' . Str::random(5)),
                    'event_date' => now()->addMonths(1)->format('Y-m-d'),
                    'is_active' => false,
                ]);
                
                $invitation->profile()->create([
                    'id' => (string) Str::uuid(),
                    'first_name' => 'Romeo',
                    'first_nickname' => 'Romeo',
                    'second_name' => 'Juliet',
                    'second_nickname' => 'Juliet',
                    'headline' => 'The Wedding Of',
                    'closing_text' => 'Merupakan suatu kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.',
                ]);
                
                $invitation->events()->create([
                    'id' => (string) Str::uuid(),
                    'name' => 'Resepsi Pernikahan',
                    'event_date' => now()->addMonths(1)->format('Y-m-d'),
                    'start_time' => '09:00',
                    'venue_name' => 'Gedung Pernikahan',
                    'address' => 'Jl. Contoh No. 123',
                    'sort_order' => 1,
                    'is_active' => true,
                ]);

                return redirect()->route('reseller.kelola-undangan.edit', $invitation->id)->with('success', 'Template berhasil digunakan. Silakan sesuaikan data undangan.');
            }
        }

        $types = InvitationType::orderBy('name')->get();
        // Load themes beserta slug category-nya dari tabel relasi agar bisa di filter JS
        $themes = DB::table('themes')
            ->leftJoin('theme_categories', 'themes.theme_category_id', '=', 'theme_categories.id')
            ->select('themes.id', 'themes.name', 'theme_categories.slug as category_slug')
            ->where('themes.is_active', true)
            ->orderBy('themes.name')
            ->get();

        $invitation = new Invitation(); // Instance kosong aman untuk create form

        return view('reseller.kelola-undangan.form', compact('types', 'themes', 'invitation'));
    }

    public function edit($id)
    {
        $types = InvitationType::orderBy('name')->get();
        $themes = DB::table('themes')
            ->leftJoin('theme_categories', 'themes.theme_category_id', '=', 'theme_categories.id')
            ->select('themes.id', 'themes.name', 'theme_categories.slug as category_slug')
            ->where('themes.is_active', true)
            ->orderBy('themes.name')
            ->get();
        
        // Pastikan hanya bisa membuka data miliknya sendiri atau milik customernya
        $customerIds = \App\Models\User::where('reseller_id', Auth::id())->pluck('id')->push(Auth::id());
        $invitation = Invitation::whereIn('user_id', $customerIds)
            ->with(['profile', 'events', 'media', 'builder'])
            ->findOrFail($id);

        return view('reseller.kelola-undangan.form', compact('types', 'themes', 'invitation'));
    }

    public function save(Request $request, $id = null)
    {
        $invitation = null;
        $isEdit = false;

        if ($id) {
            $customerIds = \App\Models\User::where('reseller_id', Auth::id())->pluck('id')->push(Auth::id());
            $invitation = Invitation::whereIn('user_id', $customerIds)->find($id);
            if ($invitation) {
                $isEdit = true;
            }
        }

        Log::info($isEdit ? '=== MEMULAI PROSES UPDATE UNDANGAN ===' : '=== MEMULAI PROSES SIMPAN UNDANGAN ===', [
            'user_id'       => Auth::id(),
            'invitation_id' => $id,
            'title'         => $request->title,
        ]);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'title'              => 'required|max:255',
            'slug'               => 'required|max:255|unique:invitations,slug,' . ($isEdit ? $id : 'NULL') . ',id',
            'theme_id'           => 'required|exists:themes,id',
            'invitation_type_id' => 'required|exists:invitation_types,id',
            'event_date'         => 'required|date',
            'password'           => 'nullable|string|min:4',
            'custom_domain'      => 'nullable|string|max:255',
            'first_name'         => 'required|string|max:255',
            'first_nickname'     => 'required|string|max:255',
            'second_name'        => 'nullable|string|max:255',
            'second_nickname'    => 'nullable|string|max:255',
            'events'             => 'required|array|min:1',
            'events.*.name'      => 'required|string|max:255',
            'events.*.event_date'=> 'required|date',
            'events.*.start_time'=> 'required',
            'events.*.venue_name'=> 'required|string|max:255',
            'events.*.address'   => 'required|string',
            'media_cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'media_gallery.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'media_music'        => 'nullable|file|mimes:mp3,wav,ogg|max:15360',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $invitationType = InvitationType::findOrFail($request->invitation_type_id);
        $folderName = Str::slug($invitationType->name); 
        $destinationPath = public_path("assets/{$folderName}");

        try {
            DB::transaction(function () use ($request, $isEdit, $folderName, $destinationPath, &$invitation, $invitationType) {
                
                $invitationData = [
                    'theme_id'           => $request->theme_id,
                    'invitation_type_id' => $request->invitation_type_id,
                    'title'              => $request->title,
                    'slug'               => Str::slug($request->slug),
                    'event_date'         => $request->event_date,
                    'custom_domain'      => $request->custom_domain,
                ];

                if ($request->filled('password')) {
                    $invitationData['password'] = bcrypt($request->password);
                }

                if ($isEdit) {
                    $invitation->update($invitationData);
                } else {
                    $invitationData['user_id'] = Auth::id();
                    $invitationData['is_active'] = false; 
                    $invitation = Invitation::create($invitationData);
                }

                $isDoubleParty = in_array($invitationType->slug, ['wedding', 'pernikahan', 'engagement']);

                $profileData = [
                    'headline'        => $request->headline,
                    'quote'           => $request->quote,
                    'first_name'      => $request->first_name,
                    'first_nickname'  => $request->first_nickname,
                    'second_name'     => $isDoubleParty ? $request->second_name : null,
                    'second_nickname' => $isDoubleParty ? $request->second_nickname : null,
                    'first_father'    => $request->first_father,
                    'first_mother'    => $request->first_mother,
                    'second_father'   => $isDoubleParty ? $request->second_father : null,
                    'second_mother'   => $isDoubleParty ? $request->second_mother : null,
                    'description'     => $request->description,
                    'address'         => $request->address,
                    'closing_text'    => $request->closing_text,
                ];

                if ($isEdit && $invitation->profile) {
                    $invitation->profile()->update($profileData);
                } else {
                    $profileData['id'] = (string) Str::uuid();
                    $invitation->profile()->create($profileData);
                }

                if ($request->has('builder')) {
                    $rawShowParents = $request->input('builder.show_parents', true);
                    
                    if (is_array($rawShowParents)) {
                        $rawShowParents = end($rawShowParents);
                    }

                    $builderDataArray = [
                        'primary_color' => $request->input('builder.primary_color', '#10b981'),
                        'section_order' => json_decode($request->input('builder.section_order', '[]'), true),
                        'show_parents'  => filter_var($rawShowParents, FILTER_VALIDATE_BOOLEAN),
                    ];

                    $existingProjectData = [];
                    if ($isEdit && $invitation->builder && $invitation->builder->project_data) {
                        $existingProjectData = is_string($invitation->builder->project_data) 
                            ? json_decode($invitation->builder->project_data, true) 
                            : $invitation->builder->project_data;
                    }
                    
                    $mergedProjectData = array_merge($existingProjectData, $builderDataArray);
                    $builderPayload = ['project_data' => json_encode($mergedProjectData)];

                    if ($isEdit && $invitation->builder) {
                        $invitation->builder()->update($builderPayload);
                    } else {
                        $builderPayload['id'] = (string) Str::uuid();
                        $invitation->builder()->create($builderPayload);
                    }
                }

                if ($request->has('deleted_media')) {
                    $mediaToDelete = $invitation->media()->whereIn('id', $request->deleted_media)->get();
                    foreach ($mediaToDelete as $media) {
                        if (file_exists(public_path($media->file_path))) {
                            @unlink(public_path($media->file_path));
                        }
                        $media->delete();
                    }
                }

                if ($request->has('events')) {
                    $invitation->events()->delete();
                    foreach ($request->events as $index => $eventData) {
                        $invitation->events()->create([
                            'id'              => (string) Str::uuid(), 
                            'name'            => $eventData['name'],
                            'description'     => $eventData['description'] ?? null,
                            'event_date'      => $eventData['event_date'],
                            'start_time'      => $eventData['start_time'],
                            'end_time'        => $eventData['end_time'] ?? null,
                            'venue_name'      => $eventData['venue_name'],
                            'address'         => $eventData['address'],
                            'google_maps_url' => $eventData['google_maps_url'] ?? null,
                            'latitude'        => $eventData['latitude'] ?? null,
                            'longitude'       => $eventData['longitude'] ?? null,
                            'sort_order'      => $index + 1,
                            'is_active'       => true,
                        ]);
                    }
                }

                if ($request->hasFile('media_cover') && $request->file('media_cover')->isValid()) {
                    $file = $request->file('media_cover');
                    $fileSize = $file->getSize();
                    $mimeType = $file->getClientMimeType();
                    
                    $oldCover = $invitation->media()->where('type', 'cover')->first();
                    if ($oldCover && file_exists(public_path($oldCover->file_path))) {
                        @unlink(public_path($oldCover->file_path));
                        $oldCover->delete();
                    }
                    
                    $fileName = 'cover_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $fileName);

                    $invitation->media()->create([
                        'id'        => (string) Str::uuid(),
                        'type'      => 'cover',
                        'file_path' => "assets/{$folderName}/{$fileName}",
                        'mime_type' => $mimeType,
                        'file_size' => $fileSize,
                        'sort_order'=> 1,
                        'is_active' => true,
                    ]);
                }

                if ($request->hasFile('media_music') && $request->file('media_music')->isValid()) {
                    $file = $request->file('media_music');
                    $fileSize = $file->getSize();
                    $mimeType = $file->getClientMimeType();
                    
                    $oldMusic = $invitation->media()->where('type', 'music')->first();
                    if ($oldMusic && file_exists(public_path($oldMusic->file_path))) {
                        @unlink(public_path($oldMusic->file_path));
                        $oldMusic->delete();
                    }
                    
                    $fileName = 'music_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $fileName);

                    $invitation->media()->create([
                        'id'        => (string) Str::uuid(),
                        'type'      => 'music',
                        'file_path' => "assets/{$folderName}/{$fileName}",
                        'mime_type' => $mimeType,
                        'file_size' => $fileSize,
                        'sort_order'=> 1,
                        'is_active' => true,
                    ]);
                }

                if ($request->hasFile('media_gallery')) {
                    $lastSortOrder = $invitation->media()->where('type', 'gallery')->max('sort_order') ?? 0;
                    foreach ($request->file('media_gallery') as $index => $file) {
                        if ($file->isValid()) {
                            $fileSize = $file->getSize();
                            $mimeType = $file->getClientMimeType();
                            $fileName = 'gallery_' . time() . '_' . Str::random(5) . '_' . $index . '.' . $file->getClientOriginalExtension();
                            $file->move($destinationPath, $fileName);
                            
                            $invitation->media()->create([
                                'id'        => (string) Str::uuid(),
                                'type'      => 'gallery',
                                'file_path' => "assets/{$folderName}/{$fileName}",
                                'mime_type' => $mimeType,
                                'file_size' => $fileSize,
                                'sort_order'=> $lastSortOrder + $index + 1,
                                'is_active' => true,
                            ]);
                        }
                    }
                }
            });

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Undangan berhasil disimpan.',
                    'redirect_url' => route('reseller.kelola-undangan.edit', $invitation->id),
                    'save_url' => route('reseller.kelola-undangan.save', $invitation->id),
                    'preview_url' => route('invitation.show', $invitation->slug)
                ]);
            }

            return redirect()->route('reseller.kelola-undangan.index')
                             ->with('success', $isEdit ? 'Undangan berhasil diperbarui.' : 'Undangan berhasil dibuat.');

        } catch (\Exception $e) {
            Log::error('=== PROSES SIMPAN/UPDATE UNDANGAN GAGAL (ROLLBACK) ===', [
                'error_message' => $e->getMessage()
            ]);

            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $customerIds = \App\Models\User::where('reseller_id', Auth::id())->pluck('id')->push(Auth::id());
        $invitation = Invitation::whereIn('user_id', $customerIds)->findOrFail($id);
        
        foreach($invitation->media as $media) {
            if (file_exists(public_path($media->file_path))) {
                @unlink(public_path($media->file_path));
            }
        }

        $invitation->delete();

        return back()->with('success', 'Undangan berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $invitation = Invitation::findOrFail($id);
        
        $invitation->is_active = !$invitation->is_active;
        $invitation->save();

        return redirect()->back()->with('success', 'Status undangan berhasil diubah!');
    }
}