@section('title', 'Forgot Password')
<div class="flex items-center justify-center h-full mx-auto">
  <div class="p-6 bg-white rounded shadow-xl md:w-1/3">
    <div>
      <img src="{{ asset('images/logo.svg') }}" alt="Shortened Dev Link" class="w-48">
      <h1 class="mt-8 text-3xl">Forgot password?</h1>
      <form wire:submit.prevent='sendLink' class="mt-8">
        <div class="h-6 mb-6">
            @if ($message)
            <div class="bg-white border-b-2 flex items-center justify-center
                {{  $status === 'passwords.sent' ? 'border-green-500' : 'border-red-500' }}
            ">
                <svg
                    class="{{  $status === 'passwords.sent' ? 'text-green-500' : 'text-red-500' }} h-5 w-5 mr-2"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <h3 class="text-sm font-bold leading-tight text-gray-700">
                    {{ $message }}
                </h3>
            </div>
            @endif
        </div>

        <div class="{{ $success ? 'hidden' : '' }}">
          <x-input.text
            wire:model.lazy='email'
            type="email"
            placeholder="your@email.co.uk"
            :error="$errors->first('email')"
            tall="true"
          />
        </div>

        <div class="mt-6 {{ $success ? 'hidden' : '' }}">
          <x-input.button
            label="Send reset link"
            type="submit"
            wire:target="sendLink"
          />
        </div>

        <div class="mt-8 text-sm text-center text-blue-600">
        </div>

      </form>
    </div>
  </div>
</div>
