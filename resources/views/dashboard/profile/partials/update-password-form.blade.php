<section>
	<header>
		<h2 class="text-lg font-medium text-gray-900 dark:text-white">
			{{ __('Update Password') }}
		</h2>

		<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
			{{ __('Ensure your account is using a long, random password to stay secure.') }}
		</p>
	</header>

	<form class="mt-6 space-y-6" method="post" action="{{ route('password.update') }}">
		@csrf
		@method('put')

		<x-text-input class="mt-1 block w-full" id="username" name="username" type="hidden" autocomplete="username" />

		<div>
			<x-input-label class="dark:text-white" for="update_password_current_password" :value="__('Current Password')" />
			<x-text-input class="mt-1 block w-full" id="update_password_current_password" name="current_password" type="password"
				autocomplete="current-password" />
			<x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
		</div>

		<div>
			<x-input-label class="dark:text-white" for="update_password_password" :value="__('New Password')" />
			<x-text-input class="mt-1 block w-full" id="update_password_password" name="password" type="password"
				autocomplete="new-password" />
			<x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
		</div>

		<div>
			<x-input-label class="dark:text-white" for="update_password_password_confirmation" :value="__('Confirm Password')" />
			<x-text-input class="mt-1 block w-full" id="update_password_password_confirmation" name="password_confirmation"
				type="password" autocomplete="new-password" />
			<x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
		</div>

		<div class="flex items-center gap-6">
			<button
				class="inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
				type="submit">{{ __('Save') }}</button>

			@if (session('status') === 'password-updated')
				<p class="text-sm text-gray-600" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
					{{ __('Saved.') }}</p>
			@endif
		</div>
	</form>
</section>
