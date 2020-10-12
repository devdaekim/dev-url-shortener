<?php

namespace App\Http\Livewire;

use App\Models\Link;
use Livewire\Component;

class LinksList extends Component
{

    protected $listeners = ['loadList'];
    public $shortened_links = null;

    public function mount()
    {
        $this->loadList();
    }

    public function loadList()
    {
        $this->shortened_links = Link::with('word')
            ->where(function ($query) {
                $query->whereNull('user_id');
                $query->orWhere('user_id', auth()->id());
            })
            ->orderBy('updated_at', 'DESC')->get();
    }

    public function clickLink(Link $link)
    {
        $link->counts++;
        $link->timestamps = false; // to prevent updated_at updated
        $link->save();
        $this->loadList();
    }

    public function render()
    {
        return view('livewire.links-list');
    }
}
