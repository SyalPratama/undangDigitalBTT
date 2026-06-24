<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatbotKnowledge;
use App\Models\ChatbotLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminChatController extends Controller
{

    public function index()
    {
        $stats = [
            'total_knowledge' => ChatbotKnowledge::count(),
            'total_leads' => ChatbotLead::count(),
            'pending_chat' => ChatbotLead::where('live_chat_status','pending')->count(),
            'active_chat' => ChatbotLead::where('live_chat_status','active')->count(),
        ];

        $knowledge = ChatbotKnowledge::latest()->get();

        $leads = ChatbotLead::latest()->limit(5)->get();


        return view('superadmin.chatbot.index', compact(
            'stats',
            'knowledge',
            'leads'
        ));
    }

    public function storeChatbotKnowledge(Request $request)
    {
        $request->validate(['topic' => 'required', 'intent_name' => 'required', 'keywords' => 'required', 'response' => 'required']);
        $keywordsArray = array_map('trim', explode(',', strtolower($request->keywords)));
        
        \App\Models\ChatbotKnowledge::create([
            'topic' => $request->topic, 'intent_name' => Str::slug($request->intent_name, '_'),
            'keywords' => json_encode($keywordsArray), 'response' => $request->response
        ]);
        return back()->with(['success' => 'Respon Chatbot berhasil ditambahkan!', 'active_tab' => 'chatbot']);
    }

    public function updateChatbotKnowledge(Request $request, $id)
    {
        $knowledge = \App\Models\ChatbotKnowledge::findOrFail($id);
        $keywordsArray = array_map('trim', explode(',', strtolower($request->keywords)));
        
        $knowledge->update([
            'topic' => $request->topic, 'intent_name' => Str::slug($request->intent_name, '_'),
            'keywords' => json_encode($keywordsArray), 'response' => $request->response
        ]);
        return back()->with(['success' => 'Respon Chatbot berhasil diperbarui!', 'active_tab' => 'chatbot']);
    }

    public function destroyChatbotKnowledge($id)
    {
        \App\Models\ChatbotKnowledge::findOrFail($id)->delete();
        return back()->with(['success' => 'Respon Chatbot dihapus!', 'active_tab' => 'chatbot']);
    }

    public function toggleLeadStatus($id)
    {
        $lead = \App\Models\ChatbotLead::findOrFail($id);
        $lead->status = $lead->status === 'pending' ? 'contacted' : 'pending';
        $lead->save();
        return back()->with(['success' => 'Status follow up diperbarui!', 'active_tab' => 'chatbot']);
    }

    public function getLeadHistory($id)
    {
        $lead = \App\Models\ChatbotLead::findOrFail($id);
        return response()->json(json_decode($lead->chat_history, true) ?? []);
    }

    public function reply(Request $request, $id)
    {
        $lead = \App\Models\ChatbotLead::findOrFail($id);
        
        // 1. Ambil history lama (asumsikan kolomnya berupa JSON)
        $history = json_decode($lead->chat_history, true) ?? [];

        // 2. Buat objek pesan baru dari admin/bot
        $newMessage = [
            'sender' => 'admin', // Sesuaikan dengan logika sistem Anda (bot/admin)
            'text' => $request->text,
            'time' => date('d M, H.i') // Timestamp saat ini
        ];

        // 3. Tambahkan ke array history
        $history[] = $newMessage;

        // 4. Simpan kembali ke database
        $lead->chat_history = json_encode($history);
        $lead->save();

        return response()->json(['status' => 'success']);
    }

    public function pollLiveChats() {
        return response()->json([
            'pending' => \App\Models\ChatbotLead::with('user')->where('live_chat_status', 'pending')->latest()->get(),
            'active'  => \App\Models\ChatbotLead::with('user')->where('live_chat_status', 'active')->where('admin_id', auth()->id())->latest()->get(),
            // Tambahkan Riwayat (Ended) - Kita ambil 10 data terakhir saja agar tidak berat
            'ended'   => \App\Models\ChatbotLead::with('user')->where('live_chat_status', 'ended')->where('admin_id', auth()->id())->latest()->get()
        ]);
    }

    public function actionLiveChat(Request $request) {
        $lead = \App\Models\ChatbotLead::find($request->lead_id);
        $adminName = auth()->user()->name;
        
        if ($request->action === 'accept') {
            $history = json_decode($lead->chat_history, true) ?? [];
            $history[] = ['sender' => 'admin', 'text' => "Halo, saya {$adminName}. Ada yang bisa saya bantu?", 'time' => now()->format('d M, H:i')];
            $lead->update(['live_chat_status' => 'active', 'admin_id' => auth()->id(), 'chat_history' => json_encode($history)]);
        } elseif ($request->action === 'reject') {
            $history = json_decode($lead->chat_history, true) ?? [];
            $history[] = ['sender' => 'bot', 'text' => 'Maaf, saat ini semua admin sedang sibuk. Silakan tinggalkan kontak Anda di bawah ini agar kami bisa menghubungi Anda.', 'time' => now()->format('d M, H:i')];
            $lead->update(['live_chat_status' => 'ended', 'chat_history' => json_encode($history)]);
        } elseif ($request->action === 'end') {
            $history = json_decode($lead->chat_history, true) ?? [];
            $history[] = ['sender' => 'bot', 'text' => "Obrolan Live Chat dengan {$adminName} telah berakhir. Anda kembali terhubung dengan ScanYuk Bot.", 'time' => now()->format('d M, H:i')];
            $lead->update(['live_chat_status' => 'ended', 'chat_history' => json_encode($history)]);
        }
        return response()->json(['success' => true]);
    }

    public function sendLiveChatMessage(Request $request) {
        $lead = \App\Models\ChatbotLead::find($request->lead_id);
        
        if ($lead && !empty($request->message)) {
            $history = json_decode($lead->chat_history, true) ?? [];
            $history[] = ['sender' => 'admin', 'text' => $request->message, 'time' => now()->format('d M, H:i')];
            
            $lead->update([
                'chat_history' => json_encode($history),
                'updated_at' => now()
            ]);
        }
        
        return response()->json(['success' => true]);
    }
}
