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
            <span class="mr-1 text-sm text-white">
              {{-- name comes here when logged in --}}
            </span>
            <div>
            {{-- login/logout/register link --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container flex-grow pt-6 pb-8 mx-auto sm:px-4">
   {{ $slot }}
  </div>
</div>
@livewireScripts
@stack('scripts')
</body>
</html>
