@props([
    'href' => '#',
    'label' => '',
    'active' => false,
    'classes' => '',
])

<a {{ $attributes }} class="group inline-flex flex-col items-center justify-center rounded-tl-2xl px-5"
	href="{{ $href }}">
	{{ $slot }}
	<span class="sr-only">{{ $label }}</span>
</a>
