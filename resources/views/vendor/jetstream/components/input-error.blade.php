@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-xs text-red-600 mb-0']) }}>
        {{ $message }}
    </p>
@enderror
