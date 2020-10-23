<div class="relative">
  <div
    x-data="{open:false}"
    x-init="@this.on('word-unavailable-alert', ()=> {open = true;})"
    x-show.transition.out.duration.750ms="open"
    style="display:none;"
    class="absolute inset-x-0 z-10 w-3/4 p-4 mx-auto -mt-6 text-white bg-blue-700 rounded rounded-t-none shadow-xl md:w-2/5">
      <h3 class="text-xl font-bold">No more words available</h3>
       @if($oldest_private_link)
        <p>You can overwrite the oldest link of yours:</p>

        <ul class="my-3 text-xs border-t border-b">
          <li>
            {{$oldest_private_link->shortened_url}}
          </li>
          <li class="text-blue-300">
            {{$oldest_private_link->long_url}}
          </li>
          <li class="text-blue-300">
            {{$oldest_private_link->created_at->diffForHumans()}}
          </li>
        </ul>
        <div class="flex justify-end space-x-2">
          <button class="px-4 py-2 font-bold text-blue-700 bg-white rounded focus:bg-blue-100 hover:bg-blue-100 focus:outline-none" @click="open=false">Cancel</button>
          <button class="px-4 py-2 font-bold text-blue-700 bg-white rounded focus:bg-blue-100 hover:bg-blue-100 focus:outline-none" wire:click="overwrite_oldest_link( {{$oldest_private_link }})" @click="open=false">Proceed</button>
        </div>
        @else
          <p>Any more link can be added. Please contact the administrator</p>
          <div class="flex justify-end space-x-2">
          <button class="px-4 py-2 font-bold text-blue-700 bg-white rounded focus:bg-blue-100 hover:bg-blue-100 focus:outline-none" @click="open=false">Close</button>
        </div>
        @endif


  </div>
   {{-- form --}}
  <div class="mb-6">
    <form wire:submit.prevent='shorten' class="pl-4 pr-3">

      <div class="flex items-start justify-between">
        <div class="w-8/12 mb-4 md:flex md:justify-between">

            {{-- long url --}}
            <div class="w-full mb-4 md:mr-2 md:mb-0">
              <x-input.text
                wire:model.lazy='long_url'
                type="text"
                placeholder="Long URL (required)"
                :error="$errors->first('long_url')"
              />

            </div>

            {{-- description url --}}
            <div class="w-full md:ml-2">
              <x-input.text
                wire:model.debounce='description'
                type="text"
                placeholder="Short URL keyword (optional)"
                :error="$errors->first('description')"
              />
            </div>

            {{-- private checkbox --}}
            <div class="w-6">
              <x-input.checkbox
                  wire:model='private'
                  label='Private?'
              />
            </div>

        </div>
        <div class="w-48 mb-6 text-center">
          <x-input.button
              label="Shorten"
              type="submit"
              wire:target="shorten"
          />
            <p class="h-5 font-bold text-green-600">
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
