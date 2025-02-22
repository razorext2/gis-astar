<table class="z-10 mt-20 w-full text-left text-sm text-gray-800 dark:text-gray-300 sm:mt-4" id="{{ $id }}"
	{{ $attributes }}>
	<thead class="text-xs uppercase">
		<tr class="h-12">
			@foreach ($tablename as $row => $label)
				<th>
					<span class="flex items-center text-gray-800 dark:text-white">
						{{ $label }}
					</span>
				</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
