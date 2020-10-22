<?php

namespace Tests\Feature;

use App\Http\Livewire\LinksList;
use App\Models\Link;
use App\Models\User;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LinksListTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private function populated_words_table()
    {
        return Word::create(['word' => $this->faker()->word]);
    }

    private function create_link($args)
    {
        return Link::create([
            'long_url' => $this->faker()->url,
            'word_id' => $args['word_id'],
            'user_id' => $args['user_id'] ?? null,
            'description' => $args['description'] ?? null,
        ]);
    }

    /** @test */
    public function cannot_see_links_list_component_without_login()
    {
        $this->get('/')
            ->assertDontSeeLivewire('links-list');
    }

    /** @test */
    public function can_see_links_list_component()
    {
        $this->actingAs(User::factory()->create());

        $this->get('/')
            ->assertSuccessful()
            ->assertSeeLivewire('links-list');
    }

    /** @test */
    public function links_list_private_checkbox_works_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $word1 = $this->populated_words_table();
        $private_link = $this->create_link([
            'word_id' => $word1->id,
            'user_id' => $user->id,
        ]);

        $word2 = $this->populated_words_table();
        $non_private_link = $this->create_link([
            'word_id' => $word2->id,
        ]);

        // when private is true, only links with user_it show
        // when private is false, all links show
        Livewire::test(LinksList::class)
            ->set('private', true)
            ->call('search')
            ->assertDontSee($non_private_link->long_url)
            ->assertSee($private_link->long_url)
            ->set('private', false)
            ->call('search')
            ->assertSee($non_private_link->long_url)
            ->assertSee($private_link->long_url);
    }

    /** @test */
    public function links_list_searches_long_url_correctly()
    {
        $this->actingAs(User::factory()->create());

        $word = $this->populated_words_table();
        $link = $this->create_link([
            'word_id' => $word->id,
        ]);

        $strings = explode('/', $link->long_url);
        $searchTerm = array_pop($strings);

        Livewire::test(LinksList::class)
            ->set('searchTerm', $searchTerm)
            ->call('search')
            ->assertSee($link->long_url);
    }

    /** @test */
    public function links_list_searches_description_correctly()
    {
        $this->actingAs(User::factory()->create());

        $word = $this->populated_words_table();
        $description = $this->faker()->sentence;

        $link = $this->create_link([
            'word_id' => $word->id,
            'description' => $description,
        ]);

        $searchTerm = explode(' ', $description);

        Livewire::test(LinksList::class)
            ->set('searchTerm', $searchTerm[array_rand($searchTerm)])
            ->call('search')
            ->assertSee($link->long_url);
    }
}
