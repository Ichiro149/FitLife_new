{{-- Šis komponents attēlo "input label" atkārtoti lietojamu saskarnes bloku. --}}

@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-zinc-300']) }}>
    {{ $value ?? $slot }}
</label>
