<?php

namespace App\Http\Livewire\Products;

use App\Models\Brands;
use Livewire\Component;

class ProductsBrands extends Component
{
    public $brands, $name, $updateBrand, $updateBrand_id = 0, $togglePop = false;

    public function render()
    {
        return view('livewire.products.products-brands');
    }

    public function mount(){
        $this->brands = Brands::orderBy('id', 'desc')->get();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name'=>'required|string|unique:brands',
        ]);
    }

    public function saveData(){
        $this->validate([
            'name' => 'required|string|unique:brands'
        ]);
        Brands::create([
            'name' => $this->name
        ]);
        session()->flash('success', 'Brand succesfully added!');
        $this->catagories = Brands::all();

        $this->name = "";

        $this->mount();
    }

    public function toggleUpdate($brand_id){
        $this->togglePop = true;
        $this->updateBrand_id = $brand_id;
        $brand = Brands::find($brand_id);
        $this->updateBrand = $brand->name;
    }

    public function togglePopClose(){
        $this->togglePop = false;
    }

    public function updateBrand($brand_id){
        $this->validate([
            'updateBrand' => 'required'
        ]);
        $brand = Brands::find($brand_id);
        $brand->name = $this->updateBrand;
        $brand->save();

        session()->flash('success', 'Brand succesfully Updated!');
        $this->mount();
        $this->togglePop = false;
    }
}