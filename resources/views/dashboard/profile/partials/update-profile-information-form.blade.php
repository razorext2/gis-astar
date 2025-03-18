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

	<form class="mt-6 space-y-6" method="post" action="{{ route('profile.update') }}">
		@csrf
		@method('patch')

		<div>
			<x-input-label class="dark:text-white" for="name" :value="__('Name')" />
			<x-text-input class="mt-1 block w-full" id="name" name="name" type="text" :value="old('name', $user->name)" required
				autofocus autocomplete="name" />
			<x-input-error class="mt-2" :messages="$errors->get('name')" />
		</div>

		<div class="flex items-center space-x-2">
			<div class="flex-grow">
				<x-input-label class="dark:text-white" for="email" :value="__('Email')" />
				<x-text-input class="mt-1 block w-full disabled:bg-gray-300" id="email" name="email_" type="text"
					:value="old('email', $user->email)" disabled autofocus autocomplete="email" />
				<x-text-input name="email" type="hidden" :value="old('email', $user->email)" />
				<x-input-error class="mt-2" :messages="$errors->get('email')" />
			</div>
			@if (!is_null($user->email_verified_at))
				<span
					class="mt-6 rounded-lg bg-green-200 p-2 text-center text-green-800 shadow-sm ring-1 ring-green-800">Verified</span>
			@else
				<button class="mt-6 rounded-lg bg-red-200 p-2 text-center text-red-800 shadow-sm ring-1 ring-red-800"
					form="send-verification">Not Verified</button>
			@endif
		</div>

		<div class="flex items-center gap-6">
			<button
				class="inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
				type="submit">{{ __('Save') }}</button>
		</div>
	</form>
</section>
