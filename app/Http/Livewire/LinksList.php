<?php

namespace App\Http\Livewire;

use App\Models\Link;
use Livewire\Component;

class LinksList extends Component
{
    public $shortened_links = null;

    public function mount()
    {
        $this->shortened_links = Link::with('word')->latest()->get();
    }

    public function render()
    {
        return view('livewire.links-list');
    }
}
