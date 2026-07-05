<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDOM - Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <header class="bg-[#004684] text-white">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('asset/logo_pnc.png') }}" class="h-12 bg-white rounded-full p-1">
                    <div>
                        <p class="text-xs font-semibold text-blue-200">Evaluasi Dosen Oleh Mahasiswa (EDOM)</p>
                        <h1 class="text-xl font-bold">Politeknik Negeri Cilacap</h1>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-bold text-lg">Tahun Akademik 2025/2026</span>
                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="rounded-lg border border-white/70 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white hover:text-[#004684]">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            <nav class="mt-6 flex gap-6 text-sm font-medium">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-1 hover:text-blue-200 transition {{ request()->routeIs('mahasiswa.dashboard') ? 'border-b-2 border-white pb-1' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('panduan') }}"
                    class="flex items-center gap-1 hover:text-blue-200 transition {{ request()->routeIs('mahasiswa.panduan') ? 'border-b-2 border-white pb-1' : '' }}">
                    Panduan
                </a>
            </nav>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-6 py-8">
        @yield('content')
    </main>
</body>
</html>