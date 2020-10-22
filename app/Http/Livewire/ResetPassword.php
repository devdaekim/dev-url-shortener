<?php

namespace App\Http\Livewire;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public $success = false;
    public $status;
    public $message;
    public $email;
    public $password;
    public $password_confirmation;
    public $token;

    public function mount()
    {
        $this->fill(['token' => request()->route('token')]);
    }
    protected $rules = [
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|max:20',
        'password_confirmation' => 'required|min:8|max:20|same:password'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Reset user's password and redirect to login page after successful reset
     *
     * @return mixed
     */
    public function resetPassword()
    {

        $credentials = $this->validate();

        $this->status = Password::reset($credentials, function ($user, $password) use ($credentials) {

            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();

            $user->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });

        if ($this->status == Password::PASSWORD_RESET) {
            session()->flash('message', __($this->status));
            return redirect()->route('login');
        } else {
            $this->message = __($this->status);
            $this->success = false;
        }
    }

    public function render()
    {
        return view('livewire.reset-password')->layout('components.layouts.auth');
    }
}
