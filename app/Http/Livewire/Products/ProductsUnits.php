<?php

namespace App\Http\Livewire\Products;

use App\Models\Units;
use Livewire\Component;

class ProductsUnits extends Component
{
    public $units, $name, $updateUnit, $updateUnit_id = 0, $togglePop = false;

    public function render()
    {
        return view('livewire.products.products-units');
    }

    public function mount(){
        $this->units = Units::all();
    }

    public function updated($field){
        

        $this->validateOnly($field, [
            'name'=>'required|string|unique:units',
        ]);
    }

    public function saveData(){
        $this->validate([
            'name' => 'required|string|unique:units'
        ]);
        Units::create([
            'name' => $this->name
        ]);
        session()->flash('success', 'Catagory succesfully added!');
        $this->units = Units::all();
        $this->name = "";
        $this->mount();
    }

    public function toggleUpdate($unit_id){
        $this->togglePop = true;
        $this->updateUnit_id = $unit_id;
        $unit = Units::find($unit_id);
        $this->updateUnit = $unit->name;
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }

    public function updateUnit($unit_id){
        $this->validate([
            'updateUnit' => 'required'
        ]);
        
        $unit = Units::find($unit_id);
        $unit->name = $this->updateUnit;
        $unit->save();

        session()->flash('success', 'Unit succesfully Updated!');
        $this->mount();
        $this->togglePop = false;
    }
}