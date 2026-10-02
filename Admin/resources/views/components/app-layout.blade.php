<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAPA - Sistem Pelaporan Kasus</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-rose-50/30 text-gray-800 font-sans antialiased min-h-screen flex">

    <!-- Sidebar Component -->
    <x-sidebar />

    <!-- Main Content Area -->
    <main class="flex-1 p-8 overflow-y-auto">
        {{ $slot }}
    </main>

</body>
</html>