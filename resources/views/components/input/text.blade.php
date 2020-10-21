@props(['error' => false, 'search' => false, 'tall' => false])
<input
  {{ $attributes }}
  class="form-input w-full px-3 text-sm leading-tight text-gray-700 shadow appearance-none focus:outline-none focus:shadow-outline
  {{ $error ? 'border-red-500' : ''}}
  {{ $search ? '' : '' }}
  {{ $tall ? 'py-3' : 'py-2' }}
  "
   />
  <p class="h-5 mt-2 text-sm leading-tight text-red-500">@if($error){{ $error }}@endif</p>
