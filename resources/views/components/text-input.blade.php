@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-zinc-900 border-zinc-700 text-white placeholder-zinc-500 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm']) }}>
