<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bagikan Lokasi Kehadiran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center">
        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-location-dot text-4xl text-purple-600"></i>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Halo, {{ $guest->name }}!</h1>
        <p class="text-gray-600 mb-8">Terima kasih telah hadir. Mohon bagikan lokasi Anda untuk membantu kami mempersiapkan acara.</p>

        @if($guest->is_location_shared)
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg mb-6">
                <i class="fa-solid fa-check-circle mr-2"></i> Anda sudah membagikan lokasi kehadiran. Terima kasih!
            </div>
            <p class="text-sm text-gray-500">Anda dapat menutup halaman ini.</p>
        @else
            <button id="shareLocationBtn" onclick="requestLocation()" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> Bagikan Lokasi Saya Sekarang
            </button>
            <p id="statusMsg" class="text-sm text-gray-500 mt-4 hidden">Meminta akses lokasi...</p>
        @endif
    </div>

    <script>
        function requestLocation() {
            const btn = document.getElementById('shareLocationBtn');
            const statusMsg = document.getElementById('statusMsg');
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
            statusMsg.classList.remove('hidden');

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        statusMsg.innerText = "Lokasi didapatkan. Mengirim data...";
                        sendLocation(position.coords.latitude, position.coords.longitude);
                    },
                    function(error) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Coba Lagi';
                        statusMsg.classList.add('hidden');
                        
                        let errorMsg = "Terjadi kesalahan saat mengambil lokasi.";
                        if(error.code === 1) errorMsg = "Akses lokasi ditolak. Mohon izinkan akses lokasi di browser Anda.";
                        if(error.code === 2) errorMsg = "Lokasi tidak tersedia.";
                        if(error.code === 3) errorMsg = "Waktu permintaan habis.";
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: errorMsg
                        });
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Bagikan Lokasi Saya Sekarang';
                statusMsg.classList.add('hidden');
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Didukung',
                    text: 'Browser Anda tidak mendukung fitur lokasi (Geolocation).'
                });
            }
        }

        function sendLocation(lat, lng) {
            fetch('{{ route('guest.checkin.store', $guest->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                document.getElementById('shareLocationBtn').disabled = false;
                document.getElementById('shareLocationBtn').innerHTML = '<i class="fa-solid fa-paper-plane"></i> Coba Lagi';
                document.getElementById('statusMsg').classList.add('hidden');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message || 'Terjadi kesalahan sistem.'
                });
            });
        }
    </script>
</body>
</html>
