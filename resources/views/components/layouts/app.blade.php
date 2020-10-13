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
<div class="flex flex-col w-full min-h-screen font-sans text-sm tracking-tight bg-gray-100">

  {{-- header --}}
  <div class="bg-white">
    <div class="container pr-3 mx-auto">
      <div class="flex items-center py-4 md:justify-between">
        {{-- logo --}}
        <div class="w-1/2">
          <img src="{{ asset('images/hn-bit-logo.png') }}" alt="HN-Bit Shortened Dev Links" class="w-56">
          <h1 class="hidden">HN-Bit Shortened Dev Links</h1>
        </div>
        <div class="justify-end w-1/2 space-x-2 text-right sm:flex md:items-center">
          <div class="text-sm tracking-tighter">
          @auth
            Hi, {{ explode(' ', auth()->user()->name)[0] }}
          @endauth
          </div>
          <a href="{{ route('logout') }}" title="Logout">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-600 focus:outline-none focus:text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="container pt-6 pb-8 mx-auto">
   {{ $slot }}
  </div>
</div>
@livewireScripts
@stack('scripts')
</body>
</html>
