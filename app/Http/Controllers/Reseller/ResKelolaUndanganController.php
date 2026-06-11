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

    public function create()
    {
        $types = InvitationType::orderBy('name')->get();
        $themes = Theme::orderBy('name')->get();
        $invitation = new Invitation(); // Instance kosong aman untuk create form

        return view('reseller.kelola-undangan.form', compact('types', 'themes', 'invitation'));
    }

    public function edit($id)
    {
        $types = InvitationType::orderBy('name')->get();
        $themes = Theme::orderBy('name')->get();
        
        // Pastikan hanya bisa membuka data miliknya sendiri
        $invitation = Invitation::where('user_id', Auth::id())
            ->with(['profile', 'events', 'media'])
            ->findOrFail($id);

        return view('reseller.kelola-undangan.form', compact('types', 'themes', 'invitation'));
    }

    public function save(Request $request, $id = null)
    {
        // Menentukan mode edit berdasarkan keberadaan ID dan kepemilikan data
        $invitation = null;
        $isEdit = false;

        if ($id) {
            $invitation = Invitation::where('user_id', Auth::id())->find($id);
            if ($invitation) {
                $isEdit = true;
            }
        }

        // Log penanda awal proses
        Log::info($isEdit ? '=== MEMULAI PROSES UPDATE UNDANGAN ===' : '=== MEMULAI PROSES SIMPAN UNDANGAN ===', [
            'user_id'       => Auth::id(),
            'invitation_id' => $id,
            'title'         => $request->title,
            'slug'          => $request->slug
        ]);

        // Validasi data input
        $request->validate([
            'title'              => 'required|max:255',
            'slug'               => 'required|max:255|unique:invitations,slug,' . ($isEdit ? $id : 'NULL') . ',id',
            'theme_id'           => 'required|exists:themes,id',
            'invitation_type_id' => 'required|exists:invitation_types,id',
            'event_date'         => 'required|date',
            'password'           => 'nullable|string|min:4',
            'custom_domain'      => 'nullable|string|max:255',
            
            // Validasi Relasi Profile
            'first_name'         => 'required|string|max:255',
            'first_nickname'     => 'required|string|max:255',
            'second_name'        => 'nullable|string|max:255',
            'second_nickname'    => 'nullable|string|max:255',
            
            // Validasi Array Rangkaian Acara (Events)
            'events'             => 'required|array|min:1',
            'events.*.name'      => 'required|string|max:255',
            'events.*.event_date'=> 'required|date',
            'events.*.start_time'=> 'required',
            'events.*.venue_name'=> 'required|string|max:255',
            'events.*.address'   => 'required|string',
            
            // Validasi File Media
            'media_cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'media_gallery.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        Log::info('1. Validasi request berhasil dilewati.');

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
                    Log::info('3. Data tabel "invitations" berhasil di-update.', ['invitation_id' => $invitation->id]);
                } else {
                    $invitationData['user_id'] = Auth::id();
                    $invitationData['is_active'] = false; 
                    $invitation = Invitation::create($invitationData);
                    Log::info('3. Data tabel "invitations" berhasil dibuat baru.', ['invitation_id' => $invitation->id]);
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
                    Log::info('4. Data tabel "invitation_profiles" berhasil di-update.');
                } else {
                    $profileData['id'] = (string) Str::uuid();
                    $invitation->profile()->create($profileData);
                    Log::info('4. Data tabel "invitation_profiles" berhasil dibuat baru.');
                }

                // 6. Sinkronisasi tabel: EVENTS
                if ($request->has('events')) {
                    Log::info('5. Memproses rangkaian acara (events)...');
                    
                    if ($isEdit) {
                        $invitation->events()->delete();
                    }

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
                    Log::info('5a. Seluruh data "events" berhasil disinkronisasi.');
                }

                // 7. Simpan Media: COVER
                if ($request->hasFile('media_cover')) {
                    Log::info('6. Mendeteksi file media_cover baru.');

                    if ($isEdit) {
                        $oldCover = $invitation->media()->where('type', 'cover')->first();
                        if ($oldCover) {
                            if (file_exists(public_path($oldCover->file_path))) {
                                @unlink(public_path($oldCover->file_path));
                            }
                            $oldCover->delete();
                            Log::info('   -> File & record cover lama dibersihkan.');
                        }
                    }
                    
                    $file = $request->file('media_cover');
                    $fileSize = $file->getSize() ?? 0;
                    $mimeType = $file->getClientMimeType();
                    $fileName = 'cover_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                    
                    $file->move($destinationPath, $fileName);

                    $invitation->media()->create([
                        'id'          => (string) Str::uuid(),
                        'type'        => 'cover',
                        'file_path'   => "assets/{$folderName}/{$fileName}",
                        'mime_type'   => $mimeType,
                        'file_size'   => $fileSize,
                        'sort_order'  => 1,
                        'is_active'   => true,
                    ]);
                    Log::info('   -> Cover baru berhasil disimpan.');
                }

                // 8. Simpan Media: GALLERY
                if ($request->hasFile('media_gallery')) {
                    Log::info('7. Mendeteksi file media_gallery baru dimasukkan.', [
                        'total_gallery_files' => count($request->file('media_gallery'))
                    ]);
                    
                    $lastSortOrder = $invitation->media()->max('sort_order') ?? 1;

                    foreach ($request->file('media_gallery') as $index => $file) {
                        $fileSize = $file->getSize() ?? 0;
                        $mimeType = $file->getClientMimeType();
                        $fileName = 'gallery_' . time() . '_' . Str::random(5) . '_' . $index . '.' . $file->getClientOriginalExtension();
                        
                        $file->move($destinationPath, $fileName);

                        $invitation->media()->create([
                            'id'          => (string) Str::uuid(),
                            'type'        => 'gallery',
                            'file_path'   => "assets/{$folderName}/{$fileName}",
                            'mime_type'   => $mimeType,
                            'file_size'   => $fileSize,
                            'sort_order'  => $lastSortOrder + $index + 1,
                            'is_active'   => true,
                        ]);
                    }
                    Log::info('   -> Gallery tambahan berhasil di-upload.');
                }
            });

            Log::info($isEdit ? '=== PROSES UPDATE UNDANGAN BERHASIL ===' . PHP_EOL : '=== PROSES SIMPAN UNDANGAN BERHASIL ===' . PHP_EOL);

            return redirect()
                ->route('reseller.kelola-undangan.index')
                ->with('success', $isEdit ? 'Undangan berhasil diperbarui.' : 'Undangan berhasil dibuat.');

        } catch (\Exception $e) {
            Log::error('=== PROSES SIMPAN/UPDATE UNDANGAN GAGAL (ROLLBACK) ===', [
                'error_message' => $e->getMessage(),
                'error_trace'   => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
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
}