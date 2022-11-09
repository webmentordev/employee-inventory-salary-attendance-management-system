<?php

namespace App\Http\Livewire\Products;

use App\Models\Brands;
use App\Models\Stocks;
use Livewire\Component;
use App\Models\Catagory;
use App\Models\Products;
use App\Models\Subunits;
use App\Models\StockHistory;
use Livewire\WithFileUploads;

class ProductsAdd extends Component
{
    use WithFileUploads;
    public $name, $price, $product, $stocks_id, $stock, $brands, $brand_id; 
    public $catagory_id, $catagories, $units_id, $image, $units;

    public function render()
    {
        return view('livewire.products.products-add');
    }

    public function mount(){
        $this->catagories = Catagory::all();
        $this->units = Subunits::all();
        $this->stocks = Stocks::with('main_unit')->where('products_id', null)->get();
        $this->brands = Brands::all();
    }

    public function updated($field){
        $this->validateOnly($field, [
            'name'=>'required|unique:products',
            'stocks_id'=>'required|numeric',
            'catagory_id'=>'required',
            'units_id'=>'required|numeric',
            'price'=>'required|numeric',
            'brand_id'=>'nullable|numeric',
            'image'=>'required|image|mimes:png,jpg'
        ]);
    }


    public function saveData(){
        $this->validate([
            'name'=>'required|unique:products',
            'stocks_id'=>'required|numeric',
            'catagory_id'=>'required',
            'units_id'=>'required|numeric',
            'price'=>'required|numeric',
            'brand_id'=>'nullable|numeric',
            'image'=>'required|image|mimes:png,jpg'
        ]);

        $code = rand(0000000000,9999999999);
        $validate = Products::where('barcode', $code)->get();

        if($validate->count() > 0){
            $code = rand(00000000000,99999999999);
        }

        $product = Products::create([
            'name'=>$this->name,
            'stocks_id'=>$this->stocks_id,
            'catagory_id'=>$this->catagory_id,
            'units_id' => $this->units_id,
            'price'=>$this->price,
            'brand_id'=>$this->brand_id,
            'image'=>$this->image->store('products'),
            'barcode'=> $code,
        ]);

        $stock = Stocks::find($this->stocks_id);
        $stock->products_id = $product->id;
        $stock->status = "Assigned";
        $stock->save();

        session()->flash('success', 'Product Successfully Added to the database');

        $this->mount();
    }
}