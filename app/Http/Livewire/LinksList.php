<?php

namespace App\Http\Livewire;

use App\Models\Link;
use Livewire\Component;
use Livewire\WithPagination;

class LinksList extends Component
{
    use WithPagination;

    protected $listeners = ['search' => '$refresh'];
    protected $shortened_links = null;
    public $search_term = '';
    public $private = false;
    private $items_per_page = 10;

    /**
     * Deal with link click
     *
     * @return void
     */
    public function clickLink()
    {
        $this->search();
    }

    /**
     * Empty the search input
     *
     * @return void
     */
    public function clearSearch()
    {
        $this->search_term = '';
    }

    /**
     * Get initial data & Search
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function search()
    {
        $search_term = "%{$this->search_term}%";
        $this->shortened_links = Link::with('word')->where(function ($query) {
            if (!$this->private) {
                $query->whereNull('user_id');
            }
            $query->orWhere('user_id', auth()->id());
        })
            ->where(function ($query) use ($search_term) {
                if ($this->search_term !== '') {
                    $query->where('long_url', 'like', $search_term);
                    $query->orWhere('description', 'like', $search_term);
                }
            })->orderBy('updated_at', 'DESC')->paginate($this->items_per_page);

        $this->page = 1; // always set the page 1. this will remove page number query from url. but search/filter does not work without this,.
    }

    public function render()
    {
        $this->search();
        return view('livewire.links-list', [
            'shortened_links' => $this->shortened_links
        ]);
    }
}
