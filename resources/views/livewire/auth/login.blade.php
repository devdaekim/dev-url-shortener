@section('title', 'Login')
<div class="flex items-center justify-center h-full mx-auto">
  <div class="p-6 bg-white rounded shadow-xl md:w-1/3">
    <div>
      <img src="{{ asset('images/hn-bit-logo.png') }}" alt="HN-Bit Shortened Dev Link" class="w-48">
      <h1 class="mt-8 text-3xl">Login</h1>
      <form wire:submit.prevent='login' id="loginForm" class="mt-8">

        <div>
          <input wire:model.lazy='email' id="email" type="email" name="email" class="form-input w-full px-3 py-3 text-sm leading-tight text-gray-700 shadow appearance-none focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" placeholder="your@email.co.uk">

            <p class="h-5 pt-2 text-sm leading-tight text-red-500">@error('email'){{ $message }}@enderror</p>
        </div>

        <div class="mt-6">
          <input wire:model.lazy='password' id="password" type="password" name="password" class="form-input w-full px-3 py-3 text-sm leading-tight text-gray-700 shadow appearance-none focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" placeholder="password">

            <p class="h-5 pt-2 text-sm leading-tight text-red-500">@error('password'){{ $message }}@enderror</p>
        </div>

        <div class="mt-6">
          <button class="inline-flex items-center justify-center w-full px-4 py-2 font-bold text-white transition duration-150 ease-in-out bg-blue-600 rounded hover:bg-blue-800 focus:outline-none focus:shadow-outline focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 disabled:opacity-50" type="submit"><svg wire:loading wire:target="login" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                <span>Login</span>
              </button>
        </div>
        <div class="mt-8 text-sm text-center text-blue-600">
          <a class="underline hover:text-blue-800" href="{{ route('register') }}">No account? Create an Account!</a>
        </div>

      </form>
    </div>
  </div>
</div>
