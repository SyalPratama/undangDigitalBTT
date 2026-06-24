@extends('layouts.superadmin')

@section('title', 'Dashboard Chatbot')

@section('content')

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-slate-500">Welcome back, Superadmin</p>
                <h1 class="font-serif text-4xl font-bold">Kelola Chatbot</h1>
            </div>
            <button onclick="openKnowledge()"
                class="bg-[#6d28d9] text-white px-6 py-3 rounded-full hover:bg-purple-700 transition">
                + Tambah Knowledge
            </button>
        </div>

        {{-- STAT --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            @foreach ([['TOTAL KNOWLEDGE', $stats['total_knowledge']], ['TOTAL LEAD', $stats['total_leads']], ['CHAT PENDING', $stats['pending_chat']], ['CHAT AKTIF', $stats['active_chat']]] as $item)
                <div class="bg-white rounded-3xl p-6 shadow">
                    <p class="text-xs text-slate-500">{{ $item[0] }}</p>
                    <h2 class="text-4xl font-bold mt-4">{{ $item[1] }}</h2>
                </div>
            @endforeach
        </div>

        {{-- TABS NAVIGATION --}}
        <div class="flex gap-4 border-b border-slate-200">
            <button onclick="switchTab('live-chat')" id="tab-btn-live-chat"
                class="px-6 py-3 font-semibold border-b-2 border-[#6d28d9] text-[#6d28d9]">Live Chat</button>
            <button onclick="switchTab('knowledge')" id="tab-btn-knowledge"
                class="px-6 py-3 font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-800">Knowledge
                Chatbot</button>
        </div>

        {{-- CONTENT AREAS --}}
        <div id="content-live-chat" class="bg-white rounded-3xl p-8 shadow">
            <h2 class="font-serif text-2xl font-bold mb-5">Live Chat Masuk</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">Pengguna</th>
                            <th class="px-6 py-4 whitespace-nowrap">Topik</th>
                            <th class="px-6 py-4">Status & Kontak Diberikan</th>
                            <th class="px-6 py-4 whitespace-nowrap">Waktu</th>
                            <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($leads as $lead)
                            <tr class="hover:bg-slate-50 transition-colors">
                                {{-- Pengguna --}}
                                <td class="px-6 py-4">
                                    @if ($lead->user)
                                        <div class="font-bold text-teal-700 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $lead->user->name }}
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $lead->user->email }}</div>
                                    @else
                                        <div class="font-bold text-slate-700 flex items-center gap-1">
                                            👤 Guest / Visitor
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            IP: {{ $lead->ip_address ?? 'N/A' }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Topik --}}
                                <td class="px-6 py-4">
                                    <span class="text-slate-700 font-medium">{{ $lead->topic_context ?? '-' }}</span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    {{-- Cek jika contact_info adalah '-' ATAU status adalah 'contacted' --}}
                                    @if ($lead->contact_info === '-' && $lead->status !== 'contacted')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-600 font-bold text-xs rounded-lg border border-blue-200">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                                            Chat Masih Aktif
                                        </span>
                                    @else
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-lg border border-emerald-200 mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Chat Diakhiri
                                        </div>
                                        <br>
                                        @if ($lead->contact_info !== '-')
                                            <span class="text-xs font-bold text-slate-700">
                                                Follow up via: <span
                                                    class="text-indigo-600">{{ $lead->contact_info }}</span>
                                            </span>
                                        @endif
                                    @endif
                                </td>

                                {{-- Waktu --}}
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $lead->created_at ? $lead->created_at->format('d M Y, H:i') : '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center space-y-2">
                                    {{-- Form Update Status --}}
                                    <form action="{{ route('superadmin.chatbot.lead.status', $lead->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="text-[10px] font-bold px-2 py-1.5 rounded-lg border w-full transition-colors 
            {{ $lead->status === 'contacted' ? 'bg-green-50 text-green-600 border-green-200 hover:bg-green-100' : 'bg-amber-50 text-amber-600 border-amber-200 hover:bg-amber-100' }}">
                                            {{ $lead->status === 'contacted' ? '✅ Selesai Dihubungi' : '⚠️ Belum Dihubungi' }}
                                        </button>
                                    </form>

                                    {{-- Tombol Pantau Chat (Modal) --}}
                                    <button onclick="openModal({{ $lead->id }}, '{{ $lead->name ?? 'Guest' }}')"
                                        class="text-xs text-white bg-slate-800 hover:bg-slate-900 px-3 py-1.5 rounded-lg w-full font-semibold transition-colors flex items-center justify-center gap-1 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        Pantau Chat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada live chat masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content-knowledge" class="bg-white rounded-3xl p-8 shadow hidden">
            <h2 class="font-serif text-2xl font-bold mb-5">Knowledge Chatbot</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-slate-400 text-sm border-b">
                            <th class="pb-4 font-medium">Topik / Intent</th>
                            <th class="pb-4 font-medium">Kata Kunci</th>
                            <th class="pb-4 font-medium">Balasan Bot</th>
                            <th class="pb-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($knowledge as $item)
                            <tr>
                                <td class="py-4">
                                    <p class="font-bold text-slate-800">{{ $item->topic }}</p>
                                    <p class="text-xs text-purple-600 font-mono">{{ $item->intent_name }}</p>
                                </td>
                                <td class="py-4 text-sm text-slate-600 max-w-[200px] truncate"
                                    title="{{ $item->keywords }}">
                                    {{ $item->keywords }}
                                </td>
                                <td class="py-4 text-sm text-slate-600 max-w-[250px] truncate"
                                    title="{{ $item->response }}">
                                    {{ $item->response }}
                                </td>
                                <td class="py-4">
                                    <div class="flex gap-2 justify-center">
                                        <button onclick="editKnowledge({{ json_encode($item) }})"
                                            class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <form method="POST"
                                            action="{{ route('superadmin.chatbot.destroy', $item->id) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200"
                                                onclick="return confirm('Hapus data ini?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="chatModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white p-6 rounded-3xl w-full max-w-lg shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modalChatTitle" class="text-lg font-bold">Riwayat Chat</h2>
                <button onclick="closeChatModal()" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <div id="chatHistoryContainer" class="h-80 overflow-y-auto space-y-3 bg-slate-50 p-4 rounded-xl">
                <p class="text-center text-slate-400">Memuat riwayat...</p>
            </div>
            <div class="mt-4 flex gap-2">
                <input type="text" id="chatInput" placeholder="Tulis balasan..."
                    class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button id="sendChatBtn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Kirim
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <div id="knowledgeModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-3xl w-full max-w-lg relative">
            <button onclick="closeKnowledge()"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 font-bold">X</button>

            <form id="knowledgeForm" method="POST" action="{{ route('superadmin.chatbot.store') }}">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">

                <h2 id="modalTitle" class="text-xl font-bold mb-6">Tambah Respon Bot</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Topik Terkait</label>
                        <input name="topic" id="inputTopic" required
                            class="w-full border border-slate-300 p-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kode Intent</label>
                        <input name="intent_name" id="inputIntent" class="w-full border border-slate-300 p-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kata Kunci</label>
                        <textarea name="keywords" id="inputKeywords" class="w-full border border-slate-300 p-3 rounded-xl"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Teks Balasan Bot</label>
                        <textarea name="response" id="inputResponse" required class="w-full border border-slate-300 p-3 rounded-xl h-24"></textarea>
                    </div>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="button" onclick="closeKnowledge()"
                        class="flex-1 border py-3 rounded-xl font-semibold hover:bg-slate-50">Batal</button>
                    <button type="submit"
                        class="flex-1 bg-[#10b981] text-white py-3 rounded-xl font-semibold hover:bg-[#059669]">Simpan
                        Respon</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchTab(tabId) {
            document.getElementById('content-live-chat').classList.add('hidden');
            document.getElementById('content-knowledge').classList.add('hidden');
            document.getElementById('tab-btn-live-chat').classList.remove('border-[#6d28d9]', 'text-[#6d28d9]');
            document.getElementById('tab-btn-live-chat').classList.add('border-transparent', 'text-slate-500');
            document.getElementById('tab-btn-knowledge').classList.remove('border-[#6d28d9]', 'text-[#6d28d9]');
            document.getElementById('tab-btn-knowledge').classList.add('border-transparent', 'text-slate-500');
            document.getElementById('content-' + tabId).classList.remove('hidden');
            document.getElementById('tab-btn-' + tabId).classList.add('border-[#6d28d9]', 'text-[#6d28d9]');
            document.getElementById('tab-btn-' + tabId).classList.remove('border-transparent', 'text-slate-500');
        }

        function openKnowledge() {
            document.getElementById('modalTitle').innerText = 'Tambah Respon Bot';
            document.getElementById('knowledgeForm').action = "{{ route('superadmin.chatbot.store') }}";
            document.getElementById('methodField').value = 'POST';
            document.getElementById('knowledgeForm').reset();
            document.getElementById('knowledgeModal').classList.remove('hidden');
        }

        function editKnowledge(data) {
            document.getElementById('modalTitle').innerText = 'Edit Respon Bot';
            // Route sesuai yang Anda berikan
            document.getElementById('knowledgeForm').action = "/superadmin/chatbot/knowledge/" + data.id;
            document.getElementById('methodField').value = 'PATCH';

            document.getElementById('inputTopic').value = data.topic || '';
            document.getElementById('inputIntent').value = data.intent_name || '';
            document.getElementById('inputKeywords').value = data.keywords || '';
            document.getElementById('inputResponse').value = data.response || '';

            document.getElementById('knowledgeModal').classList.remove('hidden');
        }

        function closeKnowledge() {
            document.getElementById('knowledgeModal').classList.add('hidden');
        }
    </script>
    <script>
        let currentLeadId = null;

        // Fungsi utama membuka modal
        async function openModal(id, leadName) {
            currentLeadId = id;
            document.getElementById('chatModal').classList.remove('hidden');

            // Reset input dan tampilan
            document.getElementById('chatInput').value = '';
            document.getElementById('modalChatTitle').innerText = 'Chat dengan ' + (leadName || 'Guest');

            await loadChatHistory(id);
        }

        // Fungsi memuat riwayat chat
        async function loadChatHistory(id) {
            const container = document.getElementById('chatHistoryContainer');
            container.innerHTML = '<p class="text-center text-slate-500">Memuat...</p>';

            try {
                const response = await fetch(`/superadmin/chatbot/leads/${id}/history`);
                if (!response.ok) throw new Error('Gagal mengambil data');

                const chatHistory = await response.json();

                if (!Array.isArray(chatHistory) || chatHistory.length === 0) {
                    container.innerHTML = '<p class="text-center text-slate-500">Belum ada riwayat chat.</p>';
                    return;
                }

                container.innerHTML = chatHistory.map(chat => `
                    <div class="flex ${chat.sender === 'user' ? 'justify-start' : 'justify-end'} mb-2">
                        <div class="inline-block p-3 rounded-lg text-left ${chat.sender === 'user' ? 'bg-white border' : 'bg-indigo-600 text-white'}">
                            ${chat.text}
                        </div>
                    </div>
                `).join('');

                container.scrollTop = container.scrollHeight;
            } catch (error) {
                console.error(error);
                container.innerHTML = '<p class="text-red-500 text-center">Gagal memuat chat.</p>';
            }
        }

        // Fungsi mengirim pesan (balasan)
        document.getElementById('sendChatBtn').addEventListener('click', async () => {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();

            if (!message || !currentLeadId) return;

            // Visual feedback saat mengirim
            const originalBtnText = document.getElementById('sendChatBtn').innerText;
            document.getElementById('sendChatBtn').innerText = '...';

            try {
                const response = await fetch(`/superadmin/chatbot/leads/${currentLeadId}/reply`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        text: message
                    }) // Pastikan key 'text' sesuai controller Anda
                });

                if (response.ok) {
                    input.value = '';
                    await loadChatHistory(currentLeadId); // Refresh tampilan setelah sukses
                } else {
                    alert('Gagal mengirim pesan.');
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan koneksi.');
            } finally {
                document.getElementById('sendChatBtn').innerText = originalBtnText;
            }
        });

        // Fungsi menutup modal
        function closeChatModal() {
            document.getElementById('chatModal').classList.add('hidden');
            currentLeadId = null;
        }
    </script>

@endsection
