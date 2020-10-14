<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $success = false;
    public $status = '';
    public $message = '';
    public $email = '';

    protected $rules = [
        'email' => 'required|email',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Send a password reset link email
     *
     * @return void
     */
    public function sendLink()
    {
        $data = $this->validate();
        $this->status = Password::sendResetLink(
            ['email' => $data['email']]
        );
        if ($this->status === Password::RESET_LINK_SENT) {
            $this->message = __($this->status);
            $this->success = true;
            $this->reset('email');
        } else {
            $this->message = __($this->status);
            $this->success = false;
        }
    }

    public function render()
    {
        return view('livewire.forgot-password')->layout('components.layouts.auth');
    }
}
