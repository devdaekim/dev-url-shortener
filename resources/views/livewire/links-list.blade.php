<div class="w-full px-4 mb-6 lg:mb-0">
    <h2 class="text-2xl font-bold">Recent Links</h2>

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
