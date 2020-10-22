<?php

namespace Tests\Feature;

use App\Http\Livewire\Auth\Register;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function can_see_register_form_component()
    {
        $this->get('/register')
            ->assertSeeLivewire('auth.register');
    }

    /** @test */
    public function name_field_is_required()
    {
        Livewire::test(Register::class)
            ->call('register')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function email_field_is_required()
    {
        Livewire::test(Register::class)
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_field_must_be_valid_email()
    {
        Livewire::test(Register::class)
            ->set('email', $this->faker()->email)
            ->call('register')
            ->assertHasNoErrors(['email' => 'email'])
            ->set('email', $this->faker()->word)
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function password_field_is_required()
    {
        Livewire::test(Register::class)
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    /** @test */
    public function password_confirm_field_is_required()
    {
        Livewire::test(Register::class)
            ->call('register')
            ->assertHasErrors(['password_confirm' => 'required']);
    }

    /** @test */
    public function password_field_must_be_confirmed()
    {
        $password = $this->faker()->password;

        Livewire::test(Register::class)
            ->set('password', $this->faker()->password)
            ->set('password_confirm', $this->faker()->password)
            ->call('register')
            ->assertHasErrors(['password_confirm' => 'same'])
            ->set('password', $password)
            ->set('password_confirm', $password)
            ->call('register')
            ->assertHasNoErrors(['password_confirm' => 'same']);
    }
}
