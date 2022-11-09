<?php

namespace App\Http\Livewire\Account;

use App\Models\User;
use Livewire\Component;

class AccountShow extends Component
{
    public $users;

    public function render()
    {
        return view('livewire.account.account-show');
    }

    public function mount(){
        $this->users = User::with('salary')->where('status', 'active')->get();
    }
}