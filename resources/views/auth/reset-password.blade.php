<x-guest-layout>

	<div class="mx-auto w-full md:mx-0 md:w-full lg:w-9/12">
		<div
			class="flex w-full flex-col rounded-xl bg-white p-10 shadow-xl dark:bg-dark-primary dark:ring-1 dark:ring-gray-700">
			<h2 class="mb-5 text-left text-2xl font-bold text-gray-800 dark:text-white">
				Forgot Password
			</h2>
			<div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
				{{ __('Just write your new ones password. But this time, DONT forget it!') }}
			</div>
			<form method="POST" action="{{ route('password.store') }}">
				@csrf

				<!-- Password Reset Token -->
				<input name="token" type="hidden" value="{{ $request->route('token') }}">

				<!-- Email Address -->
				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="mb-2 text-gray-500 dark:text-white" for="email" :value="__('Email')" />
					<x-text-input
						class="appearance-none rounded-lg border-2 border-gray-100 px-4 py-3 placeholder-gray-300 focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-600 dark:border-gray-700 dark:placeholder-gray-500"
						id="email" name="email" type="email" placeholder="Please insert your email" :value="old('email', $request->email)" required
						autofocus autocomplete="username" />
					<x-input-error class="mt-2" :messages="$errors->get('email')" />
				</div>

				<!-- Password -->
				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="mb-2 text-gray-500 dark:text-white" for="password" :value="__('Password')" />
					<x-text-input
						class="appearance-none rounded-lg border-2 border-gray-100 px-4 py-3 placeholder-gray-300 focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-600 dark:border-gray-700 dark:placeholder-gray-500"
						id="password" name="password" type="password" placeholder="Please insert your password." required
						autocomplete="new-password" />
					<x-input-error class="mt-2" :messages="$errors->get('password')" />
				</div>

				<!-- Confirm Password -->
				<div class="my-5 flex w-full flex-col" id="input">
					<x-input-label class="mb-2 text-gray-500 dark:text-white" for="password_confirmation" :value="__('Confirm Password')" />

					<x-text-input
						class="appearance-none rounded-lg border-2 border-gray-100 px-4 py-3 placeholder-gray-300 focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-600 dark:border-gray-700 dark:placeholder-gray-500"
						id="password_confirmation" name="password_confirmation" type="password"
						placeholder="Please insert your password again." required autocomplete="new-password" />

					<x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
				</div>

				<div class="mt-4 flex items-center justify-end">
					<x-primary-button class="w-full rounded-lg bg-green-600 py-4 text-green-100">
						<div class="flex flex-row items-center justify-center">
							<div class="mr-2 rotate-180">
								<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
									xmlns="http://www.w3.org/2000/svg">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
								</svg>
							</div>
							<div class="font-bold">Reset Password</div>
						</div>
					</x-primary-button>
				</div>
			</form>
		</div>
	</div>
</x-guest-layout>
