@extends('dashboard.layoutsDash.app')
@section('content')
	<div class="relative grid grid-cols-1 gap-6">

		<div class="rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-[#18181b]">
			<ul class="flex flex-wrap text-center text-sm font-medium">
				<li>
					<a
						class="{{ Route::is('collect.index') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600 x"
						href="{{ route('collect.index') }}">Belum Dilengkapi</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect.submitted') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600 x"
						href="{{ route('collect.submitted') }}">Diajukan</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect.approved') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600 x"
						href="{{ route('collect.approved') }}">Disetujui</a>
				</li>
				<li>
					<a
						class="{{ Route::is('collect.rejected') ? 'text-red-600 border-b border-gray-400' : 'text-gray-600 dark:text-gray-400' }} inline-block rounded-t-lg px-4 py-2 hover:text-red-600 dark:hover:text-red-600 x"
						href="{{ route('collect.rejected') }}">Ditolak</a>
				</li>
				<li>
					<x-button.success class="max-h-10" id="getCollectorExcel" type="button">
						<x-slot name="icon">
							<x-icons.angle-right class="icon h-6 w-6 text-red-500 dark:text-white" />
						</x-slot>
						Tarik Laporan
					</x-button.success>

					</button>
				</li>
			</ul>
		</div>

		<div class="flex h-auto items-center justify-center">
			<div
				class="grid w-full grid-cols-2 gap-2 rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200 dark:bg-[#18181b] dark:ring-gray-700 md:gap-4 md:p-6">

				{{-- filter --}}
				<div class="col-span-2 mb-4">
					<x-filter.filter-bar>
						@can('collect-approve')
							<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
								<x-filter.filter-input-text id="no_sr" name="no_sr" :text="'no SR'">
									<x-icons.fingerprint class="h-4 w-4 text-gray-500 dark:text-gray-400" />
								</x-filter.filter-input-text>
							</div>
						@endcan

						<div class="col-span-2 mx-auto flex w-full items-center lg:col-span-1">
							<x-filter.filter-input-text id="title" name="title" :text="'nama customer'">
								<x-icons.font-case class="h-4 w-4 text-gray-500 dark:text-gray-400" />
							</x-filter.filter-input-text>
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.filter-input-select id="status" name="status" :options="['0' => 'Belum di lengkapi', '1' => 'Disetujui', '2' => 'Diajukan', '3' => 'Ditolak']" default-option="Filter by status" />
						</div>

						<div class="col-span-2 mx-auto w-full items-center lg:col-span-1">
							<x-filter.date-range />
						</div>

					</x-filter.filter-bar>
				</div>
				{{-- end filter --}}

				{{-- subcontent --}}
				@yield('subcontent')

			</div>
		</div>
	</div>
@endsection
@push('script')
	<script>
		$('#getCollectorExcel').click(async function() {
			const {
				value: date
			} = await Swal.fire({
				title: "Pilih tanggal laporan",
				showCancelButton: true,
				input: "date",
				didOpen: () => {
					const today = (new Date()).toISOString();
				}
			});

			if (date) {
				// jika tanggal diisi
				axios.get(`{{ route('export.collector') }}/?date=${date}`)
					.then(function() {
						Swal.fire({
							title: "Berhasil, data kamu sedang diexport",
							icon: "success",
							timer: 1000,
						});
					})
					.catch(function(error) {
						Swal.fire({
							title: `Gagal`,
							text: error,
							icon: "error",
							timer: 1000,
						});
					});
			} else {
				// jika tanggal tidak diisi
				Swal.fire({
					title: 'Tanggal tidak boleh kosong!',
					icon: 'error',
					showConfirmButton: false,
					timer: 1000,
				});
			}
		})
	</script>
@endpush
