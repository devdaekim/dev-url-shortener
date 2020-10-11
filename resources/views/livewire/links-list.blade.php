<div class="w-full px-4 mb-6 lg:mb-0">
    <h2 class="text-2xl font-bold">Recent Links</h2>

    <div wire:init='loadList' class="overflow-hidden text-gray-700 bg-white border-t border-b shadow sm:rounded sm:border">
        @foreach($shortened_links as $link)
        <div class="relative px-6 py-4 border-b
        @if($link->private) border-l-blue-300 border-l-4 @endif
        ">
        <ul>
            <li class="absolute top-0 right-0 mt-4 mr-4">
            {{ $link->counts }} visits
            </li>
            <li><a href="{{ $link->shortened_url }}" class="text-blue-600 underline">{{ $link->shortened_url }}</a></li>
            <li>{{ $link->updated_at->diffForHumans() }}</li>
            <li>{{ $link->long_url }}</li>
        </ul>
        </div>
        @endforeach

    </div>
</div>
