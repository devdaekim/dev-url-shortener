@section('title', 'Registration')
<div class="flex items-center justify-center h-full mx-auto">
  <div class="p-6 bg-white rounded shadow-xl md:w-1/3">
    <div>
      <img src="{{ asset('images/hn-bit-logo.png') }}" alt="HN-Bit Shortened Dev Link" class="w-48">
      <h1 class="mt-8 text-3xl">Registration</h1>
      <form wire:submit.prevent='register' class="mt-8">
        <div>
          <x-input.text
            wire:model.lazy='name'
            type="text"
            placeholder="Your name"
            :error="$errors->first('name')"
            tall="true"
          />
        </div>

        <div class="mt-6">
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
        <x-input.text
            wire:model.lazy='password_confirm'
            type="password"
            placeholder="Confirm password"
            :error="$errors->first('password_confirm')"
            tall="true"
          />
        </div>

        <div class="mt-6">
          <x-input.button
              label="Register Account"
              type="submit"
              wire:target="register"
          />
        </div>
        <div class="mt-8 text-sm text-center text-blue-600">
          <a class="underline hover:text-blue-800" href="{{ route('login') }}">Already have an account? Login!</a>
        </div>

      </form>
    </div>
  </div>
</div>
