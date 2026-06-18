<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;
use App\Mail\RejectionEmail;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'package'])->latest()->paginate(10);
        return view('superadmin.transactions.index', compact('transactions'));
    }

    public function confirm(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses.');
        }

        $transaction->update(['status' => 'confirmed']);

        // Update User Package
        $user = $transaction->user;
        $package = $transaction->package;

        $user->update([
            'package_id' => $package->id,
            'package_expires_at' => $package->active_days ? now()->addDays($package->active_days) : null,
        ]);

        // Send Invoice Email
        try {
            Mail::to($user->email)->send(new InvoiceEmail($transaction));
        } catch (\Exception $e) {
            // Log error or ignore
            \Log::error('Gagal mengirim email invoice: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi. Paket user telah diperbarui dan invoice telah dikirim.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses.');
        }

        $transaction->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Send Rejection Email
        try {
            Mail::to($transaction->user->email)->send(new RejectionEmail($transaction));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email penolakan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pembayaran ditolak. Email pemberitahuan telah dikirim ke user.');
    }
}
