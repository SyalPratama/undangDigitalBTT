<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResContributorController extends Controller
{
    public function index()
    {
        return view('reseller.kontributor');
    }

    public function store(Request $request)
    {
        // Add form validation
        $request->validate([
            'name' => 'required|string|max:255',
            'portfolio' => 'nullable|url',
            'experience' => 'required|string',
        ]);

        // Normally we would save this to a database table like `contributor_applications`
        // For now we just redirect back with a success message.
        return redirect()->back()->with('success', 'Pengajuan Anda berhasil dikirim! Tim kami akan segera meninjaunya.');
    }
}
