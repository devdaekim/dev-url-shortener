<?php

namespace App\Http\Livewire;

use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Models\Word;
use Livewire\Component;

class ShortenedLink extends Component
{
    public $long_url = null;
    public $description = null;
    public $private = false;

    protected $rules = [
        'long_url' => 'required|url',
        'description' => 'sometimes|nullable|max:140',
        'private' => 'sometimes|boolean',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Update an existing link
     *
     * @param mixed $link
     * @param mixed $data
     * @return void
     */
    public function updateLink($link, $data)
    {
        $link->word->available = true;
        $link->word->save();

        $link->word_id = $data['word_id'];
        $link->description = $data['description'];
        $link->user_id = $this->private ? auth()->id() : null;
        $link->counts = 0;
        $link->save();
    }

    /**
     * Create a new shortened link
     *
     * @param mixed $data
     * @return void
     */
    public function createLink($data)
    {
        $link = new Link();
        $link->long_url = $data['long_url'];
        $link->word_id = $data['word_id'];
        $link->description = $data['description'];
        $link->user_id = $this->private ? auth()->id() : null;
        $link->save();

        // set the word unavailable
        $link->word->available = false;
        $link->word->save();
    }

    /**
     * Processing the Shorten URL form
     *
     * @return void
     */
    public function shorten()
    {
        $data = $this->validate();


        // 1. get the id of a random available word
        // FIXME what if where's no more available word???
        $data['word_id'] = (Word::available())->id;

        // 2. update or create
        // 2.1 check if the url exists
        $link = Link::where('long_url', $data['long_url'])->first();

        // 2.2 if exists, re-generate & set the previous word available
        // 2.3 not exists. create.
        $link ? $this->updateLink($link, $data) : $this->createLink($data);

        // 3. reset the form
        $this->reset(['long_url', 'description', 'private']);

        // 4. notification of saving
        $this->emitSelf('notify-saved');

        // 5. refresh the shortened links list
        $this->emitTo('links-list', 'search');
    }

    public function render()
    {
        return view('livewire.shortened-link')->layout('components.layouts.app');
    }
}
