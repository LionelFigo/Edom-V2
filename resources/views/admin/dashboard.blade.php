<x-app-layout>
    <x-slot name="header"><h2>Dashboard Admin</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6">Selamat datang, Admin {{ Auth::user()->name }}</div>
        </div>
    </div>
</x-app-layout>