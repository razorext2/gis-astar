<select id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'dark:bg-zinc-900 dark:border-zinc-800 dark:placeholder-zinc-500 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 block w-full rounded-lg border border-zinc-200 bg-zinc-50 p-2.5 text-sm text-zinc-900 focus:border-blue-500 focus:ring-blue-500']) }}>
    <option value="">{{ $defaultOption }}</option>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
