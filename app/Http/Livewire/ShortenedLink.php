<?php

namespace App\Http\Livewire;

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
     * Toogle the availablility of a specific Word
     * @param mixed $word_id
     *
     * @return void
     */
    private function toggleAvailable($word_id)
    {
        $word = Word::find($word_id);
        $word->available ? false : true;
        $word->save();
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
            // 3.2 if exists, update & set word available
            $this->toggleAvailable($link->word_id);
            $link->word_id = $data['word_id'];
            $link->description = $data['description'];
            if ($link->private) {
                $link->private = $data['private'];
                $link->private = auth()->id();
            }
            $link->counts = 0;
            $link->save();
        } else {
            // 3.3 not exists. create.
            Link::create([
                'long_url' => $data['long_url'],
                'word_id' => $data['word_id'],
                'description' => $data['description'],
                'private' => $data['private'],
                'counts' => 0,
            ]);
            // 4. set the word unavailable
            $this->toggleAvailable($data['word_id']);
        }

        // 5. emit(?) to the list of links to be re-freshed and the new one on top
        $this->emitSelf('notify-saved');
    }

    public function render()
    {
        return view('livewire.shortened-link')->layout('components.layouts.app');
    }
}
