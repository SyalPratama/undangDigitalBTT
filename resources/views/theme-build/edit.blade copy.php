@extends('layouts.reseller')

@section('content')
    <div class="h-[calc(100vh-80px)] flex overflow-hidden bg-slate-100">
        {{-- PANEL SETTING (Sisi Kiri) --}}
        <div class="w-full lg:w-[400px] bg-white border-r border-slate-200 flex flex-col h-full z-20">
            <div class="h-14 flex items-center px-6 border-b border-slate-200">
                <h1 class="text-sm font-bold text-slate-800 flex items-center">
                    <i class="fa-solid fa-wand-magic-sparkles mr-2 text-rose-500"></i>Theme Builder
                </h1>
            </div>
            <div class="flex-1 overflow-y-auto p-6">
                <form method="POST" action="{{ route('theme-builder.update', $invitation->id) }}" id="auto-save-form">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Warna Utama</label>
                            <input type="color" name="primary_color"
                                class="w-full h-10 rounded-lg cursor-pointer border-0 p-0 auto-save"
                                value="{{ $invitation->design->primary_color }}">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Background</label>
                                <input type="color" name="background_color"
                                    class="w-full h-10 rounded-lg cursor-pointer border-0 p-0 auto-save"
                                    value="{{ $invitation->design->background_color }}">
                            </div>
                            <div>
                                <label class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Text
                                    Color</label>
                                <input type="color" name="text_color"
                                    class="w-full h-10 rounded-lg cursor-pointer border-0 p-0 auto-save"
                                    value="{{ $invitation->design->text_color }}">
                            </div>
                        </div>
                    </div>
                    <hr class="my-6 border-slate-200">
                    <h6 class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-3">Urutan Section</h6>
                    
                    <ul id="sectionList" class="space-y-2 mb-6">
                        @foreach ($invitation->design->sections as $section)
                            <li class="bg-slate-50 border border-slate-200 p-3 rounded-xl flex justify-between items-center cursor-move"
                                data-type="{{ $section['type'] }}">
                                <span class="text-xs font-semibold text-slate-700 flex items-center">
                                    <i
                                        class="fa-solid fa-grip-vertical text-slate-300 mr-3"></i>{{ ucfirst($section['type']) }}
                                </span>
                                <input type="checkbox" class="section-visible w-4 h-4 rounded-full auto-save"
                                    {{ $section['visible'] ? 'checked' : '' }}>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="sections" id="sectionsInput">
                </form>
            </div>
            <div class="p-4 border-t border-slate-200">
                <button type="submit" form="auto-save-form"
                    class="w-full py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">Simpan
                    Perubahan</button>
            </div>
        </div>

        {{-- LIVE PREVIEW (Sisi Kanan) --}}
        <div
            class="flex-1 flex flex-col items-center justify-start p-4 bg-[linear-gradient(to_right,#e2e8f0_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f0_1px,transparent_1px)] bg-[size:30px_30px] overflow-auto relative">

            {{-- Indikator Loading --}}
            <div id="loader"
                class="absolute top-4 right-4 bg-rose-500 text-white px-4 py-1 rounded-full text-[10px] font-bold uppercase hidden shadow-lg animate-pulse z-50">
                Menyimpan...
            </div>

            <div class="mb-4 flex bg-white p-1 rounded-lg border border-slate-200 shadow-sm z-10">
                <button id="btn-desktop" class="px-4 py-2 text-xs font-bold rounded-lg hover:bg-slate-100 transition"><i
                        class="fa-solid fa-desktop mr-2"></i>Desktop</button>
                <button id="btn-tablet" class="px-4 py-2 text-xs font-bold rounded-lg hover:bg-slate-100 transition"><i
                        class="fa-solid fa-tablet-screen-button mr-2"></i>Tablet</button>
                <button id="btn-mobile" class="px-4 py-2 text-xs font-bold rounded-lg hover:bg-slate-100 transition"><i
                        class="fa-solid fa-mobile-screen-button mr-2"></i>Mobile</button>
            </div>

            <div id="preview-wrapper"
                class="bg-white shadow-2xl border-[8px] border-slate-800 overflow-hidden transition-all duration-300 shrink-0"
                style="width: 375px; height: 667px; border-radius: 40px;">
                <iframe id="preview" src="{{ route('theme-builder.preview', $invitation->id) }}"
                    class="w-full h-full"></iframe>
            </div>
            <div class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest" id="device-label">Mobile View
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewIframe = document.getElementById('preview');
            const loader = document.getElementById('loader');

            function showLoader() {
                loader.classList.remove('hidden');
            }

            function hideLoader() {
                loader.classList.add('hidden');
            }

            // Fungsi Auto Save (untuk background/color/checkbox)
            async function autoSave() {
                showLoader();
                // Persiapkan data section untuk input hidden
                let data = [];
                document.querySelectorAll('#sectionList li').forEach((el, index) => {
                    data.push({
                        type: el.dataset.type,
                        order: index + 1,
                        visible: el.querySelector('.section-visible').checked
                    });
                });
                document.getElementById('sectionsInput').value = JSON.stringify(data);

                // Kirim via Fetch
                let formData = new FormData(document.getElementById('auto-save-form'));
                await fetch("{{ route('theme-builder.update', $invitation->id) }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                previewIframe.contentWindow.location.reload();
                hideLoader();
            }

            // Trigger autosave saat ada perubahan pada elemen dengan class 'auto-save'
            document.querySelectorAll('.auto-save').forEach(el => {
                el.addEventListener('change', autoSave);
            });

            // Inisialisasi Sortable
            new Sortable(document.getElementById('sectionList'), {
                animation: 150,
                onEnd: autoSave
            });

            // Device Switcher
            window.setDevice = function(type) {
                const wrapper = document.getElementById('preview-wrapper');
                const label = document.getElementById('device-label');
                wrapper.style.transition = 'all 0.3s ease';
                if (type === 'desktop') {
                    wrapper.style.width = '100%';
                    wrapper.style.height = '100%';
                    wrapper.style.borderRadius = '0px';
                    label.innerText = 'Desktop View';
                } else if (type === 'tablet') {
                    wrapper.style.width = '768px';
                    wrapper.style.height = '90%';
                    wrapper.style.borderRadius = '20px';
                    label.innerText = 'Tablet View';
                } else {
                    wrapper.style.width = '375px';
                    wrapper.style.height = '667px';
                    wrapper.style.borderRadius = '40px';
                    label.innerText = 'Mobile View';
                }
            }
            document.getElementById('btn-desktop').addEventListener('click', () => setDevice('desktop'));
            document.getElementById('btn-tablet').addEventListener('click', () => setDevice('tablet'));
            document.getElementById('btn-mobile').addEventListener('click', () => setDevice('mobile'));
        });
    </script>
@endpush
