<span
	class="bg-{{ $status == 1 ? 'green' : 'yellow' }}-100 text-{{ $status == 1 ? 'green' : 'yellow' }}-800 dark:bg-{{ $status == 1 ? 'green' : 'yellow' }}-900 dark:text-{{ $status == 1 ? 'green' : 'yellow' }}-300 me-2 rounded-full px-2.5 py-0.5 text-xs font-medium">
	{{ $status == 1 ? 'Ready' : 'Running' }}
</span>
