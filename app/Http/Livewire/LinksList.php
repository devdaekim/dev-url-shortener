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
    public $searchTerm = '';
    public $private = false;
    protected $queryString = ['searchTerm',];
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

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingPrivate()
    {
        $this->resetPage();
    }

    /**
     * Get initial data & Search
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function search()
    {
        $searchTerm = "%{$this->searchTerm}%";

        $this->shortened_links = Link::with('word')->where(function ($query) {
            if ($this->private === true) {
                $query->where('user_id', auth()->id());
            }
        })
            ->where(function ($query) use ($searchTerm) {
                if ($this->searchTerm !== '') {
                    $query->where('long_url', 'like', $searchTerm);
                    $query->orWhere('description', 'like', $searchTerm);
                }
            })
            ->orderBy('updated_at', 'DESC')
            ->paginate($this->items_per_page);
    }

    public function render()
    {
        $this->search();
        return view('livewire.links-list', [
            'shortened_links' => $this->shortened_links
        ]);
    }
}
