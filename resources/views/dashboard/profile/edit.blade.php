@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="grid gap-4 lg:grid-cols-2">
		<div
			class="col-span-2 grid w-full grid-cols-2 gap-4 rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-8">

			<div class="col-span-2 lg:col-span-1" x-data="{ open: false }">
				<header class="mb-4">
					<h2 class="text-lg font-medium text-gray-900 dark:text-white">
						{{ __('Profile Information') }}
					</h2>

					<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
						{{ __("Update your account's profile information and email address.") }}
					</p>
				</header>

				<div class="relative w-full">
					<img class="h-72 w-full rounded-md object-cover object-top ring-1 ring-gray-200 dark:ring-gray-700"
						src="{{ auth()->user()->profile_pic ? asset('storage/profile-pictures/' . auth()->user()->profile_pic) : asset('assets/img/profile-picture-5.jpg') }}"
						alt="">

					<button
						class="absolute bottom-0 left-0 w-full rounded-b-md bg-red-800 py-2 text-white transition-colors duration-500 hover:bg-red-700"
						type="button" @click="open = ! open" id="editButton">Ubah</button>
				</div>

				<div x-show="open" x-transition>
					@livewire('utils.profile-picture-uploader')
				</div>
			</div>

			<div class="col-span-2 flex flex-col gap-y-2 lg:col-span-1 lg:ml-4 lg:mt-16">
				<h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h2>

				@if (auth()->user()->kode_pegawai)
					@livewire('handler.point.bio-edit')
				@endif

				<div class="flex w-full items-center gap-x-2">
					<span class="w-fit rounded-xl bg-green-600 px-2 py-0.5 text-sm text-green-200">
						{{ auth()->user()->roles->pluck('name')->implode(', ') }}
					</span>
					<span class="text-md text-gray-600 dark:text-gray-300">
						{{ auth()->user()->email }}
					</span>
				</div>

				@livewire('inspire-component')

			</div>
		</div>

		<div
			class="col-span-2 rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-8 lg:col-span-1">
			<div class="w-full">
				@include('dashboard.profile.partials.update-profile-information-form')
			</div>
		</div>

		<div
			class="col-span-2 rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-8 lg:col-span-1">
			<div class="w-full">
				@include('dashboard.profile.partials.update-password-form')
			</div>
		</div>

		<div
			class="col-span-2 rounded-lg bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-dark-primary dark:ring-gray-700 sm:p-8">
			<div class="w-full">
				@include('dashboard.profile.partials.delete-user-form')
			</div>
		</div>
	</div>
@endsection
