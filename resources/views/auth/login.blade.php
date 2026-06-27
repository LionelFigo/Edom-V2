<x-guest-layout>
    <x-slot name="title">Login - EDOM Politeknik Negeri Cilacap</x-slot>
    <x-slot name="subtitle">Masuk dan Verifikasi Akun</x-slot>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" placeholder="Masukkan Email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <div x-data="{ showPassword: false }" class="relative mt-1.5">
                <x-text-input id="password" class="block w-full pr-12"
                                x-bind:type="showPassword ? 'text' : 'password'"
                                name="password"
                                placeholder="Masukkan Password"
                                required autocomplete="current-password" />

                <button type="button" x-on:click="showPassword = ! showPassword" class="absolute inset-y-0 right-3 flex items-center text-slate-400 transition hover:text-slate-600" aria-label="Tampilkan password">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#004684] shadow-sm focus:ring-[#004684]" name="remember">
                <span class="ms-2 text-sm font-medium text-slate-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="rounded-md text-sm font-medium text-[#004684] transition hover:text-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004684] focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-sm font-medium text-slate-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[#004684] transition hover:text-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004684] focus:ring-offset-2">
                    Register
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>
