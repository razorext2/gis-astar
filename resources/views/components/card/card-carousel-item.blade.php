@props(['color', 'label', 'id', 'dataName', 'total', 'data'])

<div class="inline-block snap-start scroll-ml-6">
	<div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">

		<div class="group relative h-28 w-96 bg-white group-hover:top-0 dark:bg-[#18181b]">

			<div
				class="relative -left-32 top-0 w-96 rounded-xl px-5 pb-10 pt-9 text-base font-semibold opacity-0 transition-all duration-700 group-hover:-left-3 group-hover:bg-transparent group-hover:opacity-100">
				<div class="flex flex-col">
					<div class="flex items-center gap-1 text-gray-900">
						<div class="flex items-center rounded-full px-5 py-2 dark:text-white">
							<p class="text-{{ $color }}-700 text-lg leading-tight">{{ $total }}</p>
						</div>
						<p class="text-lg text-gray-800 dark:text-white"> Kali</p>
					</div>
				</div>
			</div>
			<div
				class="absolute -right-0 top-0 h-full w-96 self-end border-none px-5 py-2 text-base font-semibold transition-all duration-700 group-hover:-right-14 group-hover:w-64">
				<div
					class="absolute left-0 top-5 flex h-auto w-[395px] cursor-pointer transition-all duration-700 group-hover:-left-44 group-hover:top-10">
					<div class="w-full rounded-lg" id="{{ $id }}" {{ $dataName }}='{{ $data }}'></div>
				</div>
				<p class="absolute top-3 text-lg font-medium text-gray-800 transition-all duration-700 dark:text-white">
					{{ $label }}
				</p>
			</div>
		</div>
	</div>
</div>
