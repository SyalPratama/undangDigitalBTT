<x-app-layout>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Reseller
                </h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ Auth::user()->name }}! Kelola undangan klienmu di sini.</p>
            </div>
            <div>
                <a href="{{ route('reseller.kelola-undangan.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150 shadow-sm">
                    <i class="fa-solid fa-plus mr-2"></i> Buat Undangan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow duration-300">
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                        <i class="fa-solid fa-envelope-open-text text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Undangan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalInvitations }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow duration-300">
                    <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                        <i class="fa-solid fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Undangan Aktif</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $activeInvitations }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center hover:shadow-md transition-shadow duration-300">
                    <div class="p-3 rounded-full bg-amber-50 text-amber-500 mr-4">
                        <i class="fa-solid fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Klien Saya</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalCustomers }} Klien</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-semibold text-gray-800">Undangan Terbaru</h3>
                    <a href="{{ route('reseller.kelola-undangan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua &rarr;</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul / Slug</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tema</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($recentInvitations as $invitation)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $invitation->title ?? 'Undangan Tanpa Judul' }}</div>
                                        <div class="text-sm text-gray-500">/{{ $invitation->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $invitation->theme->name ?? 'Belum Pilih Tema' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($invitation->is_active)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $invitation->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('reseller.kelola-undangan.edit', $invitation->id) }}" class="text-indigo-600 hover:text-indigo-900 mx-2" title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ url('/undangan/'.$invitation->slug) }}" target="_blank" class="text-emerald-600 hover:text-emerald-900 mx-2" title="Lihat Undangan">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                            <p class="text-base font-medium text-gray-600">Belum ada undangan dibuat</p>
                                            <p class="text-sm mt-1">Mulai buat undangan pertamamu untuk klien.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</x-app-layout>