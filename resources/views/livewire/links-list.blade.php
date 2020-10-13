<div class="w-full px-4 mb-6 lg:mb-0">
    <h2 class="text-2xl font-bold">Recent Links</h2>

    <div class="flex justify-end space-x-4">
        {{-- private checkbox --}}
        <div x-data>
            <label class="inline-flex items-center mt-2 transition duration-150 ease-in-out md:ml-4">
            <input
                @change="$wire.togglePrivate()"
                type="checkbox"
                class="w-5 h-5 text-blue-600 shadow form-checkbox">
            <span class="ml-2 text-sm text-gray-600">Private</span>
            </label>
        </div>

        {{-- Search input --}}
        <div
            x-data="{open: @entangle('searchTerm')}"
            class="relative flex flex-wrap items-stretch w-full mb-4 sm:w-1/3">
            <input
                wire:model.debounce='searchTerm'
                type="text"
                placeholder="search"
                class="relative w-full px-3 py-2 pr-10 text-sm leading-tight text-gray-700 shadow appearance-none form-input focus:outline-none focus:shadow-outline"/>
            <span
                x-show="open" @click="$wire.clearSearch()"
                class="absolute right-0 z-10 items-center justify-center w-8 h-full py-2 pr-3 text-base font-normal leading-snug text-center text-gray-500 bg-transparent rounded cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </svg>
            </span>
        </div>
    </div>


    <div wire:init='loadList' class="overflow-hidden text-gray-700 bg-white border-t border-b shadow sm:rounded sm:border">
        @forelse($shortened_links as $link)
            <div class="relative px-6 py-4 border-b
                @if($link->private) border-l-blue-300 border-l-4 @endif
            ">
            <ul>
                <li class="absolute top-0 right-0 mt-4 mr-4">
                    {{ $link->counts }} {{ Str::plural('visit', $link->counts) }}
                </li>
                <li>
                    <a
                        wire:click.stop="clickLink({{ $link->id }})"
                        href="{{ $link->shortened_url }}"
                        class="text-blue-600 underline"
                        target="_blank"
                        rel="nofollow noopener"
                    >{{ $link->shortened_url }}</a>

                </li>
                <li>{{ $link->updated_at->diffForHumans() }}</li>
                <li>{{ $link->long_url }}</li>
                <li class="text-gray-500">
                    {{ $link->description }}
                </li>
            </ul>
            </div>
        @empty
            <div class="relative px-6 py-4 border-b border-l-4 border-l-red-500">
                <p>No shortened links exist.</p>
            </div>
        @endforelse
    </div>

</div>
