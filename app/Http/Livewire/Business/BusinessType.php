<?php

namespace App\Http\Livewire\Business;

use Livewire\Component;
use App\Models\BusinessTypes;

class BusinessType extends Component
{
    public $businessTypes, $name;
    public $updateBusinessType, $updateBusinessType_id = 0, $togglePop = false;

    public function render()
    {
        return view('livewire.business.business-type');
    }

    public function mount(){
        $this->businessTypes = BusinessTypes::all();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name'=>'required|string|unique:business_types',
        ]);
    }

    public function saveData(){
        $this->validate([
            'name' => 'required|string|unique:business_types'
        ]);

        BusinessTypes::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Business Type succesfully added!');
        $this->catagories = BusinessTypes::all();

        $this->name = "";
        $this->mount();
    }

    public function toggleUpdate($type_id){
        $this->togglePop = true;
        $this->updateBusinessType_id = $type_id;
        $type = BusinessTypes::find($type_id);
        $this->updateBusinessType = $type->name;
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }

    public function updateBusinessType($type_id){
        $this->validate([
            'updateBusinessType' => 'required'
        ]);
        $type = BusinessTypes::find($type_id);
        $type->name = $this->updateBusinessType;
        $type->save();

        session()->flash('success', 'Business Type succesfully Updated!');
        $this->mount();
        $this->togglePop = false;
    }
}
