<?php

namespace Tests\Feature;

use App\Http\Livewire\ShortenedLink;
use App\Models\Link;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShortenedLinkTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     *
     */

    /** @test */
    public function can_see_shortened_link_component()
    {
        $this->get('/')
            ->assertSuccessful()
            ->assertSeeLivewire('shortened-link');
    }

    /** @test */
    public function url_can_be_saved()
    {
        $long_url = $this->faker()->url;

        Livewire::test(ShortenedLink::class)
            ->set('long_url',  $long_url)
            ->call('shorten');

        $this->assertTrue(Link::where('long_url', $long_url)->exists());
    }

    /** @test */
    public function message_is_shown_on_save()
    {
        $message = 'Saved!';

        Livewire::test(ShortenedLink::class)
            ->assertDontSee($message)
            ->call('shorten')
            ->assertEmitted('notify-saved');
    }
}
