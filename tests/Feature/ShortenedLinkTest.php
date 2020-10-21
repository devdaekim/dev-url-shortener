<?php

namespace Tests\Feature;

use App\Http\Livewire\ShortenedLink;
use App\Models\Link;
use App\Models\User;
use App\Models\Word;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ShortenedLinkTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected $file = 'eff_short_wordlist_2_0.txt';

    private function pupulated_words_table()
    {
        return Word::create(['word' => $this->faker()->word]);
    }

    private function create_user()
    {
        return User::create([
            'name' => $this->faker()->name,
            'email' => $this->faker()->email,
            'password' => $this->faker()->password,
        ]);
    }

    /** @test */
    public function cannot_see_shortened_link_component_without_login()
    {
        $this->get('/')
            ->assertDontSeeLivewire('shortened-link');
    }

    /** @test */
    public function can_see_shortened_link_component()
    {
        $user = $this->create_user();
        $this->actingAs($user);

        $this->get('/')
            ->assertSuccessful()
            ->assertSeeLivewire('shortened-link');
    }

    /** @test */
    public function long_url_field_is_required()
    {
        Livewire::test(ShortenedLink::class)
            ->call('shorten')
            ->assertHasErrors(['long_url' => 'required']);
    }

    /** @test */
    public function long_url_field_is_not_valid_url()
    {
        Livewire::test(ShortenedLink::class)
            ->set('long_url', $this->faker()->word)
            ->call('shorten')
            ->assertHasErrors(['long_url' => 'url']);
    }

    /** @test */
    public function long_url_field_is_valid_url()
    {
        $this->pupulated_words_table();

        Livewire::test(ShortenedLink::class)
            ->set('long_url', $this->faker()->url)
            ->call('shorten')
            ->assertHasNoErrors(['long_url' => 'url']);
    }

    /** @test */
    public function description_field_has_maximum_characters()
    {
        $string = str_repeat('a', 250);

        Livewire::test(ShortenedLink::class)
            ->set('long_url', $this->faker()->url)
            ->set('description', $string)
            ->call('shorten')
            ->assertHasErrors(['description' => 'max']);
    }

    /** @test */
    public function url_can_be_saved_without_private_checked()
    {
        $long_url = $this->faker()->url;
        $word = $this->pupulated_words_table();

        Livewire::test(ShortenedLink::class)
            ->set('long_url',  $long_url)
            ->call('shorten');

        $this->assertTrue(
            Link::where('long_url', $long_url)
                ->where('word_id', $word->id)
                ->exists()
        );
    }

    /** @test */
    public function url_can_be_saved_with_private_checked()
    {
        $long_url = $this->faker()->url;
        $word = $this->pupulated_words_table();
        $user = $this->create_user();
        $this->actingAs($user);

        Livewire::test(ShortenedLink::class)
            ->set('long_url',  $long_url)
            ->set('private', true)
            ->call('shorten');

        $this->assertTrue(
            Link::where('long_url', $long_url)
                ->where('word_id', $word->id)
                ->where('user_id', $user->id)
                ->exists()
        );
    }

    /** @test */
    public function saved_message_is_shown_on_save()
    {
        $message = 'Saved!';

        Livewire::test(ShortenedLink::class)
            ->call('shorten')
            ->assertSee($message);
    }
}
