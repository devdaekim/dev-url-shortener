<?php

namespace App\Http\Livewire;

use App\Models\Link;
use Livewire\Component;

class LinksList extends Component
{

    protected $listeners = ['loadList'];
    public $shortened_links = null;
    public $searchTerm = '';
    public $private = false;

    /**
     * Load data when mounting the component
     * @return void
     */
    public function mount()
    {
        $this->loadList();
    }

    /**
     * Retrieve all non-private & private shortened links
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function loadList()
    {
        $this->shortened_links = Link::with('word')
            ->where(function ($query) {
                $query->whereNull('user_id');
                $query->orWhere('user_id', auth()->id());
            })
            ->orderBy('updated_at', 'DESC')->get();
    }

    /**
     * Increment click counts
     *
     * @param Link $link
     *
     * @return void
     */
    public function clickLink(Link $link)
    {
        $link->counts++;
        $link->timestamps = false; // to prevent updated_at updated
        $link->save();
        $this->loadList();
    }

    /**
     * Empty the search input
     *
     * @return void
     */
    public function clearSearch()
    {
        $this->searchTerm = '';
    }

    /**
     * Toogle searching private
     *
     * @return void
     */
    public function togglePrivate()
    {
        $this->private = $this->private ? false : true;
    }

    /**
     * Retrieve private links
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function searchPrivate()
    {
        if ($this->private && $this->searchTerm === '') {
            $this->shortened_links = Link::with('word')->where('user_id', auth()->id())->orderBy('updated_at', 'DESC')->get();
        }
    }

    /**
     * Search by search term
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function searchWithTerm()
    {
        $searchTerm = "%{$this->searchTerm}%";
        $this->shortened_links = Link::with('word')->where(function ($query) {
            if (!$this->private) {
                $query->whereNull('user_id');
            }
            $query->orWhere('user_id', auth()->id());
        })
            ->where(function ($query) use ($searchTerm) {
                $query->where('long_url', 'like', $searchTerm);
                $query->orWhere('description', 'like', $searchTerm);
            })->orderBy('updated_at', 'DESC')->get();
    }

    public function render()
    {
        $this->searchWithTerm();
        $this->searchPrivate();

        return view('livewire.links-list');
    }
}
