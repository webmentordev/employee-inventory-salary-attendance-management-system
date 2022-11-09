<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use App\Models\Designation;

class Designations extends Component
{
    public $designations;
    public $show = true, $add = false, $update = false;

    public $name;
   
    public function render()
    {
        return view('livewire.management.designations');
    }

    public function mount(){
        $this->designations = Designation::all();
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

        $this->designations = Designation::all();
    }

    public function saveData(){
        $this->validate([
            'name' => 'required',
        ]);

        Designation::create([
            'name' => $this->name,
        ]);

        $this->name = "";
        session()->flash('success', 'Designation Added Successfully!');
    }
    
}