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
    //public $counts = 0;



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
     * Processing the Shorten URL form
     * @return mixed
     */
    public function shorten()
    {
        $data = $this->validate();

        // 1. get an array of ids of available words
        $words_available = Word::available();

        // 2. get randum id from the array & assign to word_id
        $data['word_id'] = array_rand($words_available, 1);

        // 3. update or create
        // 3.1 check if the url exists
        $link = Link::where('long_url', $data['long_url'])->first();

        if ($link) {
            // 3.2 if exists, re-generate & set the previous word available
            //$this->toggleAvailable($link->word_id);
            $link->word->available = true;
            $link->word->save();

            $link->word_id = $data['word_id'];
            $link->description = $data['description'];
            $this->user_id = $this->private ? auth()->id() : null;
            $link->counts = 0;
            $link->save();
        } else {
            // 3.3 not exists. create.
            $link = new Link();
            $link->long_url = $data['long_url'];
            $link->word_id = $data['word_id'];
            $link->description = $data['description'];
            $this->user_id = $this->private ? auth()->id() : null;
            $link->save();

            // 4. set the word unavailable
            $link->word->available = false;
            $link->word->save();
        }

        // 5. reset the form
        $this->long_url = null;
        $this->description = null;
        $this->private = false;

        // 6. emit(?) to the list of links to be re-freshed and the new one on top
        $this->emitSelf('notify-saved');
    }

    public function render()
    {
        return view('livewire.shortened-link')->layout('components.layouts.app');
    }
}
