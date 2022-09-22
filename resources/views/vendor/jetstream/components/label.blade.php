@props(['value', 'help'])

<label {{ $attributes->merge(['class' => 'flex font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}

    @if (isset($help))
        <small class="ml-auto">{{ $help }}</small>
    @endif
</label>
