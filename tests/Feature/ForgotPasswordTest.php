<?php

namespace Tests\Feature;

use App\Http\Livewire\ForgotPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_see_forgot_password_component()
    {
        $this->get('/forgot-password')
            ->assertSuccessful()
            ->assertSeeLivewire('forgot-password');
    }

    /** @test */
    public function email_field_is_required()
    {
        Livewire::test(ForgotPassword::class)
            ->call('sendLink')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_field_is_valid_email()
    {
        Livewire::test(ForgotPassword::class)
            ->set('email', $this->faker()->email)
            ->call('sendLink')
            ->assertHasNoErrors(['email' => 'email'])
            ->set('email', $this->faker()->word)
            ->call('sendLink')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function password_reset_link_sent_out_successfully()
    {
        $user = User::factory()->create();
        Livewire::test(ForgotPassword::class)
            ->set('email', $user->email)
            ->call('sendLink')
            ->assertSee(__('passwords.sent'));
    }
}
