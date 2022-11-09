<?php

namespace App\Http\Livewire\Products;

use App\Models\Catagory;
use Livewire\Component;

class ProductsCatagory extends Component
{
    public $catagories, $name, $updateCatagory, $updateCatagory_id = 0, $togglePop = false;

    public function render()
    {
        return view('livewire.products.products-catagory');
    }

    public function mount(){
        $this->catagories = Catagory::all();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name'=>'required|string|unique:catagories',
        ]);
    }

    public function saveData(){
        $this->validate([
            'name' => 'required|string|unique:catagories'
        ]);
        Catagory::create([
            'name' => $this->name
        ]);
        session()->flash('success', 'Catagory succesfully added!');
        $this->catagories = Catagory::all();

        $this->name = "";
        $this->mount();
    }

    public function toggleUpdate($catagory_id){
        $this->togglePop = true;
        $this->updateCatagory_id = $catagory_id;
        $catagory = Catagory::find($catagory_id);
        $this->updateCatagory = $catagory->name;
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }

    public function updateCatagory($catagory_id){
        $this->validate([
            'updateCatagory' => 'required'
        ]);
        $catagory = Catagory::find($catagory_id);
        $catagory->name = $this->updateCatagory;
        $catagory->save();

        session()->flash('success', 'Catagory succesfully Updated!');
        $this->mount();
        $this->togglePop = false;
    }
}