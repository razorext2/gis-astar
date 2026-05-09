@props(['labels' => true, 'id', 'name', 'placeholder' => null, 'rows' => 4, 'textLabel' => null])

@if ($labels)
    <label class="mb-2 block text-sm font-medium text-zinc-900 dark:text-white"
        for="{{ $id }}">{{ $textLabel }}</label>
@endif

<textarea id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-zinc-200 bg-zinc-50 p-2.5 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500 dark:border-zinc-800 dark:bg-zinc-900 dark:text-white dark:placeholder-zinc-500 dark:focus:border-blue-500 dark:focus:ring-blue-500']) }}
    rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $attributes }}>{{ $slot }}</textarea>
