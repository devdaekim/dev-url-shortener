<?php

namespace Tests\Feature;

use App\Http\Livewire\ResetPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_see_reset_password_component()
    {
        $token = $this->faker()->sha256;
        $email = $this->faker()->email;
        $this->get("/reset-password/{$token}?email={$email}")
            ->assertSuccessful()
            ->assertSeeLivewire('reset-password');
    }

    /** @test */
    public function email_field_is_required()
    {
        Livewire::test(ResetPassword::class)
            ->call('resetPassword')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_address_must_be_valid()
    {
        Livewire::test(ResetPassword::class)
            ->set('email', $this->faker()->email)
            ->call('resetPassword')
            ->assertHasNoErrors(['email' => 'email'])
            ->set('email', $this->faker()->word)
            ->call('resetPassword')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function password_field_is_required()
    {
        Livewire::test(ResetPassword::class)
            ->call('resetPassword')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function password_confirmation_field_is_required()
    {
        Livewire::test(ResetPassword::class)
            ->call('resetPassword')
            ->assertHasErrors(['password_confirmation' => 'required']);
    }

    /** @test */
    public function password_field_must_be_confirmed()
    {
        $password = $this->faker()->password;

        Livewire::test(ResetPassword::class)
            ->set('password', $this->faker()->password)
            ->set('password_confirmation', $this->faker()->password)
            ->call('resetPassword')
            ->assertHasErrors(['password_confirmation' => 'same'])
            ->set('password', $password)
            ->set('password_confirmation', $password)
            ->call('resetPassword')
            ->assertHasNoErrors(['password_confirmation' => 'same']);
    }

    /** @test */
    public function password_can_be_reset()
    {
        $email = $this->faker()->email;
        $password = $this->faker()->password;

        Livewire::test(ResetPassword::class)
            ->set('email', $email)
            ->set('password', $password)
            ->set('password_confirmation', $password)
            ->call('resetPassword')
            ->assertSuccessful()
            ->assertDontSee('Reset Password');
    }
}
