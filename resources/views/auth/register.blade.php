<x-guest-layout>
    <x-slot name="title">Register - EDOM Politeknik Negeri Cilacap</x-slot>
    <x-slot name="subtitle">Daftar Akun Mahasiswa</x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-1.5 block w-full" type="text" name="name" :value="old('name')" placeholder="Masukkan Nama" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-1.5 block w-full" type="email" name="email" :value="old('email')" placeholder="Masukkan Email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="prodi_id" :value="__('Program Studi')" />
            <select id="prodi_id" name="prodi_id" class="mt-1.5 block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 shadow-sm transition-all focus:border-transparent focus:outline-none focus:ring-2 focus:ring-[#004684]">
                @foreach(\Illuminate\Support\Facades\DB::table('prodi')->get() as $prodi)
                    <option value="{{ $prodi->id }}" @selected(old('prodi_id') == $prodi->id)>{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="semester_aktif" :value="__('Semester')" />
            <x-text-input id="semester_aktif" class="mt-1.5 block w-full" type="number" name="semester_aktif" :value="old('semester_aktif')" placeholder="Masukkan Semester" required />
            <x-input-error :messages="$errors->get('semester_aktif')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="mt-1.5 block w-full"
                            type="password"
                            name="password"
                            placeholder="Masukkan Password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="mt-1.5 block w-full"
                            type="password"
                            name="password_confirmation" placeholder="Konfirmasi Password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <a class="rounded-md text-sm font-medium text-[#004684] transition hover:text-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004684] focus:ring-offset-2" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
