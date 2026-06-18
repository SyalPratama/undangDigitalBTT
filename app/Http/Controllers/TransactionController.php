<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        $package = Package::findOrFail($request->package_id);
        
        $proofPath = null;
        if ($request->hasFile('proof_of_payment')) {
            $proofPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'amount' => $package->price,
            'payment_method' => 'transfer',
            'status' => 'pending',
            'proof_of_payment' => $proofPath,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim. Kami akan segera memprosesnya.');
    }
}
