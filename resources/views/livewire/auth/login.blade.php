@section('title', 'Login')
<div class="flex items-center justify-center h-full mx-auto">
  <div class="p-6 bg-white rounded shadow-xl md:w-1/3">
    <div>
      <img src="{{ asset('images/logo.svg') }}" alt="Shortened Dev Link" class="w-48">
      <h1 class="mt-8 text-3xl">Login</h1>
      <form wire:submit.prevent='login' id="loginForm" class="mt-8">
        <div class="h-6 mb-6">
             @if (session()->has('message'))
            <div class="flex items-center justify-center bg-white border-b-2 border-green-500">
                <svg
                    class="w-5 h-5 mr-2 text-green-500"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <h3 class="text-sm font-bold leading-tight text-gray-700">
                    {{ session('message') }}
                </h3>
            </div>
            @endif
        </div>
        <div>
          <x-input.text
            wire:model.lazy='email'
            type="email"
            placeholder="your@email.co.uk"
            :error="$errors->first('email')"
            tall="true"
          />
        </div>

        <div class="mt-6">
          <x-input.text
            wire:model.lazy='password'
            type="password"
            placeholder="Password"
            :error="$errors->first('password')"
            tall="true"
          />
        </div>

        <div class="mt-6">
          <x-input.button
            label="Login"
            type="submit"
            wire:target="login"
          />
        </div>
        <div class="mt-8 text-sm text-center text-blue-600">
          <p>
            <a class="underline hover:text-blue-800" href="{{ route('forgot-password') }}">Forgot password?</a>
          </p>
          <p>
          <a class="underline hover:text-blue-800" href="{{ route('register') }}">No account? Create an Account!</a>
          </p>
        </div>

      </form>
    </div>
  </div>
</div>
