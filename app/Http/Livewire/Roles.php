<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $roles;
    public $show = true, $add = false, $update = false;

    public $name;

    public function render()
    {
        return view('livewire.roles');
    }

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function showData(){
        $this->show = true;
        $this->add = false;
        $this->update = false;
    }

    public function addData(){
        $this->show = false;
        $this->add = true;
        $this->update = false;
    }

    public function updateData(){
        $this->show = false;
        $this->add = false;
        $this->update = true;
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name' => 'required',
        ]);

        $this->roles = Role::all();
    }

    public function saveData(){
        $this->validate([
            'name' => 'required',
        ]);

        Role::create([
            'name' => $this->name,
        ]);

        $this->name = "";
        session()->flash('success', 'Role Added Successfully!');
    }
}
