<?php

namespace App\Http\Livewire\Products;

use App\Models\Units;
use Livewire\Component;
use App\Models\Subunits;

class ProductsSubunits extends Component
{
    public $units, $subunits, $subunit, $unit, $updateSubunit, $updateSubunit_id = 0, $togglePop = false;

    public function render()
    {
        return view('livewire.products.products-subunits');
    }

    public function mount(){
        $this->units = Units::all();
        $this->subunits = Subunits::with('main_unit')->orderBy('units_id', 'asc')->get();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'unit'=>'required|numeric',
            'subunit'=>'required'
        ]);
    }

    public function saveData(){
        $this->validate([
            'unit' => 'required|numeric',
            'subunit'=>'required'
        ]);

        $dupliFilter = Subunits::where('subunit', $this->subunit)->where('units_id', $this->unit)->get();

        if(count($dupliFilter) == 0){
            Subunits::create([
                'units_id' => $this->unit,
                'subunit'=>$this->subunit
            ]);
    
            session()->flash('success', 'Subunit succesfully added!');
            $this->subunits = Subunits::with('main_unit')->orderBy('units_id', 'asc')->get();
            $this->subunit = "";
        }else{
            session()->flash('failed', 'Subunit already exist! It must be unique.');
        }
    }


    public function toggleUpdate($subunit_id){
        $this->togglePop = true;
        $this->updateSubunit_id = $subunit_id;
        $subunit = Subunits::find($subunit_id);
        $this->updateSubunit = $subunit->subunit;
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }

    public function updateSubunit($subunit_id){
        $this->validate([
            'updateSubunit' => 'required|numeric'
        ]);
        $subunit = Subunits::find($subunit_id);
        $subunit->subunit = $this->updateSubunit;
        $subunit->save();

        session()->flash('success', 'Subunit succesfully Updated!');
        $this->mount();
        $this->togglePop = false;
    }
}