<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email, $password, $msg, $remember, $users;

    public function render()
    {
        return view('livewire.login');
    }

    public function updated($field){
        $this->validateOnly($field, [
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);
    }

    public function submit()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if(Auth::attempt(array('email' => $this->email, 'password' => $this->password), $this->remember)){
            return redirect()->route('admin');
        }else{
            session()->flash('failed', 'The provided credentials are incorrect.');
        }
    }
}