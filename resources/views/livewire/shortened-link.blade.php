<div>
   {{-- form --}}
    <div class="mb-6">
      <form wire:submit.prevent='shorten' class="pl-4 pr-3">

        <div class="flex items-start justify-between">
          <div class="w-8/12 mb-4 md:flex md:justify-between">

              {{-- long url --}}
              <div class="w-full mb-4 md:mr-2 md:mb-0">
                <input wire:model.debounce='long_url' class="form-input w-full px-3 py-2 text-sm leading-tight text-gray-700 shadow appearance-none focus:outline-none focus:shadow-outline @error('long_url') border-red-500 @enderror" id="long_url" type="text" placeholder="Long URL (required)" />
                <p class="h-5 mt-2 text-sm leading-tight text-red-500">@error('long_url'){{ $message }}@enderror</p>
              </div>

              {{-- description url --}}
              <div class="w-full md:ml-2">
                <input wire:model.debounce='description' class="form-input w-full px-3 py-2 text-sm leading-tight text-gray-700 shadow appearance-none focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" id="description" type="text" placeholder="Short URL keyword (optional)" />
                <p class="h-5 mt-2 text-sm leading-tight text-red-500">@error('description'){{ $message }}@enderror</p>
              </div>

              {{-- private checkbox --}}
              <div class="w-6">
                  <label class="inline-flex items-center mt-2 transition duration-150 ease-in-out md:ml-4">
                    <input wire:model='private' type="checkbox" class="w-5 h-5 text-blue-600 shadow form-checkbox">
                    <span class="ml-2 text-sm text-gray-700">Private?</span>
                  </label>
              </div>

            </div>
          <div class="mb-6 text-center">
              <button class="inline-flex items-center justify-center w-full px-10 py-2 text-sm text-white transition duration-150 ease-in-out bg-blue-600 rounded hover:bg-blue-800 focus:outline-none focus:shadow-outline focus:border-blue-800 focus:shadow-outline-blue active:bg-blue-800 disabled:opacity-50" type="submit">
              <svg wire:loading wire:target="shorten" class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                  </path>
                </svg>
                <span>Shorten</span>
              </button>
              <p class="h-5 font-bold">
                <span
                x-data="{open: false}"
                x-init="
                    @this.on('notify-saved', () => {
                    setTimeout(()=> {open = false}, 2500);
                    open = true;
                    })
                    "
                x-show.transition.out.duration.750ms="open"
                style="display:none;"
                >
                    Saved!
                </span>
                </p>
            </div>
        </div>
      </form>
    </div>

    @livewire('links-list')
</div>
