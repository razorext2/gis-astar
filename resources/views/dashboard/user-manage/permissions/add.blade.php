@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="w-full space-y-6 xl:w-6/12 2xl:w-1/3">
		<div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 sm:p-6">
			<div class="max-w-xl">
				<header class="flex flex-row">
					<a
						class="mb-4 mr-3 flex flex-row rounded-lg px-2.5 py-2.5 align-middle ring-1 ring-red-700 hover:bg-red-300 dark:bg-red-800 dark:text-white dark:ring-gray-700 dark:hover:bg-red-900 md:px-4"
						href="{{ route('permissions.index') }}">
						<svg class="dark:fill-white" class="icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25"
							viewBox="0 0 1024 1024" fill="#000000" version="1.1">
							<path
								d="M669.6 849.6c8.8 8 22.4 7.2 30.4-1.6s7.2-22.4-1.6-30.4l-309.6-280c-8-7.2-8-17.6 0-24.8l309.6-270.4c8.8-8 9.6-21.6 2.4-30.4-8-8.8-21.6-9.6-30.4-2.4L360.8 480.8c-27.2 24-28 64-0.8 88.8l309.6 280z"
								fill="" />
						</svg>
						Kembali
					</a>
					<h2 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
						{{ __('Tambah Data Permission') }}
					</h2>

				</header>
				<p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
					{{ __('Silahkan sesuaikan data dibawah ini dengan data yang benar.') }}
				</p>

				<form class="mt-4" action="{{ route('permissions.store') }}" method="POST">
					@csrf
					<div class="mb-4 grid gap-6 sm:mb-5 sm:gap-6" id="permissionInputs">
						<div class="w-full">
							<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="name">Nama
								Permission</label>

							<div class="flex">
								<div class="relative w-full">
									<input
										class="rounded-gray-100 rounded-2 z-20 block w-full rounded-lg border border-gray-300 bg-white p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500"
										id="name" id="search-dropdown" name="name[]" type="text" placeholder="Permission" required />
									<button
										class="absolute end-0 top-0 h-full rounded-e-lg border border-blue-700 bg-blue-700 p-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
										id="addPermission" type="button">
										<svg class="h-6 w-6 stroke-gray-300 dark:stroke-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
											<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
											<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
											</g>
											<g id="SVGRepo_iconCarrier">
												<path d="M6 12H18M12 6V18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
											</g>
										</svg>
									</button>
								</div>
							</div>
						</div>
					</div>

					<div class="itemcenter mt-4 flex">
						<button
							class="inline-flex items-center rounded-lg px-5 py-2.5 text-center text-sm font-medium text-gray-900 ring-1 ring-blue-700 hover:bg-blue-800 hover:text-white focus:text-white focus:ring-4 focus:ring-blue-300 dark:bg-blue-800 dark:text-white dark:ring-gray-700 dark:hover:bg-blue-900"
							type="submit">
							Submit
							<svg class="ms-2 h-3.5 w-3.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
								viewBox="0 0 14 10">
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M1 5h12m0 0L9 1m4 4L9 9" />
							</svg>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		document.getElementById('addPermission').addEventListener('click', function() {
			// Create a new input field
			const newInput = document.createElement('div');
			newInput.classList.add('w-full', 'mt-2'); // Add any necessary classes
			newInput.innerHTML = `
                <div class="flex">
                                <div class="relative w-full">
                                    <input type="text" name="name[]" id="name" id="search-dropdown"
                                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-white rounded-lg rounded-gray-100 rounded-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                                        placeholder="Permission" required />
                                </div>
                            </div>
            `;
			// Append the new input to the form
			document.getElementById('permissionInputs').appendChild(newInput);
		});
	</script>
@endsection
