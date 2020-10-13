<div>
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
