<select id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'dark:bg-gray-700 dark:border-zinc-800 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 block w-full rounded-lg border border-zinc-200 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500']) }}>
    <option value="">{{ $defaultOption }}</option>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
    @endforeach
</select>
