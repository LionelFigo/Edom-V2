<x-guest-layout>
    <x-slot name="title">Konfirmasi Password - EDOM Politeknik Negeri Cilacap</x-slot>
    <x-slot name="subtitle">Verifikasi Keamanan Akun</x-slot>

    <div class="mb-6 text-sm font-medium leading-6 text-slate-500">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-1.5 block w-full"
                            type="password"
                            name="password"
                            placeholder="Masukkan Password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
