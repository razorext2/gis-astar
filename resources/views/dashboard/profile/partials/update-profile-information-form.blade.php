<section>
    <header class="mb-6 border-b border-zinc-200 pb-5 dark:border-zinc-800">
        <h2 class="text-base font-bold text-zinc-900 dark:text-white">
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
            {{ __('Perbarui nama, email, dan data pribadi akun Anda.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form class="space-y-4" method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- Email --}}
        <div>
            <x-input-label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300" for="email"
                :value="__('Email')" />
            <div class="flex items-center gap-2">
                <x-text-input
                    class="block w-full rounded-xl border-0 bg-zinc-100 px-4 py-2.5 text-sm text-zinc-500 ring-1 ring-zinc-200 disabled:cursor-not-allowed dark:bg-zinc-800 dark:text-zinc-400 dark:ring-zinc-700"
                    id="email" name="email_" type="text" :value="old('email', $user->email)" disabled autocomplete="email" />
                <x-text-input name="email" type="hidden" :value="old('email', $user->email)" />
                @if (!is_null($user->email_verified_at))
                    <span
                        class="flex shrink-0 items-center gap-1 rounded-lg bg-green-100 px-2.5 py-1.5 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                clip-rule="evenodd" />
                        </svg>
                        Verified
                    </span>
                @else
                    <button form="send-verification"
                        class="flex shrink-0 items-center gap-1 rounded-lg bg-amber-100 px-2.5 py-1.5 text-xs font-semibold text-amber-700 transition-colors hover:bg-amber-200 dark:bg-amber-900/30 dark:text-amber-400">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        Verifikasi
                    </button>
                @endif
            </div>
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />
        </div>

        {{-- Nama Lengkap --}}
        <div>
            <x-input.basic id="name" name="name" value="{{ old('name', $user->name) }}" required
                autocomplete="name">
                Nama Lengkap
            </x-input.basic>
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        @if (auth()->user()->kode_pegawai)
            {{-- Nama Panggilan --}}
            <div>
                <x-input.basic id="nick_name" name="nick_name" value="{{ old('nick_name', $data->nick_name ?? null) }}"
                    required autocomplete="nick_name">
                    Nama Panggilan
                </x-input.basic>
                <x-input-error class="mt-1.5" :messages="$errors->get('nick_name')" />
            </div>

            {{-- NIK --}}
            <div>
                <x-input.basic id="nik_pegawai" name="nik_pegawai"
                    value="{{ old('nik_pegawai', $data->nik_pegawai ?? null) }}" required autocomplete="nik_pegawai">
                    NIK
                </x-input.basic>
                <x-input-error class="mt-1.5" :messages="$errors->get('nik_pegawai')" />
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <x-input.basic id="no_telp" name="no_telp" value="{{ old('no_telp', $data->no_telp ?? null) }}"
                    required autocomplete="no_telp">
                    Nomor Telepon/Whatsapp
                </x-input.basic>
                <x-input-error class="mt-1.5" :messages="$errors->get('no_telp')" />
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <x-input.date id="tgl_lahir" name="tgl_lahir" :value="old('tgl_lahir', $data->tgl_lahir ?? null)" required autocomplete="tgl_lahir">
                    Tanggal Lahir
                </x-input.date>
                <x-input-error class="mt-1.5" :messages="$errors->get('tgl_lahir')" />
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <x-input.select id="gender" name="gender" :options="[
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan',
                ]" :value="old('gender', $data->gender ?? null)" required
                    autocomplete="gender" defaultOption="Pilih gender">
                    <x-slot name="textLabel">Jenis Kelamin</x-slot>
                </x-input.select>
                <x-input-error class="mt-1.5" :messages="$errors->get('gender')" />
            </div>

            {{-- Alamat --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-zinc-700 dark:text-zinc-300"
                    for="alamat">Alamat</label>
                <x-input.textarea id="alamat" :labels="true" name="alamat"
                    value="{{ old('alamat', $data->alamat ?? null) }}" required autocomplete="alamat">
                    {{ old('alamat', $data->alamat ?? null) }}
                </x-input.textarea>
                <x-input-error class="mt-1.5" :messages="$errors->get('alamat')" />
            </div>
        @endif

        {{-- Save Button --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-md hover:shadow-red-500/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm font-medium text-green-600 dark:text-green-400" x-data="{ show: true }" x-show="show"
                    x-transition x-init="setTimeout(() => show = false, 2500)">
                    {{ __('Tersimpan!') }}
                </p>
            @endif
        </div>
    </form>
</section>
