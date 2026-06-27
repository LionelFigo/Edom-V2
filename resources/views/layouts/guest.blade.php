<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title : config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 text-slate-900 antialiased" style="font-family: 'Inter', sans-serif;">
        <main class="flex min-h-screen items-center justify-center p-6">
            <section class="w-full max-w-md rounded-2xl border border-slate-100 bg-white p-8 shadow-xl shadow-slate-200/80 md:p-10">
                <div class="mb-6 flex h-20 justify-center">
                     <img src="{{ asset('asset/logo_pnc.png') }}" alt="Logo PNC" class="h-20 w-auto"> 
                </div>

                <div class="mb-8 text-center">
                    <h1 class="text-xl font-bold leading-tight text-slate-800">Sistem Evaluasi Dosen Oleh Mahasiswa</h1>
                    <h2 class="mb-2 text-xl font-bold text-slate-800">(EDOM)</h2>
                    <p class="text-sm font-medium text-slate-500">
                        {{ $subtitle ?? 'Masuk dan Verifikasi Akun' }}
                    </p>
                </div>

                {{ $slot }}
            </section>
        </main>
    </body>
</html>
