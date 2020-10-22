<?php

namespace Tests\Feature;

use App\Http\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_see_login_form_component()
    {
        $this->get('/login')
            ->assertSeeLivewire('auth.login');
    }

    /** @test */
    public function email_field_is_required()
    {
        Livewire::test(Login::class)
            ->call('login')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_field_must_be_valid_email()
    {
        Livewire::test(Login::class)
            ->set('email', $this->faker()->email)
            ->call('login')
            ->assertHasNoErrors(['email' => 'email'])
            ->set('email', $this->faker()->word)
            ->call('login')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function password_field_is_required()
    {
        Livewire::test(Login::class)
            ->call('login')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function can_login_successfully()
    {
        $user = User::create([
            'name' => $this->faker()->name,
            'email' => $this->faker()->email,
            'password' => $this->faker()->password,
        ]);

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', $user->password)
            ->call('login')
            ->assertSuccessful();
    }

    /** @test */
    public function redirect_after_login()
    {
        $home_url = env('APP_URL');

        $this->actingAs(User::factory()->create());
        $this->get('/login')->assertSee("Redirecting to {$home_url}");
    }
}
