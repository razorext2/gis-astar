<x-guest-layout>
	<!-- Session Status -->
	@if (session('message'))
		<div class="alert alert-warning">
			{{ session('message') }}
		</div>
	@endif

	<div class="mx-auto w-full md:mx-0 md:w-full lg:w-9/12">
		<div
			class="flex w-full flex-col rounded-xl bg-white p-10 shadow-xl dark:bg-dark-primary dark:ring-1 dark:ring-gray-700">
			<h2 class="mb-2 text-left text-2xl font-bold text-gray-800 dark:text-white">
				Sign In
			</h2>

			<form class="w-full" method="POST" action="{{ route('login') }}">
				@csrf

				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="mb-2 text-left text-gray-500 dark:text-white" for="email" :value="__('Email')" />
					<x-text-input class="mt-1 block w-full"
						class="appearance-none rounded-lg border-2 border-gray-100 px-4 py-3 placeholder-gray-300 focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-600 dark:border-gray-700"
						id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="email"
						placeholder="Please insert your email" />
					<x-input-error class="mt-2" :messages="$errors->get('email')" />
				</div>

				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="mb-2 text-left text-gray-500 dark:text-white" for="password" :value="__('Password')" />

					<x-text-input class="mt-1 block w-full"
						class="appearance-none rounded-lg border-2 border-gray-100 px-4 py-3 placeholder-gray-300 focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-600 dark:border-gray-700"
						id="password" name="password" type="password" required autocomplete="current-password"
						placeholder="Please insert your password" />

					<x-input-error class="mt-2" :messages="$errors->get('password')" />
				</div>

				<div class="mt-4 block">
					<label class="items-left inline-flex text-left" for="remember_me">
						<input
							class="rounded border-gray-300 text-indigo-600 shadow-md focus:ring-indigo-500 dark:border-gray-700 dark:shadow-none"
							id="remember_me" name="remember" type="checkbox">
						<span class="ms-2 text-sm text-gray-600 dark:text-white">{{ __('Remember me') }}</span>
					</label>
				</div>

				<div class="my-5 flex w-full flex-col" id="button">
					<x-primary-button class="w-full rounded-lg bg-green-600 py-4 text-green-100">
						<div class="flex flex-row items-center justify-center">
							<div class="mr-2">
								<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
									xmlns="http://www.w3.org/2000/svg">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
								</svg>
							</div>
							<div class="font-bold">{{ __('Sign In') }}</div>
						</div>
					</x-primary-button>

					<div class="mt-5 flex items-center justify-end text-left">
						@if (Route::has('password.request'))
							<a class="w-full shrink font-medium text-gray-500 dark:text-gray-300" href="{{ route('password.request') }}">
								{{ __('Forgot your password?') }}
							</a>
						@endif
					</div>
				</div>
			</form>
		</div>
	</div>

</x-guest-layout>
