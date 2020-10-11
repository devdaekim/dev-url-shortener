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
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sign-out-alt" class="w-5 h-5 text-red-500 hover:text-red-600 focus:outline-none focus:text-red-600" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"></path></svg>
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
