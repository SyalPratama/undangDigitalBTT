<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use App\Models\InvitationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicInteractionController extends Controller
{
    public function storeRsvp(Request $request, $id)
    {
        $invitation = Invitation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:hadir,mungkin,tidak_hadir',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        InvitationGuest::create([
            'invitation_id' => $invitation->id,
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Konfirmasi kehadiran berhasil dikirim!']);
    }

    public function storeComment(Request $request, $id)
    {
        $invitation = Invitation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        InvitationComment::create([
            'invitation_id' => $invitation->id,
            'name' => $request->name,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => 'Ucapan & Doa berhasil dikirim!']);
    }

    public function showCheckin($id)
    {
        $guest = InvitationGuest::findOrFail($id);
        return view('guest.checkin', compact('guest'));
    }

    public function storeCheckinLocation(Request $request, $id)
    {
        $guest = InvitationGuest::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $guest->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_location_shared' => true,
        ]);

        return response()->json(['success' => true, 'message' => 'Lokasi berhasil dibagikan! Terima kasih.']);
    }
}
