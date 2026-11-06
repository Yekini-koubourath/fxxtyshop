@props(['name', 'label', 'type' => 'text', 'value' => null])

<div>
    <label for="{{ $name }}" class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200']) }}
    >
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>