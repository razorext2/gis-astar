<table class="w-full border-b-red-600 text-xs">
	<thead>
		<tr>
			@foreach ($data as $item)
				<th class="w-1/{{ count($item) + 1 }}"> {{ $item['title'] }} </th>
			@endforeach
		</tr>
	</thead>

	<tbody>
		<tr>
			@foreach ($data as $item)
				<td>{{ $item['data'] }}</td>
			@endforeach
		</tr>
	</tbody>
</table>
