@props(['label' => ''])
<label class="inline-flex items-center mt-2 transition duration-150 ease-in-out md:ml-4">
  <input
    {{-- wire:model='private' --}}
    {{ $attributes->whereDoesntStartWith('label') }}
    type="checkbox"
    class="w-5 h-5 text-blue-600 shadow form-checkbox">
  <span class="ml-2 text-sm text-gray-600">{{ $label }}</span>
</label>
