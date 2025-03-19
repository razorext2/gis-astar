<x-guest-layout>

	<div class="mx-auto w-full md:mx-0 md:w-full lg:w-9/12">
		<div
			class="flex w-full flex-col rounded-xl bg-white p-10 shadow-xl dark:bg-dark-primary dark:ring-1 dark:ring-gray-700">
			<h2 class="mb-5 text-left text-2xl font-bold text-gray-800 dark:text-white">
				Register
			</h2>
			<form class="w-full" method="POST" action="{{ route('register') }}">
				@csrf

				<!-- Name -->
				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="dark:text-white" for="name" :value="__('Name')" />
					<x-text-input class="mt-1 block w-full" id="name" name="name" type="text" :value="old('name')" required
						autofocus autocomplete="name" />
					<x-input-error class="mt-2" :messages="$errors->get('name')" />
				</div>

				<!-- Email Address -->
				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="dark:text-white" for="email" :value="__('Email')" />
					<x-text-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" required
						autocomplete="username" />
					<x-input-error class="mt-2" :messages="$errors->get('email')" />
				</div>

				<!-- Password -->
				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="dark:text-white" for="password" :value="__('Password')" />

					<x-text-input class="mt-1 block w-full" id="password" name="password" type="password" required
						autocomplete="new-password" />

					<x-input-error class="mt-2" :messages="$errors->get('password')" />
				</div>

				<!-- Confirm Password -->
				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="dark:text-white" for="password_confirmation" :value="__('Confirm Password')" />

					<x-text-input class="mt-1 block w-full" id="password_confirmation" name="password_confirmation" type="password"
						required autocomplete="new-password" />

					<x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
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
							<div class="font-bold">{{ __('Register') }}</div>
						</div>
					</x-primary-button>

					<div class="mt-5 flex items-center justify-end">
						@if (Route::has('login'))
							<a class="w-full shrink font-medium text-gray-500 dark:text-white" href="{{ route('login') }}">
								{{ __('Already have an account?') }}
							</a>
						@endif
						<!-- <p> Or </p>
																																<a class="w-full font-medium text-gray-500" href="#">Register!</a> -->
					</div>
				</div>
			</form>
		</div>
	</div>
</x-guest-layout>
