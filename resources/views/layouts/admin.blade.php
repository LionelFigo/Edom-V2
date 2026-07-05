<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - EDOM PNC</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .active-menu { background-color: #004684; color: white !important; border-radius: 0.3rem; }
    </style>
</head>
<body class="bg-[#F8FAFC]">

    <header class="bg-[#004684] text-white p-4 flex justify-between items-center fixed w-full top-0 z-50 shadow-md">
        <div class="flex items-center gap-3">
            <img src="{{ asset('asset/logo_pnc.png') }}" class="h-12 bg-white rounded-full p-1" alt="Logo PNC">
            <div>
                <p class="text-[10px] uppercase tracking-wider opacity-80">Evaluasi Dosen Oleh Mahasiswa (EDOM)</p>
                <h1 class="text-xl font-bold">Politeknik Negeri Cilacap</h1>
            </div>
        </div>
        
        <div class="flex items-center gap-6">
            <span class="font-bold text-lg">Tahun Akademik 2025/2026</span>
        </div>
    </header>

    <div class="flex pt-20">
        <aside class="w-64 bg-white min-h-screen fixed left-0 p-4 border-r border-slate-200">
            <nav class="space-y-1 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-50 transition {{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.dosen.index') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-50 transition {{ request()->routeIs('admin.dosen.index') ? 'active-menu' : '' }}">
                    <span>Data Dosen</span>
                </a>

                <a href="{{ route('admin.mata_kuliah.index') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-50 transition {{ request()->routeIs('admin.mata_kuliah.index') ? 'active-menu' : '' }}">
                    <span>Data Mata Kuliah</span>
                </a>

                <a href="{{ route('admin.pertanyaan.index') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-50 transition {{ request()->routeIs('admin.pertanyaan.index') ? 'active-menu' : '' }}">
                    <span>Data Pertanyaan</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-6 pt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 p-3 bg-red-100 text-red-600 hover:bg-red-200 transition rounded border border-red-300 font-bold text-sm cursor-pointer">
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 ml-64 p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>