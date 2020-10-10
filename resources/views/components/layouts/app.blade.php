<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.min.js" defer></script>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700&display=swap" rel="stylesheet">

    {{-- Styles --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles

    @stack('styles')
</head>
<body>
<div class="flex flex-col w-full min-h-screen font-sans bg-gray-100">

  {{-- header --}}
  <div class="bg-white">
    <div class="container px-4 mx-auto">
      <div class="flex items-center py-4 md:justify-between">
        {{-- logo --}}
        <div class="w-1/2 text-2xl font-medium text-center text-white md:w-auto">
          <img src="{{ asset('images/hn-bit-logo.png') }}" alt="Hn-Bit" class="w-1/4">
        </div>
        <div class="w-1/4 text-right md:w-auto md:flex">
          <div>
            <img class="inline-block w-8 h-8 rounded-full" src="https://avatars0.githubusercontent.com/u/4323180?s=460&v=4" alt="">
          </div>
          <div class="hidden ml-2 md:block md:flex md:items-center">
            <span class="mr-1 text-sm text-white">Adam Wathan</span>
            <div>
              <svg class="block w-4 h-4 text-white opacity-50 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M4.516 7.548c.436-.446 1.043-.481 1.576 0L10 11.295l3.908-3.747c.533-.481 1.141-.446 1.574 0 .436.445.408 1.197 0 1.615-.406.418-4.695 4.502-4.695 4.502a1.095 1.095 0 0 1-1.576 0S4.924 9.581 4.516 9.163c-.409-.418-.436-1.17 0-1.615z"/></svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container flex-grow pt-6 pb-8 mx-auto sm:px-4">
    {{-- form --}}
    <div class="mb-6">
      <form wire:submit.prevent='' class="px-6">

        <div class="flex items-center justify-between">
          <div class="w-8/12 mb-4 md:flex md:justify-between">

              {{-- long url --}}
              <div class="w-full mb-4 md:mr-2 md:mb-0">
                <input wire:model.lazy='long_url' class="form-input w-full px-3 py-2 text-sm leading-tight text-gray-700 shadow appearance-none focus:outline-none focus:shadow-outline @error('long_url') border-red-500 @enderror" id="long_url" type="text" placeholder="Long URL (required)" />
                <p class="text-red-500">@error('long_url'){{ $message }}@enderror</p>
              </div>

              {{-- short url --}}
              <div class="w-full md:ml-2">
                <input wire:model.lazy='description' class="form-input w-full px-3 py-2 text-sm leading-tight text-gray-700 shadow appearance-none focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" id="description" type="text" placeholder="Short URL keyword (optional)" />
                <p class="text-red-500">@error('description'){{ $message }}@enderror</p>
              </div>

              {{-- private checkbox --}}
              <label class="inline-flex items-center transition duration-150 ease-in-out md:ml-4">
                <input type="checkbox" class="w-5 h-5 text-blue-600 shadow form-checkbox">
                <span class="ml-2 text-gray-700">Private?</span>
                <div class="absolute top-auto right-auto z-20 hidden p-8 mt-auto text-white bg-blue-800 rounded"><p>Are you sure you want this private?</p> <div class="flex items-center"><button class="px-4 py-2 mr-4">Cancel</button> <button class="px-4 py-2 text-sm font-bold text-white bg-red-500 rounded">Proceed</button></div></div>
              </label>
            </div>
          <div class="mb-6 text-center">
              <button class="inline-flex items-center justify-center w-full px-10 py-2 text-sm text-white transition duration-150 ease-in-out bg-blue-600 rounded hover:bg-blue-800 focus:outline-none focus:shadow-outline focus:border-blue-800 focus:shadow-outline-blue active:bg-blue-800 disabled:opacity-50" type="submit"><svg wire:loading wire:target="" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                <span>Shorten</span>
              </button>
            </div>
        </div>
      </form>
    </div>

    <div class="px-2">
      <div class="w-full px-4 mb-6 lg:mb-0">
        <div class="overflow-hidden text-gray-700 bg-white border-t border-b shadow sm:rounded sm:border">

          <div class="relative px-6 py-4 border-b">
            <ul>
              <li class="absolute top-0 right-0 mt-4 mr-4">
                3 visits
              </li>
              <li><a href="#" class="underline">http://hn-bit.com/example</a></li>
              <li>1 week ago</li>
              <li>http://example.com/blog/example/1</li>
            </ul>
          </div>

          <div class="relative px-6 py-4 border-b">
            <ul>
              <li class="absolute top-0 right-0 mt-4 mr-4">
                3 visits
              </li>
              <li><a href="#" class="underline">http://hn-bit.com/example</a></li>
              <li>3 week ago</li>
              <li>http://example.com/blog/example/1</li>
            </ul>
          </div>

          <div class="relative px-6 py-4 border-b">
            <ul>
              <li class="absolute top-0 right-0 mt-4 mr-4">
                3 visits
              </li>
              <li><a href="#" class="underline">http://hn-bit.com/example</a></li>
              <li>8 months ago</li>
              <li>http://example.com/blog/example/1</li>
            </ul>
          </div>

          <div class="relative px-6 py-4 border-b">
            <ul>
              <li class="absolute top-0 right-0 mt-4 mr-4">
                3 visits
              </li>
              <li><a href="#" class="underline">http://hn-bit.com/example</a></li>
              <li>1 year ago</li>
              <li>http://example.com/blog/example/1</li>
            </ul>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>
@livewireScripts
@stack('scripts')
</body>
</html>
