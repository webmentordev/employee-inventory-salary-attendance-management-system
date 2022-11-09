<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\UserSalary;

class Salary extends Component
{
    public $show = true;
    public $update = false;
    public $create = true;

    public $users;

    public function render()
    {
        return view('livewire.salary.salary');
    }

    public function mount(){
        $this->users = UserSalary::all();
    }

    // ===========================================================
    public function addUser(){
        $this->create = true;
        $this->show = false;
        $this->update = false;
    }

    public function showUsers(){
        $this->create = false;
        $this->show = true;
        $this->update = false;
    }

    public function updateUser(){
        $this->create = false;
        $this->show = false;
        $this->update = true;
    }
}
