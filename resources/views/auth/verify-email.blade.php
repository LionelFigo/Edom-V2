<x-guest-layout>
    <x-slot name="title">Verifikasi Email - EDOM Politeknik Negeri Cilacap</x-slot>
    <x-slot name="subtitle">Verifikasi Alamat Email</x-slot>

    <div class="mb-6 text-sm font-medium leading-6 text-slate-500">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 rounded-r-lg border-l-4 border-emerald-500 bg-emerald-50 p-4 text-sm font-medium text-emerald-700">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="rounded-md text-sm font-medium text-slate-500 transition hover:text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#004684] focus:ring-offset-2">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
