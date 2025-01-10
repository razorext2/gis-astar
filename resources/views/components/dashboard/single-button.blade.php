<form id="{{ $data['id'] }}" action="{{ $data['action'] }}"></form>
<x-button.primary class="my-auto me-4 max-h-10 text-sm" form="{{ $data['id'] }}" type="submit">
	{{ $data['label'] }}
</x-button.primary>
