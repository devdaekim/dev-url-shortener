<div class="w-full px-4 mb-6 lg:mb-0">
    <h2 class="text-2xl font-bold">Recent Links</h2>

    <div class="flex justify-end space-x-4">
        {{-- private checkbox --}}
        <div x-data>
             <x-input.checkbox
                   wire:model='private'
                   label='Private'
                />
        </div>

        {{-- Search input --}}
        <div
            x-data="{open: @entangle('searchTerm')}"
            class="relative flex flex-wrap items-stretch w-full mb-4 sm:w-1/3">

            <x-input.text
                  wire:model.debounce='searchTerm'
                  type="search"
                  placeholder="search"
                  search="true"
                />
        </div>
    </div>

    <div class="mt-4 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left">
                        <span class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Shortened</span>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <span class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Long</span>
                    </th>
                    <th class="px-6 py-3 text-left">
                        <span class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Description</span>
                    </th>
                    <th class="px-6 py-3 text-left">
                       <span class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Updated</span>
                    </th>
                    <th class="px-6 py-3 text-right">
                        <span class="text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50">Visits</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                 @forelse($shortened_links as $link)
                <tr>
                    <td class="w-4/12 px-6 py-4 @if($link->private) border-l-blue-300 border-l-4 @endif">
                        <a
                            wire:click.stop="clickLink()"
                            href="{{ $link->shortened_url }}"
                            class="text-blue-600 underline"
                            target="_blank"
                            rel="nofollow noopener"
                        >{{ $link->shortened_url }}</a>
                    </td>
                    <td class="w-4/12 px-6 py-4">
                        {{ $link->long_url }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $link->description }}
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap">
                       {{ $link->updated_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium leading-5 text-right">
                         {{ $link->counts }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td  class="w-4/12 px-6 py-4 whitespace-no-wrap" colspan="5">No records found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $shortened_links->links() }}
    </div>
</div>
