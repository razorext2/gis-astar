<table class="z-10 mt-20 w-full text-left text-sm text-zinc-800 dark:text-zinc-300 sm:mt-4" id="{{ $id }}"
	{{ $attributes }}>
	<thead class="text-xs uppercase">
		<tr class="h-12">
			@foreach ($tablename as $row => $label)
				<th>
					<span class="flex items-center text-zinc-800 dark:text-white">
						{{ $label }}
					</span>
				</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
