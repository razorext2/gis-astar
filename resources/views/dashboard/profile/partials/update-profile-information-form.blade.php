<section>
	<header>
		<h2 class="text-lg font-medium text-gray-900 dark:text-white">
			{{ __('Change your name and email') }}
		</h2>

		<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
			{{ __("Update your account's profile information and email address.") }}
		</p>
	</header>

	<form id="send-verification" method="post" action="{{ route('verification.send') }}">
		@csrf
	</form>

	<form class="mt-6 space-y-4" method="post" action="{{ route('profile.update') }}">
		@csrf
		@method('patch')

		<div class="flex items-center space-x-2">
			<div class="flex-grow">
				<x-input-label class="dark:text-white" for="email" :value="__('Email')" />
				<x-text-input class="mt-1 block w-full disabled:bg-gray-300" id="email" name="email_" type="text"
					:value="old('email', $user->email)" disabled autocomplete="email" />
				<x-text-input name="email" type="hidden" :value="old('email', $user->email)" />
				<x-input-error class="mt-2" :messages="$errors->get('email')" />
			</div>
			@if (!is_null($user->email_verified_at))
				<span
					class="mt-6 rounded-lg bg-green-200 p-2 text-center text-green-800 shadow-md ring-1 ring-green-800 dark:shadow-none">Verified</span>
			@else
				<button
					class="mt-6 rounded-lg bg-red-200 p-2 text-center text-red-800 shadow-md ring-1 ring-red-800 dark:shadow-none"
					form="send-verification">Not Verified</button>
			@endif
		</div>

		<div class="w-full">
			<x-input.basic id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
				Nama Lengkap
			</x-input.basic>
			<x-input-error class="mt-2" :messages="$errors->get('name')" />
		</div>

		@if (auth()->user()->kode_pegawai)
			<div class="w-full">
				<x-input.basic id="nick_name" name="nick_name" value="{{ old('nick_name', $data->nick_name ?? null) }}" required
					autocomplete="nick_name">
					Nama Panggilan
				</x-input.basic>
				<x-input-error class="mt-2" :messages="$errors->get('nick_name')" />
			</div>

			<div class="w-full">
				<x-input.basic id="nik_pegawai" name="nik_pegawai" value="{{ old('nik_pegawai', $data->nik_pegawai ?? null) }}"
					required autocomplete="nik_pegawai">
					NIK
				</x-input.basic>
				<x-input-error class="mt-2" :messages="$errors->get('nik_pegawai')" />
			</div>

			<div class="w-full">
				<x-input.basic id="no_telp" name="no_telp" value="{{ old('no_telp', $data->no_telp ?? null) }}" required
					autocomplete="no_telp">
					Nomor Telepon/Whatsapp
				</x-input.basic>
				<x-input-error class="mt-2" :messages="$errors->get('no_telp')" />
			</div>

			<div class="w-full">
				<x-input.date id="tgl_lahir" name="tgl_lahir" :value="old('tgl_lahir', $data->tgl_lahir ?? null)" required autocomplete="tgl_lahir">
					Tanggal Lahir
				</x-input.date>
				<x-input-error class="mt-2" :messages="$errors->get('tgl_lahir')" />
			</div>

			<div class="w-full">
				<x-input.select id="gender" name="gender" :options="[
				    'Laki-laki' => 'Laki-laki',
				    'Perempuan' => 'Perempuan',
				]" :value="old('gender', $data->gender ?? null)" required autocomplete="gender"
					defaultOption="Pilih gender">
					<x-slot name="textLabel">
						Jenis Kelamin
					</x-slot>
				</x-input.select>
				<x-input-error class="mt-2" :messages="$errors->get('gender')" />
			</div>

			<div class="w-full">
				<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="Alamat">
					Alamat
				</label>
				<x-input.textarea id="alamat" :labels="true" name="alamat"
					value="{{ old('alamat', $data->alamat ?? null) }}" required autocomplete="alamat">
					{{ old('alamat', $data->alamat ?? null) }}
				</x-input.textarea>
				<x-input-error class="mt-2" :messages="$errors->get('alamat')" />
			</div>
		@endif

		<div class="flex items-center gap-6">
			<button
				class="inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 transition-all duration-300 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
				type="submit">{{ __('Save') }}</button>
		</div>
	</form>
</section>
