@section('title', 'Reset Password')
<div class="flex items-center justify-center h-full mx-auto">
  <div class="p-6 bg-white rounded shadow-xl md:w-1/3">
    <div>
      <img src="{{ asset('images/logo.svg') }}" alt="Shortened Dev Link" class="w-48">
      <h1 class="mt-8 text-3xl">Reset Password</h1>
      <form wire:submit.prevent='resetPassword' class="mt-8">
         <div class="h-6 mb-6">
            @if ($message)
            <div class="bg-white border-b-2 flex items-center justify-center
                {{  $success  ? 'border-green-500' : 'border-red-500' }}
            ">
                <svg
                    class="{{  $status ? 'text-green-500' : 'text-red-500' }} h-5 w-5 mr-2"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <h3 class="text-sm font-bold leading-tight text-gray-700">
                    {{ $message }}
                </h3>
            </div>
            @endif
        </div>
        <input type="hidden" wire:model="token">
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
        <x-input.text
            wire:model.lazy='password_confirmation'
            type="password"
            placeholder="Confirm password"
            :error="$errors->first('password_confirmation')"
            tall="true"
          />
        </div>

        <div class="mt-6">
          <x-input.button
            wire:target="resetPassword"
            label="Reset password"
            type="submit"
          />
        </div>
        <div class="mt-8 text-sm text-center text-blue-600">
           <a class="underline hover:text-blue-800" href="{{ route('forgot-password') }}">Send me another link</a>
        </div>

      </form>
    </div>
  </div>
</div>
