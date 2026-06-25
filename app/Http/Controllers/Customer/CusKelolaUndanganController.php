<?php

namespace App\Http\Controllers\Customer;

use App\Models\Theme;
use App\Models\Invitation;
use App\Models\InvitationType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CusKelolaUndanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Invitation::with(['type', 'theme', 'profile', 'cover', 'galleries', 'events'])
            ->where('user_id', Auth::id())->where('is_finalized', true);

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

        return view('customer.kelola-undangan.index', compact('invitations', 'types'));
    }

    public function create()
    {
        $types = InvitationType::orderBy('name')->get();
        // Load themes beserta slug category-nya dari tabel relasi agar bisa di filter JS
        $themes = DB::table('themes')
            ->leftJoin('theme_categories', 'themes.theme_category_id', '=', 'theme_categories.id')
            ->select('themes.id', 'themes.name', 'themes.is_premium', 'themes.thumbnail', 'theme_categories.slug as category_slug')
            ->where('themes.is_active', true)
            ->orderBy('themes.name')
            ->get();

        $invitation = new Invitation(); 

        return view('customer.kelola-undangan.form', compact('types', 'themes', 'invitation'));
    }

    public function edit($id)
    {
        $types = InvitationType::orderBy('name')->get();
        $themes = DB::table('themes')
            ->leftJoin('theme_categories', 'themes.theme_category_id', '=', 'theme_categories.id')
            ->select('themes.id', 'themes.name', 'themes.is_premium', 'themes.thumbnail', 'theme_categories.slug as category_slug')
            ->where('themes.is_active', true)
            ->orderBy('themes.name')
            ->get();
        
        $invitation = Invitation::where('user_id', Auth::id())
            ->with(['profile', 'events', 'media', 'builder'])
            ->findOrFail($id);

        return view('customer.kelola-undangan.form', compact('types', 'themes', 'invitation'));
    }

    public function save(Request $request, $id = null)
    {
        $invitation = null;
        $isEdit = false;

        if ($id) {
            $invitation = Invitation::where('user_id', Auth::id())->find($id);
            if ($invitation) {
                $isEdit = true;
            }
        }

        Log::info($isEdit ? '=== MEMULAI PROSES UPDATE UNDANGAN ===' : '=== MEMULAI PROSES SIMPAN UNDANGAN ===', [
            'user_id'       => Auth::id(),
            'invitation_id' => $id,
            'title'         => $request->title,
        ]);

        // 1. PERBAIKAN VALIDASI: Daftarkan media_music agar disaring dengan benar
        $validator = Validator::make($request->all(), [
            'title'              => 'required|max:255',
            'slug'               => 'required|max:255|unique:invitations,slug,' . ($isEdit ? $id : 'NULL') . ',id',
            'theme_id'           => 'required|exists:themes,id',
            'invitation_type_id' => 'required|exists:invitation_types,id',
            'event_date'         => 'required|date',
            'password'           => 'nullable|string|min:4',
            'custom_domain'      => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\-]+$/', 'unique:invitations,custom_domain,' . ($isEdit ? $id : 'NULL') . ',id'],
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
            'media_music' => 'nullable', // Dukung hingga 15MB
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek akses tema premium
        $theme = Theme::findOrFail($request->theme_id);
        if ($theme->is_premium && !Auth::user()->hasFeature('is_premium_template_access')) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'errors' => ['theme_id' => ['Anda tidak memiliki akses ke tema premium ini. Silakan upgrade paket Anda.']]], 422);
            }
            return redirect()->back()->withErrors(['theme_id' => 'Anda tidak memiliki akses ke tema premium ini. Silakan upgrade paket Anda.'])->withInput();
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

                $oldThemeId = null;
                if ($isEdit) {
                    // Update: if user clicks "Simpan", finalize it.
                    if ($request->has('is_final') && $request->is_final == '1') {
                        $invitationData['is_finalized'] = true;
                    }
                    $oldThemeId = $invitation->theme_id;
                    $invitation->update($invitationData);
                } else {
                    $invitationData['user_id'] = Auth::id();
                    $invitationData['is_active'] = false;
                    $invitationData['is_finalized'] = false;
                    
                    // Jika langsung klik simpan pertama kali
                    if ($request->has('is_final') && $request->is_final == '1') {
                        $invitationData['is_finalized'] = true;
                    }

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
                        'universal_sections_order' => json_decode($request->input('builder.universal_sections_order', '[]'), true),
                        'show_parents'  => filter_var($rawShowParents, FILTER_VALIDATE_BOOLEAN),
                    ];

                    if ($request->has('builder.program_studi')) {
                        $builderDataArray['program_studi'] = $request->input('builder.program_studi');
                    }
                    if ($request->has('builder.universitas')) {
                        $builderDataArray['universitas'] = $request->input('builder.universitas');
                    }

                    $existingProjectData = [];
                    if ($isEdit && $invitation->builder && $invitation->builder->project_data) {
                        if ($oldThemeId == $request->theme_id) {
                            $existingProjectData = is_string($invitation->builder->project_data) 
                                ? json_decode($invitation->builder->project_data, true) 
                                : $invitation->builder->project_data;
                        }
                    }
                    
                    $mergedProjectData = array_merge($existingProjectData, $builderDataArray);
                    $builderPayload = ['project_data' => json_encode($mergedProjectData)];

                    if ($isEdit && $oldThemeId != $request->theme_id) {
                        $builderPayload['html'] = null;
                        $builderPayload['css'] = null;
                    }

                    if ($isEdit && $invitation->builder) {
                        $invitation->builder()->update($builderPayload);
                    } else {
                        $builderPayload['id'] = (string) Str::uuid();
                        $invitation->builder()->create($builderPayload);
                    }
                } else {
                    if ($isEdit && $oldThemeId != $request->theme_id) {
                        if ($invitation->builder) {
                            $invitation->builder()->update([
                                'html' => null,
                                'css' => null,
                            ]);
                        }
                    }
                }

                // ====== PENANGANAN HAPUS SINGLE MEDIA (DELETED GALLERY) ======
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

                // ====== PENANGANAN UPLOAD MEDIA COVER ======
                if ($request->hasFile('media_cover') && $request->file('media_cover')->isValid()) {
                    $file = $request->file('media_cover');
                    
                    // 1. AMBIL UKURAN DAN MIME TYPE SEBELUM FILE DIPINDAHKAN!
                    $fileSize = $file->getSize();
                    $mimeType = $file->getClientMimeType();
                    
                    $oldCover = $invitation->media()->where('type', 'cover')->first();
                    if ($oldCover && file_exists(public_path($oldCover->file_path))) {
                        @unlink(public_path($oldCover->file_path));
                        $oldCover->delete();
                    }
                    
                    $fileName = 'cover_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    
                    // 2. BARU PINDAHKAN FILENYA
                    $file->move($destinationPath, $fileName);

                    $invitation->media()->create([
                        'id'        => (string) Str::uuid(),
                        'type'      => 'cover',
                        'file_path' => "assets/{$folderName}/{$fileName}",
                        'mime_type' => $mimeType, // Gunakan variabel yang sudah disimpan
                        'file_size' => $fileSize, // Gunakan variabel yang sudah disimpan
                        'sort_order'=> 1,
                        'is_active' => true,
                    ]);
                }

                // ====== PENANGANAN UPLOAD BACKSOUND MUSIC ======
                if ($request->hasFile('media_music') && $request->file('media_music')->isValid()) {
                    $file = $request->file('media_music');
                    
                    // 1. AMBIL UKURAN DAN MIME TYPE SEBELUM FILE DIPINDAHKAN!
                    $fileSize = $file->getSize();
                    $mimeType = $file->getClientMimeType();
                    
                    $oldMusic = $invitation->media()->where('type', 'music')->first();
                    if ($oldMusic && file_exists(public_path($oldMusic->file_path))) {
                        @unlink(public_path($oldMusic->file_path));
                        $oldMusic->delete();
                    }
                    
                    $fileName = 'music_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    
                    // 2. BARU PINDAHKAN FILENYA
                    $file->move($destinationPath, $fileName);

                    $invitation->media()->create([
                        'id'        => (string) Str::uuid(),
                        'type'      => 'music',
                        'file_path' => "assets/{$folderName}/{$fileName}",
                        'mime_type' => $mimeType, // Gunakan variabel yang sudah disimpan
                        'file_size' => $fileSize, // Gunakan variabel yang sudah disimpan
                        'sort_order'=> 1,
                        'is_active' => true,
                    ]);
                }

                // ====== PENANGANAN UPLOAD GALERI ======
                if ($request->hasFile('media_gallery')) {
                    $lastSortOrder = $invitation->media()->where('type', 'gallery')->max('sort_order') ?? 0;
                    foreach ($request->file('media_gallery') as $index => $file) {
                        if ($file->isValid()) {
                            // 1. AMBIL UKURAN DAN MIME TYPE SEBELUM FILE DIPINDAHKAN!
                            $fileSize = $file->getSize();
                            $mimeType = $file->getClientMimeType();
                            
                            $fileName = 'gallery_' . time() . '_' . Str::random(5) . '_' . $index . '.' . $file->getClientOriginalExtension();
                            
                            // 2. BARU PINDAHKAN FILENYA
                            $file->move($destinationPath, $fileName);
                            
                            $invitation->media()->create([
                                'id'        => (string) Str::uuid(),
                                'type'      => 'gallery',
                                'file_path' => "assets/{$folderName}/{$fileName}",
                                'mime_type' => $mimeType, // Gunakan variabel yang sudah disimpan
                                'file_size' => $fileSize, // Gunakan variabel yang sudah disimpan
                                'sort_order'=> $lastSortOrder + $index + 1,
                                'is_active' => true,
                            ]);
                        }
                    }
                }
            });

            if ($request->ajax()) {
                $responsePayload = [
                    'status' => 'success', 
                    'message' => 'Undangan berhasil disimpan.',
                    'redirect_url' => route('customer.kelola-undangan.edit', $invitation->id),
                    'save_url' => route('customer.kelola-undangan.save', $invitation->id),
                    'preview_url' => route('invitation.show', $invitation->slug)
                ];

                if ($request->has('is_final') && $request->is_final == '1') {
                    $responsePayload['redirect_url'] = route('customer.kelola-undangan.index');
                    $responsePayload['final_redirect'] = true;
                }

                return response()->json($responsePayload);
            }

            return redirect()->route('customer.kelola-undangan.index')
                            ->with('success', $isEdit ? 'Undangan berhasil diperbarui.' : 'Undangan berhasil dibuat.');

        } catch (\Exception $e) {
            Log::error('=== PROSES SIMPAN/UPDATE UNDANGAN GAGAL ===', [
                'error_message' => $e->getMessage()
            ]);

            // Pesan default
            $errorMessage = 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';

            // Cek apakah error karena pelanggaran constraint database (Unique Violation)
            if ($e instanceof \Illuminate\Database\QueryException) {
                $errorCode = $e->getCode(); // 23505 untuk PostgreSQL
                if (str_contains($e->getMessage(), 'invitations_slug_unique')) {
                    $errorMessage = 'Slug tersebut sudah digunakan, silakan pilih nama lain.';
                } elseif (str_contains($e->getMessage(), 'invitations_custom_domain_unique')) {
                    $errorMessage = 'Domain custom tersebut sudah digunakan orang lain.';
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error', 
                    'message' => $errorMessage
                ], 422); // Gunakan 422 agar konsisten dengan error validasi
            }

            return redirect()->back()->withInput()->with('error', $errorMessage);
        }
    }

    public function destroy($id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);
        
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

    public function guests($id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($id);
        
        // Asumsi relasi ke guests ditambahkan di Invitation model. Jika belum ada relasinya, query manual
        $guests = \App\Models\InvitationGuest::where('invitation_id', $id)->get();
        
        $hadirCount = $guests->where('status', 'hadir')->count();
        $mungkinCount = $guests->where('status', 'mungkin')->count();
        $tidakHadirCount = $guests->where('status', 'tidak_hadir')->count();
        $locationSharedCount = $guests->where('is_location_shared', true)->count();

        return view('customer.kelola-undangan.guests', compact(
            'invitation', 'guests', 'hadirCount', 'mungkinCount', 'tidakHadirCount', 'locationSharedCount'
        ));
    }

    public function map($id)
    {
        $invitation = Invitation::where('user_id', Auth::id())->with('events')->findOrFail($id);
        
        $guests = \App\Models\InvitationGuest::where('invitation_id', $id)
            ->where('is_location_shared', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();
            
        return view('customer.kelola-undangan.map', compact('invitation', 'guests'));
    }
}