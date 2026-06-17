<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <script>
        function showLockedAlert(featureName, upgradeUrl) {
            Swal.fire({
                title: 'Fitur Terkunci',
                text: 'Anda tidak memiliki akses ke fitur ' + featureName + '. Silakan upgrade paket Anda.',
                icon: 'lock',
                iconHtml: '🔒',
                showCancelButton: true,
                confirmButtonColor: '#6d28d9',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Upgrade Paket',
                cancelButtonText: 'Batal',
                customClass: {
                    title: 'font-serif text-2xl text-slate-800',
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-full px-6 font-semibold',
                    cancelButton: 'rounded-full px-6 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed && upgradeUrl) {
                    window.location.href = upgradeUrl;
                }
            });
        }
    </script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
