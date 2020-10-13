<?php

namespace App\Http\Livewire;

use App\Models\Link;
use Livewire\Component;
use Livewire\WithPagination;

class LinksList extends Component
{
    use WithPagination;

    protected $listeners = ['searchWithTerm'];
    protected $shortened_links = null;
    public $search_term = '';
    public $private = false;
    private $items_per_page = 2;

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
        $this->search_term = '';
    }

    /**
     * Toogle searching private
     *
     * @return void
     */
    public function togglePrivate()
    {
        $this->private ? $this->searchPrivate() : $this->searchWithTerm();
    }

    /**
     * Retrieve private links
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function searchPrivate()
    {
        if ($this->private && $this->search_term === '') {
            $this->shortened_links = Link::with('word')->where('user_id', auth()->id())->orderBy('updated_at', 'DESC')->paginate($this->items_per_page);
        }
    }

    /**
     * Search by search term
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function searchWithTerm()
    {
        $search_term = "%{$this->search_term}%";
        $this->shortened_links = Link::with('word')->where(function ($query) {
            if (!$this->private) {
                $query->whereNull('user_id');
            }
            $query->orWhere('user_id', auth()->id());
        })
            ->where(function ($query) use ($search_term) {
                $query->where('long_url', 'like', $search_term);
                $query->orWhere('description', 'like', $search_term);
            })->orderBy('updated_at', 'DESC')->paginate($this->items_per_page);
    }

    /**
     * Resetting Pagination After Filtering Data
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->searchWithTerm();
        $this->searchPrivate();

        return view('livewire.links-list', [
            'shortened_links' => $this->shortened_links
        ]);
    }
}
